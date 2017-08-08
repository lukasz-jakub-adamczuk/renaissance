{foreach from=$list item=art}<article class="front-item col-4">
                <a href="{$base}/{$entity}/{$art.category_slug}/{$art.slug}" class="front-item-content m-item">
                    {*image file=$cat.fragment size=320x180*}
                    <header>
                        <h3 class="front-item-title">
                            {$art.title|stripslashes|humanize}
                        </h3>
                    </header>
                </a>
                <footer>
                    <time datatime="{$art.creation_date|date_format:$datetimeFormat}" class="meta-time">{$art.creation_date|humanize_date}</time>
                    {if $art.verified}<small class="icon-checkmark"></small>{/if}
                </footer>
            </article>{/foreach}