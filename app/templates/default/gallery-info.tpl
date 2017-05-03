        {if !is_array($aArticle)}
            <article>
                <section class="padding">
                    <h2>Błąd</h2>
                    <p>Brak szukanej galerii!</p>
                </section>
            </article>
        {else}
            <section class="inner">
                <h2>{$aArticle.name|stripslashes}</h2>
                <h3>{$aArticle.category_name|stripslashes}</h3>
                <!-- {$aArticle.id_gallery} -->
            </section>
            <article>
            <!-- <div class="wrapper"> -->
                <section class="inner">
                    <!-- {include file='common/screens.tpl'} -->
                    <div class="gallery">
                    {foreach from=$aImages item=img}<a href="{$base}{$img.name}" class="miniature">
                        {image file=$img.name size=128x128}
                    </a>{/foreach}
                    </div>
                </section>
                <footer class="theme">
                    <div class="inner theme-dark"{if isset($aVerdict)} data-verdict="{$aVerdict.rating}"{/if}>
                    </div>
                </footer>
            <!-- </div> -->
        </article>{/if}
        {include file='common/ratings.tpl'}
        {include file='common/comments.tpl' sCommentPrimaryKey='id_gallery_comment'}