{foreach from=$categories item=cat}<article class="front-item with-image col-3">
                <a href="{$base}/{$entity}/{$cat.slug}" class="front-item-content m-item">
                    {*image file=$cat.fragment size=320x180*}
                    <header>
                        <h3 class="front-item-title">
                            {$cat.name|stripslashes|humanize}
                        </h3>
                    </header>
                </a>
                <footer>
                    <!--<time class="meta-time">{$object.creation_date|humanize_date}</time>-->
                    <!--<a href="{$base}/{$object.url}#comments" class="meta-comments">{$object.comments|pluralize:'komentarz':'komentarze':'komentarzy'}</a>-->
                </footer>
            </article>{/foreach}