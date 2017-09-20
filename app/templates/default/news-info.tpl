<header class="article-header">
    <h1>{$aNews.title|stripslashes|humanize}</h1>
</header>
<section class="article">
    <div class="content-meta">
        <a href="{$base}/{#user#}/{$aNews.author_slug}">{$aNews.author_name}</a> - <time>{$aNews.creation_date|date_format:"%d %B %Y, %H:%M"|localize_date}</time>
        {include file='partials/comments-counter.tpl'}
    </div>
    <div class="social-media">
        {include file='partials/fb-like.tpl'}
    </div>
    <article>
        {if isset($aFirstImage)}
        <div class="article-main-image" data-id="{$aNews.id_news}">
            {image file=$aFirstImage.name size=640x360 margin=0}
        </div>
        {/if}
        
        {$aNews.markup|mediabox:medium|humanize|stripslashes}
        
        {if isset($aImages)}
        <div class="gallery">
        {foreach from=$aImages item=img}<a href="{$base}{$img.name}" class="miniature">
            {image file=$img.name size=128x128}
        </a>{/foreach}
        </div>
        {/if}
    </article>
</section>
<section class="pagination">
    {if isset($aRelatedNews.newer)}
    <a href="{$base}/{#news#}/{$aRelatedNews.newer.date}/{$aRelatedNews.newer.slug}" class="newer-item">
        {$aRelatedNews.newer.title|stripslashes}
    </a>
    {/if}
    {if isset($aRelatedNews.older)}
    <a href="{$base}/{#news#}/{$aRelatedNews.older.date}/{$aRelatedNews.older.slug}" class="older-item">
        {$aRelatedNews.older.title|stripslashes}
    </a>
    {/if}
</section>
{include file='partials/comments.tpl' commentPrimaryKey='id_news_comment'}