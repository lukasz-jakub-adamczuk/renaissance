<article>
    {include file='partials/article-header.tpl' title=$page.title}
    <section class="article-content text">
        {$page.content|humanize}
    </section>
</article>