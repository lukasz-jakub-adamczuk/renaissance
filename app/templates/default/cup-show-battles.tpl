		<section>
			{if $aBattles}
			<header class="inner">
				<h2>Terminarz</h2>
				<h3>{$sCategoryName}</h3>
			</header>
			<div class="content">
				<div class="inner center">
					<p>
						<a href="{$base}/{#cup#}/{$smarty.get.category}/klasyfikacja">Klasyfikacja</a>
					</p>
				</div>
			{foreach from=$aBattles item=battle key=bk}
				<div class="battle">
					<h3 class="center-header">{$battle.id_cup_battle|date_format:'%d-%m-%Y'}</h3>
					
					<span class="battle-player-1">
						{if $battle.slug1 neq ''}
						<a href="{$base}/{#cup#}/{$smarty.get.category}/{$battle.slug1}" class="battle-person" data-person="{$battle.name1}">
							<img src="{$base}/assets/cup/{$smarty.get.category}/{$battle.player1}m.jpg" width="50" height="50" alt="{$battle.name1}">
						</a>
						{else}
						<span class="battle-person" data-person="{$aDefaults[$aBattlesKeysFlipped[$bk]][0]}">
							<img src="{$base}/assets/cup/0m.jpg" width="50" height="50" alt="?">
						</span>
						{/if}
					</span><!--
					--><span class="points">{$battle.score1}-{$battle.score2}</span><!--
					--><span class="battle-player-2">
						{if $battle.slug2 neq ''}
						<a href="{$base}/{#cup#}/{$smarty.get.category}/{$battle.slug2}" class="battle-person" data-person="{$battle.name2}">
							<img src="{$base}/assets/cup/{$smarty.get.category}/{$battle.player2}m.jpg" width="50" height="50" alt="{$battle.name2}">
						</a>
						{else}
						<span class="battle-person" data-person="{$aDefaults[$aBattlesKeysFlipped[$bk]][1]}">
							<img src="{$base}/assets/cup/0m.jpg" width="50" height="50" alt="?">
						</span>
						{/if}
					</span>
				</div>
			{/foreach}
			</div>
			{else}
			{include file='common/not-found.tpl'}
			{/if}
		</section>
		