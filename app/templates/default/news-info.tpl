<article>
    <header class="article-header">
        <h1>{$news.title|stripslashes|humanize}</h1>
    </header>
    <!-- <section class="article"> -->
        <div class="content-meta">
            <a href="{$base}/{#user#}/{$news.author_slug}">{$news.author_name}</a> - <time>{$news.creation_date|date_format:"%d %B %Y, %H:%M"|localize_date}</time>
            {include file='partials/comments-counter.tpl'}
        </div>
        <div class="social-media">
            {include file='partials/fb-like.tpl'}
        </div>
        <div class="article-content">
            {if isset($firstImage)}
            <div class="article-image" data-id="{$news.id_news}">
                {image file=$firstImage.name size=640x360 margin=0}
            </div>
            {/if}
            
            {$news.markup|mediabox:medium|humanize|stripslashes}
            
            {if isset($images)}
            <div class="gallery">
            {foreach from=$images item=img}<a href="{$base}{$img.name}" class="gallery-image">
                {image file=$img.name size=128x128}
            </a>{/foreach}
            </div>
            {/if}
        </div>
    <!-- </section> -->
</article>
<section class="pagination">
    {if isset($pagination.newer)}
    <a href="{$base}/{#news#}/{$pagination.newer.date}/{$pagination.newer.slug}" class="newer-item">
        {$pagination.newer.title|stripslashes}
    </a>
    {/if}
    {if isset($pagination.older)}
    <a href="{$base}/{#news#}/{$pagination.older.date}/{$pagination.older.slug}" class="older-item">
        {$pagination.older.title|stripslashes}
    </a>
    {/if}
</section>
{include file='partials/comments.tpl' commentPrimaryKey='id_news_comment'}