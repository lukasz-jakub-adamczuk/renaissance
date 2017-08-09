<header class="inner{if isset($mainImage)} cover-header{/if}">
                <h2 id="article-title" itemprop="name">{$article.title|stripslashes} <small class="tag">{$article.id}</small> <small class="tag"><a href="{$base|replace:'renaissance':'ivy'}/article/{$article.id}">edycja</a></small></h2>
                <h3><a href="{$base}/{#$ctrl#}/{$article.category_slug}">{$article.category_name}</a></h3>
            </header>