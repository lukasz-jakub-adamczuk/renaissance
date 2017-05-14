        <header class="inner">
            <h2>{$sCategoryName}</h2>
        </header>
        <section class="inner">
            {if $aArticles}
            {foreach from=$aArticles item=art}<article class="front-item">
                <a href="{$base}/{#article#}/{$art.category_slug}/{$art.slug}" class="front-item-content s-item">
                    <span>{$art.title|stripslashes|humanize}</span>
                </a>
                <footer class="front-item-footer">
                    <time>{$art.creation_date|humanize_date}</time>
                    {if $art.verified}<small class="icon-checkmark"></small>{/if}
                </footer>
            </article>{/foreach}
            {else}
            <p>Brak gier</p>
            {/if}
        </section>