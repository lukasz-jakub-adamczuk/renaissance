        {if !is_array($aNews)}
            <article>
                <section class="padding">
                    <h2>Błąd</h2>
                    <p>Brak szukanej aktualności!</p>
                </section>
            </article>
        {else}
            <header class="inner center">
                <h2>Aktualności</h2>
            </header>
            <article>
            <!-- <div class="wrapper"> -->
                <section class="center">
                    <h3>{$aNews.title|stripslashes}</h3>
                    {if isset($aFirstImage)}
                    <div class="figure-wrapper width-medium" data-id="{$aNews.id_news}">
                        <figure class="ratio-16-9">
                            <img src="" data-src="image.php?img={$aFirstImage.name}&size=640x360&margin=0">
                        </figure>
                    </div>
                    {/if}
                    
                    
                    <!-- <div> -->
                        {$aNews.markup|mediabox:medium|humanize|stripslashes}
                    <!-- </div> -->

                    {*<div class="photos readable">
                    {foreach from=$aImages item=img}
                    <a href="image.php?img={$img.name}&size=640x360">
                        <img src="image.php?img={$img.name}&size=120x90">
                    </a>
                    {/foreach}
                    </div>*}

                    {if isset($aImages)}
                    <div class="thumbnails">
                    {foreach from=$aImages item=img}
                    <a href="image.php?img={$img.name}&size=640x360">
                        <img data-src="image.php?img={$img.name}&size=160x90" class="image">
                        <!-- <img data-src="image.php?img={$img.name}&size=240x135" class="image"> -->
                    </a>
                    {/foreach}
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
                <footer class="theme">
                    <div class="inner padding theme-dark">
                        {if $aNews.origin ne ""}<span class="block origin">Źródło: {$aNews.origin}</span>{/if}
                    Dodał: <a href="{$base}/{#user#}/{$aNews.slug}">{$aNews.author_name}</a> ~ {$aNews.creation_date|date_format:"%d %B %Y, %H:%M"}
                    </div>
                </footer>
            <!-- </div> -->
        </article>{/if}
        {include file='common/comments.tpl' sCommentPrimaryKey='id_news_comment'}