{if $output eq 'rating'}
<div class="verdict" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
    <h3>{$item.author_name|default:'Gość'}</h3>
    <img src="assets/site/redaction/{$item.author_slug}.png" alt="{$item.author_name}">
    <span itemprop="ratingValue" class="score">{$item.rating}</span>
    <meta itemprop="worstRating" content="0">
    <meta itemprop="bestRating" content="10">
    <p>{$item.verdict|stripslashes|humanize}</p>
</div>
{else}
<div class="verdict">
    <h3>{$item.author_name|default:'Gość'}</h3>
    <img src="assets/site/redaction/{$item.author_slug}.png" alt="{$item.author_name|default:'Gość'}">
    <span class="score">{$item.rating}</span>
    <p>{$item.verdict|stripslashes|humanize}</p>
</div>
{/if}

{if not empty($item.plus)}
<div class="verdict-features">
    <h3>Zalety</h3>
    <ul class="advantages">
        {foreach from=$item.plus item=p}
        <li>
            <span class="icon-plus-circle"></span>
            <span>{$p}</span>
        </li>
        {/foreach}
    </ul>
</div>{/if}<!--
-->{if not empty($item.minus)}<div class="verdict-features">
    <h3>Wady</h3>
    <ul class="disadvantages">
        {foreach from=$item.minus item=m}
        <li>
            <span class="icon-minus-circle"></span>
            <span>{$m}</span>
        </li>
        {/foreach}
    </ul>
</div>
{/if}
{*<div class="rating editor-score">
    <strong>Redakcja</strong>
    <span>{$item.rating}</span>
</div>*}