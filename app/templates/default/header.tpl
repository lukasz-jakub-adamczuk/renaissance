<head>
    <title>{$sTitle|default:'Squarezone'}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Language" content="pl">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="{$sDescription|default:'Serwis dla fanów Square Enix, Final Fantasy i ciekawych opinii o grach.'}">
    <meta name="Keywords" content="{$sKeywords|default:'final fantasy, vagrant story, final, fantasy, chrono cross, kingdom hearts, suikoden'}">
    <meta name="robots" content="all">
    <meta name="Revisit-After" content="1 days">
    <meta name="author" content="Ash">

    {if $ctrl eq 'news' and $act eq 'info'}
    <meta property="og:url" content="{$base}{$self}" />
        {if isset($aFirstImage)}
        <meta property="og:image" content="{$base}/image.php?img={$aFirstImage.name}&size=640x360&margin=0" />
        {/if}
    <meta property="og:title" content="{$aNews.title|stripslashes}" />
    <meta property="og:description" content="{$aNews.markup|stripslashes|strip_tags|replace:'"':''|truncate:256}" />
    {/if}
    {if ($ctrl eq 'article' or $ctrl eq 'story') and $act eq 'info'}
    <meta property="og:url" content="{$base}{$self}" />
        {if isset($aCoverImage)}
        <meta property="og:image" content="{$base}/image.php?img={$aCoverImage.0.fragment}&size=640x360&margin=0" />
        {/if}
    <meta property="og:title" content="{$aArticle.title|stripslashes}" />
    <meta property="og:description" content="{$aArticle.markup|stripslashes|strip_tags|replace:'"':''|truncate:256}" />
    {/if}
    {if $ctrl eq 'home'}
    <meta property="og:title" content="Squarezone" />
    <meta property="og:description" content="Serwis dla fanów Square Enix, Final Fantasy i ciekawych opinii o grach." />
    {/if}

    <link rel="shortcut icon" type="image/x-icon" href="{$base}/favicon.png" />

    {if $smarty.const.APP_ENV eq 'prod'}
        <link rel="stylesheet" href="{$base}/css/all.min.css?v={$smarty.const.VERSION}">
    {else}
        {if isset($aResources.css)}
            {foreach from=$aResources.css item=style}
                <link rel="stylesheet" href="{$base}/{$style}">
            {/foreach}
        {/if}
    {/if}

    <base href="{$base}/">
</head>