<section>
    <header class="inner">
        <h2>Archiwum {$smarty.get.year}</h2>
    </header>
    <section class="inner main-items">
        {if $entries}
        {include file='partials/list-items.tpl' list=$entries col=col url=month footer=counter}
        {else}
        <p>Brak aktualności</p>
        {/if}
    </section>
</section>