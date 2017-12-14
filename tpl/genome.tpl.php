<main class="mdl-layout__content">
<div class="mdl-layout__tab-panel is-active" id="expression">
    <div class="mdl-grid">

        <div class="demo-cards f mdl-cell mdl-cell--4-col-phone mdl-cell--2-col-tablet mdl-cell--2-col-desktop mdl-grid mdl-grid--no-spacing">

            <div class="search mdl-card mdl-shadow--2dp mdl-cell mdl-cell--12-col">
                <div class="mdl-card__title mdl-card--expand mdl-color--indigo-500">
                    <h2 class="mdl-card__title-text">
                        <div class="icon material-icons">find_replace</div>Filter
                    </h2>
                </div>
                <div class="mdl-card__supporting-text mdl-color-text--grey-600" style="text-align: center;">
                    <form action="#">
                        <div class="mdl-selectfield">
                            <label>Phenotype</label>
                            <select id="phenotype" class="browser-default" required>
                                <option value="" selected>Any</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="mdl-card__actions mdl-card--border">
                    <button id="form-reset" class="mdl-button mdl-js-button mdl-button--primary">
                        Reset
                    </button>
                    <button id="filter-phenotype" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        Apply
                    </button>    
                </div>
            </div>

        </div>

        <div id="chromosummary" class="mdl-cell mdl-cell--6-col-tablet mdl-cell--10-col-desktop">
        </div>

    </div>
</div>