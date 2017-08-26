{foreach from=$list item=art}<article class="front-item col-4">
    <a href="{$base}{$smarty.server.REQUEST_URI}/{$art.$url}" class="front-item-content m-item">
        {*if isset($art.fragment)}
        {image file=$art.fragment size=320x180}
        {/if*}
        <header>
            <h3 class="front-item-title">
                {$art.$col|stripslashes|humanize}
            </h3>
        </header>
    </a>
    <footer>
        {if $footer eq 'date'}
        <time datatime="{$art.creation_date|date_format:$datetimeFormat}" class="meta-time">{$art.creation_date|date_format:"%d-%m-%Y"}</time>
        {/if}
        {if $footer eq 'human-date'}
        <time datatime="{$art.creation_date|date_format:$datetimeFormat}" class="meta-time">{$art.creation_date|humanize_date}</time>
        {/if}
        {if $footer eq 'counter'}
        <span class="meta-time">{$art.items|default:''}</span>
        {/if}
        {if isset($art.verified) and $art.verified}<small class="icon-checkmark"></small>{/if}
    </footer>
</article>{/foreach}