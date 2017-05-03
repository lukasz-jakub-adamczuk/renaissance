        <div>
            <header class="inner">
                <h2>Publicystyka</h2>
            </header>
            <div class="wrapper">
                <section class="items">
                    {if $aCategories}
                    {foreach from=$aCategories item=cat}<article class="item">
                        <a href="{$base}/{#story#}/{$cat.slug}" class="block m-item">
                            <span>{$cat.name|stripslashes|humanize}</span>
                            <!-- <span class="total">{$cat.items}</span> -->
                        </a>
                        <footer>
                            <small>{$cat.items}</small>
                        </footer>
                    </article>{/foreach}
                    {else}
                    <p>Brak kategorii</p>
                    {/if}
                </section>
            </div>
        </div>