<section>
    <header class="inner">
        <h2>Galerie</h2>
    </header>
    <section class="inner main-items">
        {if $categories}
        {include file='partials/list-items.tpl' list=$categories col=name url=slug footer=counter}
        {else}
        <p>Brak galerii</p>
        {/if}
    </section>
</section>