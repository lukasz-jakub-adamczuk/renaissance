<section>
    <header class="inner">
        <h2>Wyszukiwarka</h2>
        {if $total}
        <h3>Znaleziono {$total} wyników</h3>
        {else}
        <h3>Brak wyników</h3>
        {/if}
    </header>
    <!-- <p>total: {$navigator.total}, fetched: {$navigator.fetched}</p> -->
    
    <section class="inner main-items">
        {if $entries}
        {include file='partials/list-items.tpl' list=$entries entity=#news# col=title url=url footer='human-date'}
        {else}
        <p>Brak aktualności</p>
        {/if}
    </section>
</section>
