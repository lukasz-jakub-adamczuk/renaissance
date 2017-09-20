<div itemscope itemtype="http://schema.org/Review" class="article-stats">
    <meta itemprop="datePublished" content="{$article.creation_date|date_format:'%Y-%m-%d'}">
    <h2>Statystyka</h2>
    <ul class="key-value-list">
        <li>Data publikacji: <span><time datetime="{$article.creation_date|date_format:$datetimeFormat}">{$article.creation_date|date_format:"%d %B %Y, %H:%M"|localize_date}</time><span></li>
        {if isset($article.template) and $article.template eq 'review'}
        <li>Autor: <span>{$article.author_name|default:$article.id_author}</span></li>
        {/if}
        <li>Artykuł czytany: <span>{$article.views}</span></li>
        {if $article.rated gt 0}<li>Głosy oddane: <span>{$article.rated}</span></li>
        <li>Średnia ocen: <span>{if $article.sum eq "0"}0{else}{($article.sum/$article.rated)|string_format:'%.1f'|replace:',':'.'}{/if}</span></li>{/if}
    </ul>
    {*{if $article.template eq 'review'}
    <div class="rating community-score">
        <strong>Społeczność</strong>
        {if $article.rated > 10}
        <span>{($article.sum/$article.rated)|string_format:'%.1f'|replace:',':'.'}</span>
        {else}
        <span>? - zbyt mało ocen...</span>
        {/if}
    </div>
    {/if}*}
</div>
