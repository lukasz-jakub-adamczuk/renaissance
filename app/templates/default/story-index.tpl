        <header class="inner">
            <h2>Publicystyka</h2>
        </header>
        <section class="inner main-items">
            {if $categories}
            {include file='partials/list-categories.tpl' list=$categories entity=#story#}
            {else}
            <p>Brak kategorii</p>
            {/if}
        </section>