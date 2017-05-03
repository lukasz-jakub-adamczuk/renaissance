        <header class="inner">
            <h2>Artykuły</h2>
        </header>
        <section class="inner items">
            {if $aCategories}
            {foreach from=$aCategories item=cat}<article class="item with-image">
                <a href="{$base}/{#article#}/{$cat.slug}" class="_item block m-item">
                    {*<figure>
                        {if $cat.fragment}
                        <img src="image.php?img={$cat.fragment}&size=480x270&margin=0">
                        <!-- <img src="image.php?img={$cat.fragment}&size=640x480&margins=1&x=center&y=center"> -->
                        {/if}
                    </figure>*}
                    <span>{$cat.name|stripslashes|humanize}</span>
                </a>
                <footer>
                    <!-- <small>{$cat.items|default:0}</small> -->
                </footer>
            </article>{/foreach}
            {else}
            <p>Brak kategorii</p>
            {/if}
        </section>