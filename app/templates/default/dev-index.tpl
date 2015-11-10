		<article{if $article.review} class="bg-cover" style="background-image: url(imgs/games/{$game.short}/game-bg-cover.jpg);"{/if}>
			<header class="inner">
				<h2>Articles</h2>
				<h3>all articles</h3>
			</header>
			<div class="wrapper">
				{foreach from=$aArticles item=aArticle}
				<h2>{$aArticle.title|stripslashes}</h2>
				<h2>{$aArticle.category_slug|stripslashes}</h2>
				<section>
					{$aArticle.markup|stripslashes|gb_replace|replace:"image/":"../../i/"}
				</section>
				{/foreach}
			</div>
		</article>
		{include file='common/ratings.tpl'}
		{include file='common/comments.tpl'}