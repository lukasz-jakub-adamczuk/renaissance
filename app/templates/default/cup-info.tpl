        <section>
            {if isset($aPlayer)}
            <header class="inner">
                <h2>{$aPlayer.name}</h2>
                <h3>{$categoryName}</h3>
            </header>
            <div class="content">
                <img src="{$base}/assets/cup/{$smarty.get.category}/{$aPlayer.id_cup_player}.jpg">
                <p>
                    {$aPlayer.description|stripslashes|humanize}
                </p>
            </div>
            {else}
            {include file='partials/not-found.tpl'}
            {/if}
        </section>
        