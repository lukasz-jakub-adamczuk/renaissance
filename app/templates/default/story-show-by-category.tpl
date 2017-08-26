<header class="inner">
    <h2>{$category|capitalize}</h2>
</header>
<section class="inner main-items">
    {if $articles}
    {include file='partials/list-items.tpl' list=$articles col=title url=slug footer="human-date"}    {else}
    <p>Brak publicystyki</p>
    {/if}
</section>