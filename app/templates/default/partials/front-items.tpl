<div class="main-items {$type}-item">
    {foreach from=$items item=object}<article class="{if $object@first}normal-size full-image-item{else}small-size{/if} front-item large-item" data-id="{$object[$object.key]}">
        <a href="{$base}/{$object.url}" class="front-item-content">
            {if $object@first}
            <!-- size=640x320 -->
            {image file=$object.fragment sizes='344x172,496x248,704x396'}
            {else}
            <!-- size=320x180 -->
            {image file=$object.fragment sizes='164x92,240x135,344x172'}
            {/if}
            <header>
                <h3 class="front-item-title">
                    {if $object.category_name}<span class="front-item-category">{$object.category_name}</span>{/if}
                    {$object.title|stripslashes|humanize}
                </h3>
            </header>
        </a>
        <footer>
            <time datetime="{$object.creation_date|date_format:$datetimeFormat}" class="meta-time">{$object.creation_date|humanize_date}</time>
            <a href="{$base}/{$object.url}#komentarze" class="meta-comments">{$object.comments|pluralize:'komentarz':'komentarze':'komentarzy'}</a>
        </footer>
    </article>{/foreach}
</div>