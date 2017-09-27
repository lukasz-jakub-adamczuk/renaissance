<h2>Artykuły</h2>
<section class="main-items regular-grid">
    {if $categories}
    {include file='partials/list-items.tpl' list=$categories col=name url=slug footer=counter}
    {else}
    <p>Brak kategorii</p>
    {/if}
</section>