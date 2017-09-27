<div class="gallery">
{foreach from=$images item=img}<a href="{$base}{$img.name}" class="gallery-image">
    {image file=$img.name size=128x128}
</a>{/foreach}
</div>