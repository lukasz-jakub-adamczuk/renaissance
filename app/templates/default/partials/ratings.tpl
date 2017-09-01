{if isset($ratings) and count($ratings) gt 0}<div id="ratings" class="theme-light">
    <div class="inner theme">
        <h2 class="padding">Oceny redaktorów</h2>
        {foreach from=$ratings item=r}
        <div class="verdict">
            <h3>{$r.author_name|default:'Gość'}</h3>
            <img src="assets/site/redaction/{$r.author_slug}.png" alt="{$r.author_name|default:'Gość'}"><span class="score">{$r.rating}</span>
            <p>{$r.verdict|stripslashes|humanize}</p>
        </div>
        {/foreach}
    </div>
</div>{/if}