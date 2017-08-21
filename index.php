<?php
$content = array(
    'welcome' => 'Welcome to CajaDB knowledgebase',
    'description' => "Welcome to CajaDB, an integrated web resource of marmoset biological data.
    <br><br>Here you will find genomic, expression and alternative splicing data to facilitate the study of an important animal model for neuropsychiatric and social behavior research.
    <br><br>Detailed guidelines of CajaDB's functionalities can be found in 'help'."
);

include "render.php";
template(__FILE__);
?>