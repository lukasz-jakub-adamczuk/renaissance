        <article id="main-text"{if $article.template eq 'review'} itemtype="http://schema.org/Product"{/if}{if isset($mainImage)} class="bg-cover" style="background-image: url({$base}{$mainImage.0.fragment});"{else} class="inside"{/if}>
            {include file='common/article-header-2.tpl'}
            <div class="wrapper inside ">
                <div class="content-meta">
                    <a href="{$base}/{#user#}/{$article.author_slug}">{$article.author_name}</a> - <time>{$article.creation_date|date_format:"%d %B %Y, %H:%M"|localize_date}</time>
                    {include file='common/comments-counter.tpl'}
                </div>
                <section class="center {$article.template}">
                    <div class="social-media">
                        {*include file='common/fb-like.tpl'*}
                    </div>
                    {include file='common/standard-notice.tpl'}

                    {include file='common/game-logo.tpl'}
                    {include file='common/game-info.tpl'}
                    {include file='common/music-info.tpl'}
                    
                    {$article.markup|stripslashes|gb_replace|replace:"image/":"../../i/"|mediabox|humanize}
                </section>
                <section>    
                    {include file='common/screens.tpl'}
                </section>
                {if $article.template eq 'intro'}
                <section class="inner main-items">
                    {if $articles}
                    <h2>Artykuły</h2>
                    {foreach from=$articles item=art}<article class="front-item col-3">
                        <a href="{$base}/{#article#}/{$art.category_slug}/{$art.slug}" class="front-item-content s-item">
                            <span>{$art.title|stripslashes|humanize}</span>
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
                        {include file='common/statistics.tpl'}
                    </div>
                </footer>
            </div>
        </article>
        {include file='partials/ratings.tpl'}
        
        <div>
            <div class="inner" style="border: 1px solid #aaa;">
                {include file='common/fb-comments.tpl'}
            </div>
        </div>
        {include file='common/comments.tpl' commentPrimaryKey=$commentPrimaryKey}
