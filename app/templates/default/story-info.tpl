        {if isset($article)}<article{if $article.template eq 'review'} itemtype="http://schema.org/Product"{/if}{if isset($mainImage)} class="bg-cover" style="background-image: url({$base}{$mainImage.0.fragment});"{else} class="inside"{/if}>
            {include file='partials/article-header-2.tpl'}
            <div class="wrapper inside ">
                <div class="content-meta">
                    <a href="{$base}/{#user#}/{$article.author_slug}">{$article.author_name}</a> - <time>{$article.creation_date|date_format:"%d %B %Y, %H:%M"}</time>
                    <a href="{$base}/{$self}#comments" class="comments-count">{$navigator.loaded|default:0} komentarze</a>
                </div>
                <section class="center text">
                    <!-- <h3>{$article.title|stripslashes}</h3> -->
                    <div class="social-media">
                        {include file='partials/fb-like.tpl'}
                    </div>
                    {include file='partials/standard-notice.tpl'}

                    <!-- {include file='partials/review-description.tpl'} -->
                <!-- </section> -->
                <!-- <section class="inner center _padding" data-id-article="{$article.id_article}"> -->
                    <!-- <div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="box_count" data-action="like" data-show-faces="true" data-share="true"></div> -->
                    <!-- {include file='partials/fb-like.tpl'} -->

                    {include file='partials/game-logo.tpl'}
                    {include file='partials/game-info.tpl'}
                    {include file='partials/music-info.tpl'}
                    
                    {$article.markup|stripslashes|gb_replace|replace:"image/":"../../i/"|mediabox:medium|humanize}
                    <!-- <h1>ALTERNATYWNA WERSJA</h1> -->
                    <!-- {$article.markup|stripslashes|gb_replace|replace:"image/":"../../i/"|mediabox:small:left|humanize} -->
                    
                </section>
                <section>    
                    {include file='partials/screens.tpl'}
                </section>
                {if $article.template eq 'intro'}
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
                    <div class="inner theme-dark"{if isset($verdict)} data-verdict="{$verdict.rating}"{/if}>
                        {include file='partials/verdict.tpl'}
                        {include file='partials/statistics.tpl'}
                    </div>
                </footer>
            </div>
        </article>
        {include file='partials/ratings.tpl'}
        {include file='partials/comments.tpl' commentPrimaryKey='id_story_comment'}
        {else}
        <article>
            <section class="padding">
                <h2>Błąd</h2>
                <p>Brak szukanego artykułu!</p>
            </section>
        </article>
        {/if}