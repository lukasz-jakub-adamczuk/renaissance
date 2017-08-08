        <header class="inner">
            <h2>{$category|capitalize}</h2>
        </header>
        <section class="inner main-items">
            {if $articles}
            {include file='partials/list-articles.tpl' list=$articles entity=#story#}
            {else}
            <p>Brak publicystyki</p>
            {/if}
        </section>