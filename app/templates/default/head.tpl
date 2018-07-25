<head>
    <title>{$title|default:'Squarezone'}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    {*<meta http-equiv="Content-Language" content="pl">*}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="{$sDescription|default:'Serwis dla fanów Square Enix, Final Fantasy i ciekawych opinii o grach.'}">
    <meta name="Keywords" content="{$sKeywords|default:'final fantasy, vagrant story, final, fantasy, chrono cross, kingdom hearts, suikoden'}">
    <meta name="robots" content="all">
    <meta name="Revisit-After" content="1 days">
    <meta name="author" content="Ash">

    <meta name="theme-color" content="#ffffff"/>

    {if $ctrl eq 'news' and $act eq 'info'}
    <meta property="og:url" content="{$base}{$self}" />
        {if isset($aFirstImage)}
        <meta property="og:image" content="{image file=$aFirstImage.name size=640x360 output=url}" />
        {/if}
    <meta property="og:title" content="{$aNews.title|stripslashes}" />
    <meta property="og:description" content="{$aNews.markup|stripslashes|strip_tags|escape|truncate:256}" />
    {/if}
    {if ($ctrl eq 'article' or $ctrl eq 'story') and $act eq 'info'}
    <meta property="og:url" content="{$base}{$self}" />
        {if isset($mainImage)}
        <meta property="og:image" content="{image file=$mainImage.0.fragment size=640x360 output=url}" />
        {/if}
    <meta property="og:title" content="{$article.title|stripslashes}" />
    <meta property="og:description" content="{$article.markup|stripslashes|strip_tags|escape|truncate:256}" />
    {/if}
    {if $ctrl eq 'home'}
    <meta property="og:title" content="Squarezone" />
    <meta property="og:description" content="Serwis dla fanów Square Enix, Final Fantasy i ciekawych opinii o grach." />
    {/if}

    <link rel="shortcut icon" type="image/x-icon" href="{$base}/favicon-512x512.png" />
    <link rel="manifest" href="{$base}/manifest.json">

    {if $smarty.const.APP_ENV eq 'prod'}
        {*<link rel="stylesheet" href="{$base}/css/main.min.css?v={$smarty.const.VERSION}">*}
        {*<link rel="stylesheet" href="{$base}/css/core-header.min.css?v={$smarty.const.VERSION}">
        <link rel="stylesheet" href="{$base}/css/360.min.css?v={$smarty.const.VERSION}" media="min-width: 360px">
        <link rel="stylesheet" href="{$base}/css/768.min.css?v={$smarty.const.VERSION}" media="min-width: 768px">
        <link rel="stylesheet" href="{$base}/css/1080.min.css?v={$smarty.const.VERSION}" media="min-width: 1080px">*}
        <link rel="stylesheet" href="{$base}/css/core-header.css">
        <link rel="stylesheet" href="{$base}/css/min-width-320px.css" media="(max-width: 359px)">
        <link rel="stylesheet" href="{$base}/css/min-width-360px.css" media="(min-width: 360px) and (max-width: 479px)">
        <link rel="stylesheet" href="{$base}/css/min-width-480px.css" media="(min-width: 480px) and (max-width: 767px)">
        <link rel="stylesheet" href="{$base}/css/min-width-768px.css" media="(min-width: 768px) and (max-width: 1079px)">
        <link rel="stylesheet" href="{$base}/css/min-width-1080px.css" media="(min-width: 1080px)">
    {else}
        <link rel="stylesheet" href="{$base}/css/core-header.css">
        <link rel="stylesheet" href="{$base}/css/min-width-320px.css" media="(max-width: 359px)">
        <link rel="stylesheet" href="{$base}/css/min-width-360px.css" media="(min-width: 360px) and (max-width: 479px)">
        <link rel="stylesheet" href="{$base}/css/min-width-480px.css" media="(min-width: 480px) and (max-width: 767px)">
        <link rel="stylesheet" href="{$base}/css/min-width-768px.css" media="(min-width: 768px) and (max-width: 1079px)">
        <link rel="stylesheet" href="{$base}/css/min-width-1080px.css" media="(min-width: 1080px)">
    {/if}

    <base href="{$base}/">
</head>
