<footer id="footer" class="_theme">
    <div class="footer-items">
        <div class="footer-galleries">
            <h3>Cosplay</h3>
            {foreach from=$cosplays item=img}<a href="{$base}/{#gallery#}/cosplay/cosplay" class="footer-gallery">
                {image file=$img.name sizes='74x74,48x48,74x74,74x74' margin=0 y=top}
                <span class="visually-hidden">Cosplaye</span>
            </a>{/foreach}
        </div><div class="footer-galleries">
            <h3>Tapety</h3>
            {foreach from=$wallpapers item=img}<a href="{$base}/{#gallery#}/{$img.category_slug}/{$img.gallery_name}" class="footer-gallery">
                {image file=$img.name sizes='74x74,48x48,74x74,74x74' margin=0 y=top}
                <span class="visually-hidden">{$img.gallery_name}</span>
            </a>{/foreach}
        </div><div class="footer-galleries">
            <h3>Fanarty</h3>
            {foreach from=$fanarts item=img}<a href="{$base}/{#gallery#}/{$img.category_slug}/{$img.gallery_name}" class="footer-gallery">
                {image file=$img.name sizes='74x74,48x48,74x74,74x74' margin=0 y=top}
                <span class="visually-hidden">{$img.gallery_name}</span>
            </a>{/foreach}
        </div>
    </div>
    <div class="footer-items">
        <div class="footer-links">
            <h3>Treść</h3>
            <ul class="clean-list">
                <li><a href="{#news#}">Aktualności</a></li>
                <li><a href="{#article#}">Gry</a></li>
                <li><a href="{#story#}">Publicystyka</a></li>
                <li><a href="{#gallery#}">Galerie</a></li>
                <li><a href="{$base}/rss.xml" title="Kanał RSS">RSS</a></li>
            </ul>   
        </div><div class="footer-links">
            <h3>Społeczność</h3>
            <ul class="clean-list">
                <li><a href="{#user#}">Użytkownicy</a></li>
                <li><a href="{#cup#}">SZ Cup®</a></li>
                <li><a href="{#shoutbox#}">Shoutbox</a></li>
                <li><a href="https://www.facebook.com/pages/SquareZone/171123689581372" title="Facebook">Facebook</a></li>
            </ul>   
        </div><div class="footer-links">
            <h3>Serwis</h3>
            <ul class="clean-list">
                <li><a href="{#page#}/redakcja">Redakcja</a></li>
                {*<li><a href="{#page#}/regulamin">Regulamin</a></li>*}
                <li><a href="{#page#}/polityka-prywatnosci">Polityka prywatności</a></li>
                <li><a href="{#page#}/zasady-oceniania">Zasady oceniania</a></li>
                <li><a href="{#page#}/kontakt">Kontakt</a></li>
            </ul>   
        </div>
    </div>
    <div class="copyright-items">
        <div class="copyright-details">
            <span>Squarezone &copy; 2003-{$smarty.now|date_format:'%Y'}</span>
            <span>ver {$smarty.CONST.VERSION}</span>
            <span id="body-width"></span>px
            <span>sql: {$debugPanel.vars.sql.0}</span>
        </div><div class="copyright-details">
            <a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fsquarezone.pl%2F" class="icon-html" title="Nu Html Checker">
                {svg file='icons/icomoon/SVG/html-five.svg'}
            </a>
            <a href="https://github.com/lukasz-jakub-adamczuk/renaissance#renaissance" class="icon-github">
                {svg file='icons/icomoon/SVG/github.svg'}
            </a>
            <a href="https://validator.w3.org/unicorn/check?ucn_uri=squarezone.pl&warning=1&usermedium=all&ucn_lang=pl&ucn_task=full-css#" class="icon-css" title="Unicorn">
                {svg file='icons/icomoon/SVG/css3.svg'}
            </a>
        </div><div class="copyright-details">
            <a href="{$smarty.server.REQUEST_URI}#top">#top</a>
        </div>
    </div>
</footer>
