<section>
    <header class="inner">
        <h2>SZ Cup&reg;</h2>
    </header>
    <ul class="timeline clearfix">
    {foreach from=$aCups item=cup}<li class="item_ cup {if $cup.slug[4] eq '-'}
                hero-cup
            {else}
                heroine-cup
            {/if}">
        <a href="{$base}/{#cup#}/{$cup.slug}" class="cup-item {if $cup.slug[4] eq '-'}hero-item{else}heroine-item{/if}" data-cup="{$cup.name}">
            <img src="" style="background-image: url({$base}{$cup.description});">
        </a>
    </li>{/foreach}
    </ul>
</section>
