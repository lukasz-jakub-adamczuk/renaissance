{if isset($verdict)}
<div class="article-verdict"{if isset($verdict)} data-verdict="{$verdict.rating}"{/if}>
    <h2>Werdykt</h2>
    {include file='partials/verdict.tpl' item=$verdict output=rating}
</div>{/if}
