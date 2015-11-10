		<div>
			<header class="inner">
				<h2>Galerie</h2>
				<h3>{$sCategory|capitalize}</h3>
			</header>
			<!-- <div class="wrapper"> -->
				<section class="items">
					{if $aArticles}
					{foreach from=$aArticles item=art}<article class="item">
						<a href="{$base}/{#gallery#}/{$art.category_slug}/{$art.slug}" class="block s-item">
							<span>{$art.name|stripslashes|humanize}</span>
							
							<!-- <time>{$art.creation_date|date_format:"%d-%m-%Y"}</time> -->
						</a>
						<footer>
							<time>{$art.creation_date|date_format:"%d-%m-%Y"}</time>
							<!-- {if isset($art.verified) and $art.verified}<small class="icon-checkmark" title="Treść zgodna ze standardami"></small>{/if} -->
						</footer>
					</article>{/foreach}
					{else}
					<p>Brak galerii</p>
					{/if}
				</section>
			<!-- </div> -->
		</div>