<header class="inner">
    <h2>{$category}</h2>
</header>
<section class="inner main-items">
    {if $articles}
    {include file='partials/list-items.tpl' list=$articles col=name url=slug footer="human-date"}
    {else}
    <p>Brak galerii</p>
    {/if}
</section>