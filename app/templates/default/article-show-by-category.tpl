        <header class="inner">
            <h2>{$category}</h2>
        </header>
        <section class="inner main-items">
            {if $articles}
            {include file='partials/list-articles.tpl' list=$articles entity=#article#}
            {else}
            <p>Brak gier</p>
            {/if}
        </section>