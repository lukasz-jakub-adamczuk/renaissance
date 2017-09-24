<article id="main-text"{if $article.template eq 'review'} itemtype="http://schema.org/Product"{/if}>
    {include file='partials/article-header.tpl'}
    <!-- <div class="wrapper inside"> -->
        <div class="content-meta">
            <a href="{$base}/{#user#}/{$article.author_slug}">{$article.author_name}</a> - <time>{$article.creation_date|date_format:"%d %B %Y, %H:%M"|localize_date}</time>
            {include file='partials/comments-counter.tpl'}
        </div>
        
        <div class="social-media">
            {*include file='partials/fb-like.tpl'*}
        </div>
        <section class="article-content {$article.template}">
            {include file='partials/standard-notice.tpl'}

            {include file='partials/game-logo.tpl'}
            {include file='partials/game-info.tpl'}
            {include file='partials/music-info.tpl'}
            
            {$article.markup|stripslashes|gb_replace|replace:"image/":"../../i/"|picture|figure|mediabox|humanize}
        </section>
        <section>    
            {include file='partials/screens.tpl'}
        </section>
        {if $article.template eq 'intro'}
        <section class="main-items">
            {if $articles}
            <h2>Artykuły</h2>
            {include file='partials/list-items.tpl' list=$articles col=title url=url entity=#article# footer='human-date'}
            {else}
            <p>Brak artykułów</p>
            {/if}
        </section>
        {/if}
        {*<section>
            <p>Niech SquareZone będzie najlepsze! Popraw tekst i wyślij do weryfikacji.</p>
            <button id="edit-text-tgr" class="button">Edytuj ten tekst</button>
        </section>*}
        <footer class="article-footer">
            {include file='partials/rating.tpl'}
            {include file='partials/statistics.tpl'}
        </footer>
    <!-- </div> -->
</article>
{include file='partials/ratings.tpl'}

<div>
    <div class="inner" style="border: 1px solid #aaa;">
        {include file='partials/fb-comments.tpl'}
    </div>
</div>
{include file='partials/comments.tpl' commentPrimaryKey=$commentPrimaryKey}
