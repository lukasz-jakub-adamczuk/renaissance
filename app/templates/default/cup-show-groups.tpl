        <section>
            {if isset($aGroups)}
            <header class="inner">
                <h2>Klasyfikacja</h2>
                <h3>{$sCategoryName}</h3>
            </header>
            <div class="content">
                <div class="inner center">
                    <p>
                        <a href="{$base}/{#cup#}/{$smarty.get.category}/terminarz">Terminarz</a>
                    </p>
                </div>
            {foreach from=$aGroups item=group key=gk}
                <h3 class="group-header">Grupa {$gk|upper}</h3>
                <div class="group-legend">
                    <span>Postać</span>
                    <span>Pojedynki</span>
                    <span>Punkty</span>
                    <span>Głosy zdobyte</span>
                    <span>Głosy stracone</span>
                </div>
                <ol class="group">
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
            {include file='common/not-found.tpl'}
            {/if}
        </section>
        