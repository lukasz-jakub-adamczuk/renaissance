<header class="inner">
    <h2>Mistrzostwa</h2>
</header>
<div class="battle">
    <h3 class="center-header">{$cupBattle.id_cup_battle|date_format:'%d-%m-%Y'}</h3>
    <form id="cup-form" method="post" action="{$base}/form/vote">
        <input type="hidden" name="match[player1]" value="{$cupBattle.player1}">
        <input type="hidden" name="match[player2]" value="{$cupBattle.player2}">

        <span class="battle-player" style="text-align: center;">
            <a href="{$base}/{#cup#}/{$cupBattle.cup_slug}/{$cupBattle.player1_slug}" class="match-item battle-person" data-person="{$cupBattle.player1_name}" style="width: auto;">
                <img src="{$base}/assets/cup/{$cupBattle.cup_slug}/{$cupBattle.player1}.jpg" width="" height="" alt="{$cupBattle.player1_slug}" class="large-visible">
                <img src="{$base}/assets/cup/{$cupBattle.cup_slug}/{$cupBattle.player1}m.jpg" width="" height="" alt="{$cupBattle.player1_slug}" class="small-visible">
            </a>
            {if $usr::set()}
            {if $canVote}
            <button type="submit" name="match[vote]" value="{$cupBattle.player1}" class="button mtb" data-player="1">Głosuj</button>
            {/if}
            {/if}
        </span><!--
        --><span class="points" style="font-size: 2em; padding: .5em;">
            {$cupBattle.score1} - {$cupBattle.score2}
        </span><!--
        --><span class="battle-player" style="text-align: center;">
            <a href="{$base}/{#cup#}/{$cupBattle.cup_slug}/{$cupBattle.player2_slug}" class="match-item battle-person" data-person="{$cupBattle.player2_name}" style="width: auto; text-align: center;">
                <img src="{$base}/assets/cup/{$cupBattle.cup_slug}/{$cupBattle.player2}.jpg" width="" height="" alt="{$cupBattle.player2_slug}" class="large-visible">
                <img src="{$base}/assets/cup/{$cupBattle.cup_slug}/{$cupBattle.player2}m.jpg" width="" height="" alt="{$cupBattle.player2_slug}" class="small-visible">
            </a>
            {if $usr::set()}
            {if $canVote}
            <button type="submit" name="match[vote]" value="{$cupBattle.player2}" class="button mtb" data-player="2">Głosuj</button>
            {/if}
            {/if}
        </span>
    </form>
    {if $usr::set()}
        {if $canVote eq false}
        <p>
            <span class="info" style="padding: .5em;">Głos został już oddany!</span>
        </p>
        {/if}
    {else}
        <p>
            <span class="info" style="padding: .5em;">Logowanie konieczne do głosowania!</span>
        </p>
    {/if}
</div>