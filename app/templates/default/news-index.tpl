<h2>Archiwum</h2>
<section class="main-items archive-grid">
    {if $entries}
    {include file='partials/list-items.tpl' list=$entries entity=#news# col=year url=year footer=counter}
    {else}
    <p>Brak aktualności</p>
    {/if}
</section>