<?php
// header("Content-Type: text/plain");
header('Content-Type: application/json');

$config = parse_ini_file('config.ini');

$err_level = error_reporting(0);
$mysqli = new mysqli($config['address'], $config['user'], $config['password'], $config['db']);
error_reporting($err_level); 

if ($mysqli->connect_errno) {
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Error: " . $mysqli->connect_error . "\n";
    exit;
}

switch($_GET['type']){

    ////////////////////////////////
    // TYPE: GENE
    ////////////////////////////////
    case 'gene':
        $gene = (isset($_GET['term']) && !empty($_GET['term']) ? preg_replace("/[^a-zA-Z0-9]/","",$_GET['term']) : '');
        $data = 'SELECT g.GeneSymbol FROM Gene g WHERE g.GeneSymbol LIKE "'.$gene.'%" ORDER BY g.GeneSymbol ASC LIMIT 5;';

        if (!$data = $mysqli->query($data)) { echo "Error: " . $mysqli->error . "\n"; exit; }
        if ($data->num_rows === 0) { echo "0 results"; exit; }
        
        $output = array();

        while ($row = $data->fetch_assoc())
            $output[] = $row['GeneSymbol'];
        
        echo json_encode($output);
    break;

    ////////////////////////////////
    // TYPE: TISSUE
    ////////////////////////////////
    case 'tissue':
        $tissue = (isset($_GET['term']) && !empty($_GET['term']) ? preg_replace("/[ ]/","_",preg_replace("/[^a-zA-Z0-9 _]/","",$_GET['term'])) : '');
        $project = (isset($_GET['project']) && !empty($_GET['project']) ? preg_replace("/[^a-zA-Z0-9_]/","",$_GET['project']) : '');
        // $data = 'SELECT t.TissueName FROM Tissue t WHERE t.TissueName LIKE "%'.$tissue.'%" ORDER BY t.TissueName ASC LIMIT 5;';
        $data = 'SELECT DISTINCT t.TissueName FROM Expression e INNER JOIN Tissue t ON t.TissueID=e.TissueID WHERE e.Project="'.$project.'" AND t.TissueName LIKE "%'.$tissue.'%" ORDER BY t.TissueName ASC LIMIT 5;';

        if (!$data = $mysqli->query($data)) { echo "Error: " . $mysqli->error . "\n"; exit; }
        if ($data->num_rows === 0) { echo "0 results"; exit; }
        
        $output = array();

        while ($row = $data->fetch_assoc())
            $output[] = $row['TissueName'];
        
        echo json_encode($output);
    break;

    ////////////////////////////////
    // TYPE: PROJECT
    ////////////////////////////////
    case 'project':
        $data = 'SELECT DISTINCT e.Project FROM Expression e ORDER BY e.Project ASC;';

        if (!$data = $mysqli->query($data)) { echo "Error: " . $mysqli->error . "\n"; exit; }
        if ($data->num_rows === 0) { echo "0 results"; exit; }
        
        $output = array();

        while ($row = $data->fetch_assoc())
            $output[] = $row['Project'];
        
        echo json_encode($output);
    break;

    ////////////////////////////////
    // TYPE: TABLE
    ////////////////////////////////
    case 'table':
        $gene = (isset($_GET['gene']) && !empty($_GET['gene']) ? ' AND g.GeneSymbol IN("'.str_replace(',','","',preg_replace("/[^a-zA-Z0-9,_]/","",$_GET['gene'])).'")' : '');
        $tissue = (isset($_GET['tissue']) && !empty($_GET['tissue']) ? ' AND t.TissueName IN("'.str_replace(',','","',preg_replace("/[^a-zA-Z0-9,_]/","",$_GET['tissue'])).'")' : '');
        $cutoff = (isset($_GET['cutoff']) && !empty($_GET['cutoff']) ? preg_replace("/[^0-9\.]/","",$_GET['cutoff']) : '4000');
        $project = (isset($_GET['project']) && !empty($_GET['project']) ? ' AND e.Project="'.preg_replace("/[^a-zA-Z0-9_]/","",$_GET['project']).'"' : '');

        $female = (isset($_GET['female']) && $_GET['female']=='true' ? true : false);
        $male = (isset($_GET['male']) && $_GET['male']=='true' ? true : false);

        $data = 'SELECT
            g.GeneSymbol,
            gt.Description as Type,
            SUM(e.Fpkm) SumFpkm,
            t.TissueName,
            e.Sex,
            e.Project
        FROM Expression e
        INNER JOIN Gene g ON e.GeneID=g.GeneID
        INNER JOIN GeneType gt ON g.TypeID=gt.GeneTypeID
        INNER JOIN Tissue t ON e.TissueID=t.TissueID
        WHERE g.ProteinCoding=1 AND (' . ($female ? ($male ? 'e.Sex="f" OR e.Sex="m"' : 'e.Sex="f"') : 'e.Sex="m"') . ') '.$gene.$tissue.$project.' GROUP BY e.GeneID,e.TissueID,e.Sex,e.Project HAVING SUM(e.Fpkm) >='.$cutoff.' ORDER BY SumFpkm DESC;';

        if (!$data = $mysqli->query($data)) { echo "Error: " . $mysqli->error . "\n"; exit; }
        if ($data->num_rows === 0) { echo "0 results"; exit; }

        $table = array();
        $cond = array();

        while ($row = $data->fetch_assoc()) {
            $symbol = $row['GeneSymbol'];
            $type = $row['Type'];
            $tissue = $row['TissueName'];
            $fpkm = $row['SumFpkm'];
            $sex = $row['Sex'];
            $project = $row['Project'];

            if(!isset($table[$symbol][$tissue][$sex][$project]))
                $table[$symbol][$tissue][$sex][$project] = 0;

            $table[$symbol]['type'] = $type;

            $table[$symbol][$tissue][$sex][$project] += $fpkm;
            $cond[] = array($tissue,$sex,$project);
        }

        $cond = array_values(array_intersect_key($cond, array_unique(array_map('serialize', $cond))));

        $condNames = array('Tissue','Sex','Project');

        $str = "\t";

        for($i = 0; $i < count($cond); $i++){
            $str .= "\t".implode(',',$condNames).": ".ucwords(implode('/',$cond[$i]));
        }
        $str .= "\n";

        for($i = 0; $i < count($cond[0]); $i++){
            $str .= "\t";

            for($j = 0; $j < count($cond); $j++){
                $str .= "\t".$condNames[$i].': '.ucwords($cond[$j][$i]);
            }
            $str .= "\n";
        }


        foreach ($table as $key => $val){
            $str .= 'Gene: '.$key."\t";
            $str .= 'Type: '.$val['type'];
            foreach ($cond as $cv){
                $str .= "\t".(isset($val[$cv[0]][$cv[1]][$cv[2]]) ? $val[$cv[0]][$cv[1]][$cv[2]] : '0.0');
            }
            $str .= "\n";
        }

        // die($str);

        $descriptorspec = array(
        0 => array("pipe", "r"),  // stdin is a pipe that the child will read from
        1 => array("pipe", "w"),  // stdout is a pipe that the child will write to
        2 => array("file", $config['error'], "a") // stderr is a file to write to
        );
        $process = proc_open($config['python'].' '.$config['clustergrammer'], $descriptorspec, $pipes);

        if (is_resource($process)) {
            // 0 => writeable handle connected to child stdin
            // 1 => readable handle connected to child stdout
            // 2 => error output

            fwrite($pipes[0], $str);
            fclose($pipes[0]);

            echo stream_GET_contents($pipes[1]);
            fclose($pipes[1]);

            // close pipes before proc_close to avoid deadlock
            $return_value = proc_close($process);

            //echo "command returned $return_value\n";
        }
    break;

    case 'ppi':
        $genes = (isset($_GET['genes']) && !empty($_GET['genes']) ? str_replace(',','%0D',preg_replace("/[^a-zA-Z0-9,_]/","",$_GET['genes'])) : '');

        $curl = curl_init();
    
        curl_setopt($curl,CURLOPT_URL,"http://string-db.org/api/tsv/resolveList?identifiers=".$genes."&species=9483");
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    
        $output = curl_exec($curl);
    
        curl_close($ch);
        die(var_dump($output));
    break;
}

$data->free();
$mysqli->close();
?>