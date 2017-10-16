<!-- TODO schema ImageObject -->
{if isset($mainImage)}
<div class="article-main-image">
    {image file=$mainImage.0.fragment sizes='360x180,768x432,1280x720,1920x1080'}
</div>
{/if}
<header class="article-header">
    <h1 id="article-title" itemprop="name">{$title|stripslashes|humanize}</h1>
</header>
