<main class="mdl-layout__content">
<div class="mdl-layout__tab-panel is-active" id="home">
    <div class="mdl-grid">
        <div class="welcome mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-cell--4-col-phone mdl-cell--8-col-tablet mdl-cell--12-col-desktop">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-500">
                <h2 class="mdl-card__title-text mdl-color-text--grey-50">
                    <?php
                        content('welcome');
                    ?>
                </h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                    <?php
                        content('description');
                    ?>
            </div>
        </div>

        <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--3-col-desktop">
            <div class="mdl-card__title mdl-card--expand mdl-color--indigo-500">
                <h2 class="mdl-card__title-text">
                    <div class="icon material-icons">line_style</div>Genome
                </h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Interactive visualization of the genome with highlighted (1) neural genes and (2) genes associated with neuropsychiatric diseases ontology semantic.  
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="<?php echo $url['genome'] ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-upgraded=",MaterialButton,MaterialRipple">
Explore
<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
            </div>
        </div>

        <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--3-col-desktop">
            <div class="mdl-card__title mdl-card--expand mdl-color--purple-500">
                <h2 class="mdl-card__title-text">
                    <div class="icon material-icons">trending_up</div>Expression
                </h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Interactive visualization of gene expression data of 16 female and 9 male marmoset tissues with tools for functional (ontology) enrichment analysis and protein-protein-network.
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="<?php echo $url['expression'] ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-upgraded=",MaterialButton,MaterialRipple">
Explore
<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
            </div>
        </div>

        <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--3-col-desktop">
            <div class="mdl-card__title mdl-card--expand mdl-color--brown-500">
                <h2 class="mdl-card__title-text">
                    <div class="icon material-icons">shuffle</div>Splicing
                </h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Alternative splicing events (Exon skipping, Alt 5' or 3' Splice Site and Intron retention) on a tissue-based perspective.
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="<?php echo $url['splicing'] ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-upgraded=",MaterialButton,MaterialRipple">
Explore
<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
            </div>
        </div>

        <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--3-col-desktop">
            <div class="mdl-card__title mdl-card--expand mdl-color--teal-500">
                <h2 class="mdl-card__title-text">
                    <div class="icon material-icons">help</div>Help
                </h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Detailed guidelines of CajaDB's functionalities.
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="<?php echo $url['help'] ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-upgraded=",MaterialButton,MaterialRipple">
Read More
<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
            </div>
        </div>
    </div>
</div>