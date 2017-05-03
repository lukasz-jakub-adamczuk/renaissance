        <header class="inner">
            <h2>{$sCategoryName}</h2>
        </header>
        <section class="inner items">
            {if $aArticles}
            {foreach from=$aArticles item=art}<article class="item">
                <a href="{$base}/{#article#}/{$art.category_slug}/{$art.slug}" class="block s-item">
                    <span>{$art.title|stripslashes|humanize}</span>
                    <!-- {if $art.verified}<small class="icon-checkmark"></small>{/if} -->
                    <!-- <time>{$art.creation_date|date_format:"%d-%m-%Y"}</time> -->
                </a>
                <footer>
                    <time>{$art.creation_date|humanize_date}</time>
                    {if $art.verified}<small class="icon-checkmark"></small>{/if}
                </footer>
            </article>{/foreach}
            {else}
            <p>Brak gier</p>
            {/if}
        </section>