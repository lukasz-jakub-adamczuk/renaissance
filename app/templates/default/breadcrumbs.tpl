        <div itemscope="" itemtype="http://schema.org/WebPage" class="breadcrumbs inner">
            {if $aBreadcrumbs}{foreach from=$aBreadcrumbs item=bc}
            <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                <a href="{$base}/{$bc.url}" itemprop="url">
                    <span itemprop="title"{if isset($bc.class)} class="{$bc.class}"{/if}>{$bc.text}</span>
                </a>
            </span>{/foreach}{/if}
        </div>