<div class="main-items {$type}-item">
                {foreach from=$items item=object}<article class="{if $object@first}col-8 full-image-item{else}col-4{/if} front-item large-item" data-id="{$object[$object.key]}">
                    <a href="{$base}/{$object.url}" class="front-item-content">
                        {if $object@first}
                        {image file=$object.fragment size=640x320}
                        {else}
                        {image file=$object.fragment size=320x180}
                        {/if}
                        <header>
                            <h3 class="front-item-title">
                                {if $object.category}<span class="front-item-category">{$object.category}</span>{/if}
                                {$object.title|stripslashes|humanize}
                            </h3>
                        </header>
                    </a>
                    <footer>
                        <time datetime="{$object.creation_date|date_format:$datetimeFormat}" class="meta-time">{$object.creation_date|humanize_date}</time>
                        <a href="{$base}/{$object.url}#comments" class="meta-comments">{$object.comments|pluralize:'komentarz':'komentarze':'komentarzy'}</a>
                    </footer>
                </article>{/foreach}
            </div>