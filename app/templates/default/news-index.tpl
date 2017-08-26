<section>
    <header class="inner">
        <h2>Archiwum</h2>
    </header>
    <section class="inner main-items">
        {if $entries}
        {include file='partials/list-items.tpl' list=$entries entity=#news# col=year url=year footer=counter}
        {else}
        <p>Brak aktualności</p>
        {/if}
    </section>
</section>