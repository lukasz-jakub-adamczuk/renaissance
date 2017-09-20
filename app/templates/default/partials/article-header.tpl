<!-- TODO schema ImageObject -->
{if isset($mainImage)}
<div class="article-image">
    {image file=$mainImage.0.fragment sizes='640x360,1280x720,1920x1080'}
</div>
{/if}
<header class="article-header">
    <h1 id="article-title" itemprop="name">{$article.title|stripslashes}</h1>
</header>
