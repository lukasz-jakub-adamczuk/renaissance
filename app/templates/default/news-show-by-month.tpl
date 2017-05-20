        <section>
            <header class="inner">
                <h2>Archiwum {$smarty.get.month}/{$smarty.get.year}</h2>
            </header>
            <div class="main-items">
                {if $aActivities}
                {foreach from=$aActivities item=a}<article class="front-item col-3">
                    <a href="{$base}/{#news#}/{$smarty.get.year}/{$smarty.get.month}/{$a.creation_date|date_format:"%d"}/{$a.slug}" class="front-item-content m-item">
                        <span>{$a.title|stripslashes|humanize}</span>
                        <!-- <time>{$a.creation_date|date_format:"%d-%m-%Y"}</time> -->
                    </a>
                    <footer>
                        <time>{$a.creation_date|date_format:"%d-%m-%Y"}</time>
                        {if $a.verified}<small class="icon-checkmark" title="Treść zgodna ze standardami"></small>{/if}
                    </footer>
                </article>{/foreach}
                {else}
                <p>Brak aktualności</p>
                {/if}
            </div>
        </section>