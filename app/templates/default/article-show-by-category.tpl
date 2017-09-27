<h2>{$category}</h2>
<section class="main-items articles-grid">
    {if $articles}
    {include file='partials/list-items.tpl' list=$articles col=title url=slug footer="human-date"}
    {else}
    <p>Brak gier</p>
    {/if}
</section>