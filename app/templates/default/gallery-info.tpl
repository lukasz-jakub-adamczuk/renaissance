{if !is_array($article)}
    <article>
        <section class="padding">
            <h2>Błąd</h2>
            <p>Brak szukanej galerii!</p>
        </section>
    </article>
{else}
    <section class="inner">
        <h2>{$article.name|stripslashes}</h2>
        <h3>{$article.category_name|stripslashes}</h3>
        <!-- {$article.id_gallery} -->
    </section>
    <article>
    <!-- <div class="wrapper"> -->
        <section class="inner">
            <!-- {include file='partials/screens.tpl'} -->
            {if isset($images)}
                {include file='partials/gallery.tpl' images=$images}
            {/if}
        </section>
        <footer class="theme">
            <div class="inner theme-dark"{if isset($verdict)} data-verdict="{$verdict.rating}"{/if}>
            </div>
        </footer>
    <!-- </div> -->
</article>{/if}
{include file='partials/ratings.tpl'}
{include file='partials/comments.tpl' commentPrimaryKey='id_gallery_comment'}