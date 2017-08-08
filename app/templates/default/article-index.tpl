        <header class="inner">
            <h2>Artykuły</h2>
        </header>
        <section class="inner main-items">
            {if $categories}
            {include file='partials/list-categories.tpl' list=$categories entity=#article#}
            {else}
            <p>Brak kategorii</p>
            {/if}
        </section>