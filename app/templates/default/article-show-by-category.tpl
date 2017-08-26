        <header class="inner">
            <h2>{$category}</h2>
        </header>
        <section class="inner main-items">
            {if $articles}
            {include file='partials/list-items.tpl' list=$articles col=title url=slug footer="human-date"}
            {else}
            <p>Brak gier</p>
            {/if}
        </section>