        {if !is_array($aNews)}
            <article>
                <section class="padding">
                    <h2>Błąd</h2>
                    <p>Brak szukanej aktualności!</p>
                </section>
            </article>
        {else}
            <header class="inner inside">
                <h1>{$aNews.title|stripslashes|humanize}</h1>
            </header>
            <article class="inside">
                <div class="content-meta">
                    <a href="{$base}/{#user#}/{$aNews.author_slug}">{$aNews.author_name}</a> - <time>{$aNews.creation_date|date_format:"%d %B %Y, %H:%M"|localize_date}</time>
                    {include file='common/comments-counter.tpl'}
                </div>
                <section class="center text">
                    <div class="social-media">
                        {include file='common/fb-like.tpl'}
                    </div>
                    {if isset($aFirstImage)}
                    <div class="figure-wrapper width-medium" data-id="{$aNews.id_news}">
                        {*<figure class="ratio-16-9">
                            <img src="" data-src="image.php?img={$aFirstImage.name}&size=640x360&margin=0">
                        </figure>*}
                        {image file=$aFirstImage.name size=640x360 margin=0}
                    </div>
                    {/if}
                    
                    {$aNews.markup|mediabox:medium|humanize|stripslashes}
                    
                    {if isset($aImages)}
                    <div class="gallery">
                    {foreach from=$aImages item=img}<a href="{$base}{$img.name}" class="miniature">
                        <figure class"ratio-16-9">
                            <img data-src="image.php?img={$img.name}&size=256x144" class="image">
                        </figure>
                    </a>{/foreach}
                    </div>
                    {/if}
                </section>
                <section class="other-content clearfix">
                    {if isset($aRelatedNews.newer)}
                    <a href="{$base}/{#news#}/{$aRelatedNews.newer.date}/{$aRelatedNews.newer.slug}" class="newer-news">{$aRelatedNews.newer.title|stripslashes}</a>
                    {/if}
                    {if isset($aRelatedNews.older)}
                    <a href="{$base}/{#news#}/{$aRelatedNews.older.date}/{$aRelatedNews.older.slug}" class="older-news">{$aRelatedNews.older.title|stripslashes}</a>
                    {/if}
                </section>
        </article>{/if}
        {include file='common/comments.tpl' sCommentPrimaryKey='id_news_comment'}