<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
    <channel>
        <title>{$aRss.title|default:'brak'}</title>
        <description>{$aRss.description|default:'brak'}</description>
        <link>{$aRss.link|default:'brak'}</link>
        <lastBuildDate>{$aRss.lastbuilddate|default:'brak'}</lastBuildDate>
        <generator>{$aRss.generator|default:'brak'}</generator>
        <image>
            <url>{$aRss.image.url|default:'brak'}</url>
            <title>squarezone.pl logo</title>
            <link>{$aRss.image.link|default:'brak'}</link>
            <description>{$aRss.image.description|default:'brak'}</description>
        </image>
        {foreach from=$aRss.items item=news}        <item>
            <title>{$news.title|default:'brak'}</title>
            <link>{$news.link|default:'brak'}</link>
            <description>{$news.description|default:'brak'}</description>
            <pubDate>{$news.pubdate|default:'brak'}</pubDate>
        </item>
{/foreach}
    </channel>
</rss>