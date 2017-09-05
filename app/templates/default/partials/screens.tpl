{if isset($aScreens)}
    <header class="inner vam">
        <h2 class="inline-block vam">Galeria</h2>
        {if $aGallery.show_link}
        <a href="{$base}/{#article#}/{$smarty.get.category}/galeria" class="button small inline-block vam">Zobacz wszystkie</a>
        {/if}
    </header>

    <div class="gallery gallery-images{if isset($aGallery.class)} {$aGallery.class}{/if} flex-gallery">
        {foreach from=$aScreens item=image}<a href="{$base}/assets/games/{$aGallery.category_abbr}/imgs/{$image.name}">
            <figure class="w10rem ratio-16-9">
                <img class="screen" src="image.php?img=/assets/games/{$aGallery.category_abbr}/imgs/{$image.name}&size={$aGallery.size|default:160x120}&margins=1" />
            </figure>
        </a>{/foreach}
    </div>
    
{/if}