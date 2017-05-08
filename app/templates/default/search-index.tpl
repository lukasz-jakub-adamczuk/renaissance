        <section>
            <header class="inner">
                <h2>Wyszukiwarka</h2>
                {if $iTotal}
                <h3>Znaleziono {$iTotal} wyników</h3>
                {else}
                <h3>Brak wyników</h3>
                {/if}
            </header>
            <!-- <p>total: {$aNavigator.total}, fetched: {$aNavigator.fetched}</p> -->
            
            {if $aActivities}
            <div class="items">
                {foreach from=$aActivities item=a}<article class="item">
                    <a href="{$base}/{#news#}/{$a.creation_date|date_format:"%Y"}/{$a.creation_date|date_format:"%m"}/{$a.creation_date|date_format:"%d"}/{$a.slug}" class="block m-item">
                        <span>{$a.title|stripslashes|humanize}</span>
                        
                    </a>
                    <footer>
                        <time>{$a.creation_date|date_format:"%d-%m-%Y"}</time>
                    </footer>
                </article>{/foreach}
            </div>
            {else}
            <p>Brak aktualności</p>
            {/if}
        </section>
