<?php
$content = array(
    'welcome' => 'Welcome to CAJA database',
    'description' => "Welcome to CajaDB, an integrated web resource of marmoset biological data.
                <br> Here you will find genomic, expression and protein-protein-interaction data to facilitate
                the study of an important animal model for neuropsychiatric research.
                <br> Detailed guidelines of CALLI's functionalities can be found in 'help'."
);

include "render.php";
template(__FILE__);
?>