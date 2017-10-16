<section>
    {if isset($aObject)}
    <header class="inner_">
        <h2>{$categoryName}</h2>
        <!-- <h3>{$smarty.get.slug}</h3> -->
    </header>
    <div class="_content main-items cup-grid">
        <div class="main-items">
            {if not empty($aObject.description)}
            <!-- <p>{$aObject.description|stripslashes|humanize}</p> -->
            <h3>1 miejsce</h3>
            <img src="{$aObject.description}" alt="">
            {/if}
            <p>
                <a href="{$base}/{#cup#}/{$smarty.get.category}/terminarz">Terminarz</a> - <a href="{$base}/{#cup#}/{$smarty.get.category}/klasyfikacja">Klasyfikacja</a>
            </p>
        </div>
    
    {foreach from=$aGroups item=player key=pk}{if ($player@index mod 4) eq 0}<h3 class="center">Grupa {$player.group}</h3>{/if}<div class="front-item player-item regular-item">
        <a href="{$base}/{#cup#}/{$smarty.get.category}/{$player.slug}" class="front-item-content m-item">
            <img src="{$base}/assets/cup/{$smarty.get.category}/{$pk}m.jpg" width="75" height="75" alt="{$player.name} image">
            <h3>{$player.name}</h3>
        </a>
    </div>{/foreach}
    </div>
    {else}
    {include file='partials/not-found.tpl'}
    {/if}
</section>
