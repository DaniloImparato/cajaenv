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
            <div class="mdl-card__title mdl-card--expand mdl-color--purple-500">
                <h2 class="mdl-card__title-text">
                    <div class="icon material-icons">trending_up</div>Expression
                </h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Interactive visualization of gene expression data.
                <br>16 female and 9 male marmoset tissues.
                <br>
                <br>(Cortez et al. 2014; Pipes et al. 2013; Maudhoo et al. 2014)
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="<?php echo $url['expression'] ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-upgraded=",MaterialButton,MaterialRipple">
Explore
<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
            </div>
        </div>

        <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--3-col-desktop">
            <div class="mdl-card__title mdl-card--expand mdl-color--indigo-500">
                <h2 class="mdl-card__title-text">
                    <div class="icon material-icons">line_style</div>Genome
                </h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Interactive visualization of genome associated with disease ontology semantic.
                <br>
                <br>(Worley et al. 2014)
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="<?php echo $url['genome'] ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-upgraded=",MaterialButton,MaterialRipple">
Explore
<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
            </div>
        </div>

        <div class="demo-updates mdl-card mdl-shadow--2dp mdl-cell mdl-cell--2-col-phone mdl-cell--4-col-tablet mdl-cell--3-col-desktop">
            <div class="mdl-card__title mdl-card--expand mdl-color--brown-500">
                <h2 class="mdl-card__title-text">
                    <div class="icon material-icons">device_hub</div>Network
                </h2>
            </div>
            <div class="mdl-card__supporting-text mdl-color-text--grey-600">
                Protein association network.
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="<?php echo $url['network'] ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-upgraded=",MaterialButton,MaterialRipple">
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
                Detailed guidelines of CALLI's functionalities.
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="<?php echo $url['help'] ?>" class="mdl-button mdl-js-button mdl-js-ripple-effect" data-upgraded=",MaterialButton,MaterialRipple">
Read More
<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
            </div>
        </div>
    </div>
</div>