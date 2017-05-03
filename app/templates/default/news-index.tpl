        <section>
            <header class="inner">
                <h2>Archiwum</h2>
            </header>
            <div class="items">
            {if $aActivities}
            {foreach from=$aActivities item=a}<article class="item">
                <a href="{$base}/{#news#}/{$a.year}" class="block m-item">
                    <span>{$a.year}</span>
                    <!-- <span class="total">{$a.items}</span> -->
                </a>
                <footer>
                    <small>{$a.items}</small>
                </footer>
            </article>{/foreach}
            {else}
            <p>Brak aktualności</p>
            {/if}
        </section>