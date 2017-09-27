<h2>Archiwum {$smarty.get.month}/{$smarty.get.year}</h2>
<section class="main-items regular-grid">
    {if $entries}
    {include file='partials/list-items.tpl' list=$entries col=title url=url footer=date}
    {else}
    <p>Brak aktualności</p>
    {/if}
</section>