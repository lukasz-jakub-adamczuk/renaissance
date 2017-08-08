        {if isset($aArticle)}<article{if $aArticle.template eq 'review'} itemtype="http://schema.org/Product"{/if}{if isset($aCoverImage)} class="bg-cover" style="background-image: url({$base}{$aCoverImage.0.fragment});"{/if}>
            {include file='common/article-header.tpl'}
            <div class="wrapper">
                <section class="center _padding">
                    {include file='common/standard-notice.tpl'}

                    <!-- {include file='common/review-description.tpl'} -->
                </section>
                <section class="inner center _padding" data-id-article="{$aArticle.id_article}">
                    <!-- <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="box_count" data-action="like" data-show-faces="true" data-share="true"></div> -->
                    {include file='common/fb-like.tpl'}

                    {include file='common/game-logo.tpl'}
                    {include file='common/game-info.tpl'}
                    {include file='common/music-info.tpl'}
                    
                    {$aArticle.markup|stripslashes|gb_replace|replace:"image/":"../../i/"|mediabox:medium|humanize}
                    <!-- <h1>ALTERNATYWNA WERSJA</h1> -->
                    <!-- {$aArticle.markup|stripslashes|gb_replace|replace:"image/":"../../i/"|mediabox:small:left|humanize} -->
                    
                    
                    {include file='common/screens.tpl'}
                </section>
                {if $aArticle.template eq 'intro'}
                <section class="inner items">
                    {if $articles}
                    <h2>Artykuły</h2>
                    {foreach from=$articles item=art}<article class="item">
                        <a href="{$base}/{#article#}/{$art.category_slug}/{$art.slug}" class="block s-item">
                            <span>{$art.title|stripslashes|humanize}</span>
                            
                            <!-- <time>{$art.creation_date|date_format:"%d-%m-%Y"}</time> -->
                        </a>
                        <footer>
                            <time>{$art.creation_date|humanize_date}</time>
                            {if $art.verified} <small class="icon-checkmark" title="Treść zgodna ze standardami"></small>{/if}
                        </footer>
                    </article>{/foreach}
                    {else}
                    <p>Brak artykułów</p>
                    {/if}
                </section>
                {/if}
                {*<section>
                    <p>Niech SquareZone będzie najlepsze! Popraw tekst i wyślij do weryfikacji.</p>
                    <button id="edit-text-tgr" class="button">Edytuj ten tekst</button>
                </section>*}
                <footer class="theme">
                    <div class="inner theme-dark"{if isset($aVerdict)} data-verdict="{$aVerdict.rating}"{/if}>
                        {include file='common/verdict.tpl'}
                        {include file='common/statistics.tpl'}
                    </div>
                </footer>
            </div>
        </article>
        {include file='common/ratings.tpl'}
        {include file='common/comments.tpl' sCommentPrimaryKey='id_article_comment'}
        {else}
        <article>
            <section class="padding">
                <h2>Błąd</h2>
                <p>Brak szukanego artykułu!</p>
            </section>
        </article>
        {/if}