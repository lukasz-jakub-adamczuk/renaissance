		<section>
			<header class="inner">
				<h2>Archiwum {$smarty.get.year}</h2>
			</header>
			<div class="items">
				{if $aActivities}
				{foreach from=$aActivities item=a}<article class="item">
					<a href="{$base}/{#news#}/{$a.year}/{if $a.month lt 10}0{$a.month}{else}{$a.month}{/if}" class="block m-item">
						<span>{$a.month}/{$a.year}</span>
						<!-- <span>{$a.month} {$a.month|date_format:"%B"} {$a.year}</span> -->
						<!-- <span class="total">{$a.items}</span> -->
					</a>
					<footer>
						<small>{$a.items}</small>
					</footer>
				</article>{/foreach}
				{else}
				<p>Brak aktualności</p>
				{/if}
			</div>
		</section>