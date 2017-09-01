        <section>
            {if isset($aGroups)}
            
            <div class="content">
                <header>
                    <h2>Klasyfikacja</h2>
                    <h3>{$categoryName}</h3>
                </header>
                <!--<div class="inner center">-->
                    <p>
                        <a href="{$base}/{#cup#}/{$smarty.get.category}/terminarz">Terminarz</a>
                    </p>
                <!--</div>-->
            {foreach from=$aGroups item=group key=gk}
                <h3 class="cup-group-header_">Grupa {$gk|upper}</h3>
                <div class="cup-group-legend">
                    <span>Postać</span>
                    <span>Pojedynki</span>
                    <span>Punkty</span>
                    <span>Głosy zdobyte</span>
                    <span>Głosy stracone</span>
                </div>
                <ol class="cup-group">
                    {foreach from=$group item=player key=pk}<li>
                        <a href="{$base}/{#cup#}/{$smarty.get.category}/{$player.slug}" class="name">
                            <img src="{$base}/assets/cup/{$smarty.get.category}/{$pk}m.jpg" width="32" height="32"><span class="name">{$player.name}</span>
                        </a>
                        <span>{$player.battles}</span>
                        <span class="points">{$player.points}</span>
                        <span>{$player.won}</span>
                        <span>{$player.lost}</span>
                    </li>{/foreach}
                </ol>
            {/foreach}
            </div>
            {else}
            {include file='partials/not-found.tpl'}
            {/if}
        </section>
        