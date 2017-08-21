<?php
$content = array(
    'welcome' => 'About CajaDB',
    'description' => "Welcome to CajaDB, an integrated web resource of marmoset biological data.
    <br>Here you will find genomic, expression and alternative splicing data to facilitate the study of an important animal model for neuropsychiatric and social behavior research.
    <br>Detailed guidelines of CajaDB's functionalities can be found in 'help'."
);

include "render.php";
template(__FILE__);
?>