<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CajaDB: <?php content("title","Callithrix Jacchus web resources"); ?>
    </title>
    
    <link rel="shortcut icon" href="favicon.ico">

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="clustergrammer/lib/css/custom.css" rel="stylesheet">
    <link href="clustergrammer/lib/css/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet" href="clustergrammer/lib/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/material.blue_grey-blue.min.css" />
    <link rel="stylesheet" href="https://cdn.rawgit.com/CreativeIT/getmdl-select/master/getmdl-select.min.css">
    <link rel="stylesheet" href="css/style.css" />
    
    <link rel="stylesheet" type="text/css" href="css/jquery.tagsinput.min.css" />

    <?php
        if($chromosummary) echo '<link rel="stylesheet" href="chromosummary/style.css">
        <style>
            svg {
                border: none;
                background-color: rgba(255,255,255,0);
            }
            #chromosummary {
                margin:auto;
            }
        </style>';
    ?>

    <script src="clustergrammer/lib/js/jquery-1.11.2.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>

    <script defer src="js/material.min.js"></script>
    <script defer src="https://cdn.rawgit.com/CreativeIT/getmdl-select/master/getmdl-select.min.js"></script>
    <script src="js/jquery.tagsinput.min.js"></script>
</head>

<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer mdl-layout--fixed-header">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
            <img src="images\last.png" style="margin-right: 10px;">
                <!--
                <div class="icon material-icons" style="font-color: #fff; margin-right: 32px;">android</div>
                -->
                <span class="mdl-layout-title">CajaDB<?php content("title","",$prepend=': '); ?></span>
                <div class="mdl-layout-spacer"></div>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
                    mdl-textfield--floating-label mdl-textfield--align-right">
                    <label class="mdl-button mdl-js-button mdl-button--icon" for="fixed-header-drawer-exp">
            <i class="material-icons">search</i>
            </label>
                    <div class="mdl-textfield__expandable-holder">
                        <input class="mdl-textfield__input" type="text" name="sample" id="fixed-header-drawer-exp">
                    </div>
                </div>
            </div>
        </header>
        <div class="mdl-layout__drawer mdl-shadow--6dp">
            <nav class="mdl-navigation">
                <a class="d-layout__tab mdl-navigation__link" href="<?php echo $url["home"] ?>">
                    <div class="icon material-icons">home</div>
                    Home
                </a>
                <a class="d-layout__tab mdl-navigation__link" href="<?php echo $url["expression"] ?>">
                    <div class="icon material-icons">trending_up</div>
                    Expression
                </a>
                <a class="mdl-navigation__link" href="<?php echo $url["genome"] ?>">
                    <div class="icon material-icons">line_style</div>
                    Genome
                </a>
                <a class="mdl-navigation__link" href="<?php echo $url["network"] ?>">
                    <div class="icon material-icons">device_hub</div>
                    Network
                </a>
                <a class="mdl-navigation__link" href="<?php echo $url["help"] ?>">
                    <div class="icon material-icons">help</div>
                    Help
                </a>
                <a class="mdl-navigation__link" href="#">
                    <div class="icon material-icons">copyright</div>
                    About
                </a>
            </nav>
        </div>

        <?php
            include $tpl;
        ?>

        <!--
        <footer class="mdl-mini-footer">
            <ul class="mdl-mini-footer__link-list">
                <li><a href="#">Help</a></li>
                <li><a href="#">Privacy & Terms</a></li>
            </ul>
        </footer>
        -->
        </main>
    </div>
  <!-- Required JS Libraries -->

  <?php
    if($cluster) echo '
        <script src="../clustergrammer/lib/js/d3.js"></script>
        <script src="../clustergrammer/lib/js/underscore-min.js"></script>
        <script src="../clustergrammer/lib/js/bootstrap.min.js"></script>

        <!-- Clustergrammer JS -->
        <script src="../clustergrammer/clustergrammer.js"></script>

        <!-- optional modules
        <script src="../clustergrammer/js/Enrichr_functions.js"></script>
        <script src="../clustergrammer/js/gene_info.js"></script>
        <script src="../clustergrammer/js/send_to_Enrichr.js"></script>
        -->
        
        <!-- optional modules -->
        <script src="js/Enrichrgram.js"></script>
        <script src="js/hzome_functions.js"></script>
        <script src="js/send_to_Enrichr.js"></script>

        <!-- make clustergram -->
        <script src="js/load_clustergram.js"></script>
        
        <!-- etc -->
        <script src="js/etc.js"></script>';
    else if($chromosummary) echo '
        <script src="https://d3js.org/d3.v4.min.js"></script>
        <script src="chromosummary/script.js"></script>
        <script>
            d3.tsv("chromosummary/calli_chromosomes.tsv",function(err,chromosomesData){
                if (err) throw error;
                chromosomesData.map(function(x){
                    x.size = parseInt(x.size);
                    x.phenotype = [];
                });
                getPhenotype(chromosomesData);
            });

            function getPhenotype(chromosomesData){
                d3.tsv("chromosummary/calli_gwas.tsv",function(err,phenotypeData){
                    phenotypeData.map(function(phenotype){
                        phenotype.position = parseInt(phenotype.position);
                        chromosomesData.filter(function(chromosome){
                            return chromosome.chrname==phenotype.chrname;
                        })[0].phenotype.push(phenotype);
                    })
                    chromosummary(chromosomesData);
                });
            }
        </script>';
  ?>
</body>

</html>
