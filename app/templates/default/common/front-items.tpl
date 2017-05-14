<div class="{$type}-item">
                {foreach from=$items item=object}<article class="front-item large-item" data-id="{$object[$object.key]}">
                    <a href="{$base}/{$object.url}" class="front-item-content">
                        {image file=$object.fragment size=320x180}
                        {if $object.type eq 'news'}
                        <span class="front-item-category">News</span>
                        {/if}
                        {if $object.type eq 'article'}
                        <span class="front-item-category">Artykuły</span>
                        {/if}
                        {if $object.type eq 'story'}
                        <span class="front-item-category">{$object.category}</span>
                        {/if}
                        <span class="front-item-title">{$object.title|stripslashes|humanize}</span>
                    </a>
                    <footer class="front-item-footer">
                        <time class="meta-time">{$object.creation_date|humanize_date}</time>
                        <a href="{$base}/{$object.url}#comments" class="meta-comments">{$object.comments|pluralize:'komentarz':'komentarze':'komentarzy'}</a>
                    </footer>
                </article>{/foreach}
            </div>