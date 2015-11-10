		<div>
			<header class="inner">
				<h2>Publicystyka</h2>
				<h3>{$sCategory|capitalize}</h3>
			</header>
			<div class="wrapper">
				<section class="items">
					{if $aArticles}
					{foreach from=$aArticles item=art}<article class="item">
						<a href="{$base}/{#story#}/{$art.category_slug}/{$art.slug}" class="block s-item">
							<span>{$art.title|stripslashes|humanize}</span>
							<!-- <time>{$art.creation_date|date_format:"%d-%m-%Y"}</time> -->
							<!-- <span>{$art.id_story}</span> -->
						</a>
						<footer>
							<!-- <time>{$art.creation_date|date_format:"%d-%m-%Y"}</time> -->
							<time>{$art.creation_date|humanize_date}</time>
							{if $art.verified}<small class="icon-checkmark" title="Treść zgodna ze standardami"></small>{/if}
						</footer>
					</article>{/foreach}
					{else}
					<p>Brak publicystyki</p>
					{/if}
				</section>
			</div>
		</div>