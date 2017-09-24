{if isset($ratings) and count($ratings) gt 0}<div id="ratings" class="article-ratings-wrapper">
    <div class="article-ratings">
        <h2>Oceny redaktorów</h2>
        {foreach from=$ratings item=r}
            {include file='partials/verdict.tpl' item=$r output=verdict}
        {/foreach}
    </div>
</div>{/if}