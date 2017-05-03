<article class="item">
                        <a href="{$base}/{#article#}/{$art.category_slug}/{$art.slug}" class="block {$size}">
                            <span>{$art.title|stripslashes|humanize}</span>
                            {if $art.verified} <span class="icon-checkmark"></span>{/if}
                            <time>{$art.creation_date|date_format:"%d-%m-%Y"}</time>
                        </a>
                    </article>