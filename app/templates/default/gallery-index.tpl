        <div>
            <header class="inner">
                <h2>Galerie</h2>
            </header>
            <div class="wrapper">
                <section class="items">
                    {if $categories}
                    {foreach from=$categories item=cat}<article class="item">
                        <a href="{$base}/{#gallery#}/{$cat.slug}" class="block m-item">
                            <span>{$cat.name|stripslashes|humanize}</span>
                        </a>
                        <footer>
                            <small>{$cat.items}</small>
                            <!-- <span class="total">{$cat.items}</span> -->
                        </footer>
                    </article>{/foreach}
                    {else}
                    <p>Brak kategorii</p>
                    {/if}
                </section>
            </div>
        </div>