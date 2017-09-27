<h2>Archiwum {$smarty.get.year}</h2>
<section class="main-items year-grid">
    {if $entries}
    {include file='partials/list-items.tpl' list=$entries col=col url=month footer=counter}
    {else}
    <p>Brak aktualności</p>
    {/if}
</section>