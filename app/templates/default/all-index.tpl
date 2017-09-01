<header class="inner">
    <h2>{$header|default:'Serwis'}</h2>
</header>
<section class="inner main-items">
    {if $items}
    {include file='partials/list-items.tpl' list=$items col=name url=slug entity=#page#}
    {else}
    <p>Brak treści</p>
    {/if}
</section>