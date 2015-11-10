<header class="inner{if isset($aCoverImage)} cover-header{/if}">
				<h2 id="article-title" itemprop="name">{$aArticle.title|stripslashes} <small class="tag">{$aArticle.id}</small> <small class="tag"><a href="{$base|replace:'renaissance':'ivy'}/article/{$aArticle.id}">edycja</a></small></h2>
				<h3><a href="{$base}/{#$ctrl#}/{$aArticle.category_slug}">{$aArticle.category_name}</a></h3>
			</header>