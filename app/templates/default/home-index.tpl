        <section>
            <header class="inner">
                <h2>Aktualności</h2>
            </header>
            {include file='partials/front-items.tpl' type=news items=$activities.news}

            <!-- cup battle -->
            {if $cupBattle}
            {include file='cup-battle.tpl'}
            {/if}
            
            <header class="inner">
                <h2>Gry</h2>
            </header>
            {include file='partials/front-items.tpl' type=article items=$activities.article}

            <header class="inner">
                <h2>Publicystyka</h2>
            </header>
            {include file='partials/front-items.tpl' type=story items=$activities.story}
        </section>
        