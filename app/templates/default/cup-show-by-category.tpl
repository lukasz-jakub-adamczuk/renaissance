        <section>
            {if isset($aObject)}
            <header class="inner">
                <h2>{$categoryName}</h2>
                <!-- <h3>{$smarty.get.slug}</h3> -->
            </header>
            <div class="_content">
                <div class="inner center">
                    {if not empty($aObject.description)}
                    <p>{$aObject.description|stripslashes|humanize}</p>
                    {/if}
                    <p>
                        <a href="{$base}/{#cup#}/{$smarty.get.category}/terminarz">Terminarz</a> - <a href="{$base}/{#cup#}/{$smarty.get.category}/klasyfikacja">Klasyfikacja</a>
                    </p>
                </div>
            {foreach from=$aGroups item=player key=pk}{if ($player@index mod 4) eq 0}<h3 class="center">Grupa {$player.group}</h3>{/if}<div class="front-item player-item col-3">
                <!--<p class="inner-item col-3">-->
                    <a href="{$base}/{#cup#}/{$smarty.get.category}/{$player.slug}" class="front-item-content m-item">
                        <img src="{$base}/assets/cup/{$smarty.get.category}/{$pk}m.jpg">
                        <h3>{$player.name}</h3>
                    </a>
                    {*<span class="frame-label">
                        <a href="{$base}/{#cup#}/{$smarty.get.category}/{$player.slug}">{$player.name}</a>
                    </span>*}
                <!--</p>-->
            </div>{/foreach}
            </div>
            {else}
            {include file='common/not-found.tpl'}
            {/if}
        </section>
        