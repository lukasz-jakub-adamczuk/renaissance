        <footer id="footer" class="theme">
            <div class="footer-items">
                <div class="art-item front-item col-4-with-gap">
                    <h3>Cosplay</h3>
                    {foreach from=$aCosplays item=img}<a href="{$base}/{#gallery#}/cosplay/cosplay" class="footer-thumbnail">
                    {image file=$img.name size=64x64 margin=0 y=top}
                    </a>{/foreach}
                </div><div class="art-item front-item col-4-with-gap">
                    <h3>Tapety</h3>
                    {foreach from=$aWallpapers item=img}<a href="{$base}/{#gallery#}/{$img.category_slug}/{$img.slug}" class="footer-thumbnail">
                    {image file=$img.name size=64x64 margin=0 y=top}
                    </a>{/foreach}
                </div><div class="art-item front-item col-4-with-gap">
                    <h3>Fanarty</h3>
                    {foreach from=$aFanarts item=img}<a href="{$base}/{#gallery#}/{$img.category_slug}/{$img.slug}" class="footer-thumbnail">
                    {if $img.name neq ''}
                    {image file=$img.name size=64x64 margin=0 y=top}
                    {/if}
                    </a>{/foreach}
                </div>
            </div>
            <div class="footer-items">
                <div class="list-item front-item col-4">
                    <h3>Treść</h3>
                    <ul>
                        <li><a href="{#news#}">Aktualności</a></li>
                        <li><a href="{#article#}">Gry</a></li>
                        <li><a href="{#story#}">Publicystyka</a></li>
                        <li><a href="{#gallery#}">Galerie</a></li>
                        <li><a href="{$base}/rss.xml" title="Kanał RSS">RSS</a></li>
                    </ul>   
                </div><div class="list-item front-item col-4">
                    <h3>Społeczność</h3>
                    <ul>
                        <li><a href="{#user#}">Użytkownicy</a></li>
                        {*<li><a href="{#trophy#}">Trofea</a></li>*}
                        <li><a href="{#cup#}">SZ Cup®</a></li>
                        <li><a href="{#shoutbox#}">Shoutbox</a></li>
                        <li><a href="https://www.facebook.com/pages/SquareZone/171123689581372" title="Facebook">Facebook</a></li>
                    </ul>   
                </div><div class="list-item front-item col-4">
                    <h3>Serwis</h3>
                    <ul>
                        <li><a href="{#page#}/redakcja">Redakcja</a></li>
                        {*<li><a href="{#page#}/regulamin">Regulamin</a></li>*}
                        <li><a href="{#page#}/polityka-prywatnosci">Polityka prywatności</a></li>
                        <li><a href="{#page#}/zasady-oceniania">Zasady oceniania</a></li>
                        <li><a href="{#page#}/kontakt">Kontakt</a></li>
                    </ul>   
                </div>
            </div>
            <div class="inner copyright-items">
                <div class="front-item col-4-with-gap">
                    <span>Squarezone &copy; 2003-{$smarty.now|date_format:'%Y'}</span>
                </div><div class="front-item col-4-with-gap">
                    <a href="https://validator.w3.org/nu/?doc=http%3A%2F%2Fsquarezone.pl%2F" class="icon-html" title="Nu Html Checker"></a>
                    <a href="https://github.com/lukasz-jakub-adamczuk/renaissance#renaissance" class="icon-github"></a>
                    <a href="https://validator.w3.org/unicorn/check?ucn_uri=squarezone.pl&warning=1&usermedium=all&ucn_lang=pl&ucn_task=full-css#" class="icon-css" title="Unicorn"></a>
                </div><div class="front-item col-4-with-gap">
                    <a href="{$smarty.server.REQUEST_URI}#top">#top</a>
                </div>
            </div>
        </footer>
