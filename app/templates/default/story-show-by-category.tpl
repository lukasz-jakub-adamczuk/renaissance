<h2>{$category|capitalize}</h2>
<section class="main-items regular-grid">
    {if $articles}
    {include file='partials/list-items.tpl' list=$articles col=title url=slug footer="human-date"}    {else}
    <p>Brak publicystyki</p>
    {/if}
</section>