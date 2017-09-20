
{if $article.template eq 'intro' and isset($gameLogo)}
<div class="game-logo">
    {image file=$gameLogo.0.fragment size=640x}
</div>
{/if}
