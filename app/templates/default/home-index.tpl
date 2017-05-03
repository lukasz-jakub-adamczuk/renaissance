        <section>
            <header class="inner">
                <h2>Aktualności</h2>
            </header>
            {include file='common/stream-items.tpl' type=news items=$aActivities.news}

            <!-- cup battle -->
            {if isset($aMatch)}
            {include file='cup-battle.tpl'}
            {/if}
            
            <header class="inner">
                <h2>Gry</h2>
            </header>
            {include file='common/stream-items.tpl' type=article items=$aActivities.article}

            <header class="inner">
                <h2>Publicystyka</h2>
            </header>
            {include file='common/stream-items.tpl' type=story items=$aActivities.story}
        </section>
        