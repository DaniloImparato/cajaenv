<?php

$url = array(
    'home' => 'index.php',
    'expression' => 'expression.php',
    'genome' => 'genome.php',
    'splicing' => 'splicing',
    'network' => 'network.php',
    'help' => 'help.php'
);

function content($contentIndex, $fallback = 'Content not found', $prepend = '', $append = '' ) {
    global $content;
    echo (isset($content[$contentIndex]) ? $prepend.$content[$contentIndex].$append : $fallback);
}

function template($tplName) {
    global $url;
    global $tpl;
    global $cluster;
    $cluster = false;

    global $chromosummary;
    $chromosummary = false;

    $filename = basename($tplName, '.php');
    $tpl = "tpl/".$filename.".tpl.php";

    if($filename == 'expression')
        $cluster = true;

    if($filename == 'genome')
        $chromosummary = true;
    
    if(!file_exists($tpl))
        $tpl = 'tpl/index.tpl.php';
    
    include "template.php";
}

?>