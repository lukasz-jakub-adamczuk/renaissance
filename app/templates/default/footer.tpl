		<footer id="footer" class="theme">
			<div class="inner items simple one-third">
				<div class="item">
					<h3>Cosplay</h3>
					{foreach from=$aCosplays item=img}<a href="{$base}/{#gallery#}/cosplay/cosplay" class="footer-thumbnail">
					<figure class="ratio-1-1">
						<img src="image.php?img={$img.name}&size=64x64&margin=0&y=top">
					</figure>
					</a>{/foreach}
				</div><div class="item">
					<h3>Tapety</h3>
					{foreach from=$aWallpapers item=img}<a href="{$base}/{#gallery#}/{$img.category_slug}/{$img.slug}" class="footer-thumbnail">
					<figure class="ratio-1-1">
						<img src="image.php?img={$img.name}&size=64x64&margin=0&y=top">
					</figure>
					</a>{/foreach}
				</div><div class="item">
					<h3>Fanarty</h3>
					{foreach from=$aFanarts item=img}<a href="{$base}/{#gallery#}/{$img.category_slug}/{$img.slug}" class="footer-thumbnail">
					<figure class="ratio-1-1">
						<img src="image.php?img={$img.name}&size=64x64&margin=0&y=top">
					</figure>
					<!-- {image file=$img.name} -->
					</a>{/foreach}
				</div>
			</div>
			<div class="inner items simple one-third">
				<div class="item">
					<h3>Treść</h3>
					<ul class="clean">
						<li><a href="{#news#}">Aktualności</a></li>
						<li><a href="{#article#}">Gry</a></li>
						<li><a href="{#story#}">Publicystyka</a></li>
						<li><a href="{#gallery#}">Galerie</a></li>
					</ul>   
				</div><div class="item">
					<h3>Społeczność</h3>
					<ul class="clean">
						<li><a href="{#user#}">Użytkownicy</a></li>
						{*<li><a href="{#trophy#}">Trofea</a></li>*}
						<li><a href="{#cup#}">SZ Cup®</a></li>
						<li><a href="{#shoutbox#}">Shoutbox</a></li>
					</ul>   
				</div><div class="item">
					<h3>Serwis</h3>
					<ul class="clean">
						<li><a href="{#page#}/redakcja">Redakcja</a></li>
						<!-- <li><a href="{#page#}/regulamin">Regulamin</a></li> -->
						<li><a href="{#page#}/polityka-prywatnosci">Polityka prywatności</a></li>
						<li><a href="{#page#}/zasady-oceniania">Zasady oceniania</a></li>
						<li><a href="{#page#}/kontakt">Kontakt</a></li>
					</ul>   
				</div>
			</div>
			<div class="inner border-top v-padding clearfix">
				<p class="small left">Squarezone &copy; 2003-{$smarty.now|date_format:'%Y'} &middot; renaissance{if $smarty.const.DEBUG_MODE} &middot; <span class="gray">server time: {$sServerTime|default:''}ms{/if}</span> &middot; <a href="{$base}/rss.xml" class="icon-feed dark-gray" title="Aktualności"></a> <a href="https://www.facebook.com/pages/SquareZone/171123689581372" class="icon-facebook dark-gray" title="Facebook"></a>
				</p>
				{*<p class="small left">
					<a href="{$base}/rss.xml" class="icon-feed dark-gray"><span>Aktualności</span></a>
					<a href="https://www.facebook.com/pages/SquareZone/171123689581372" class="icon-facebook dark-gray"><span>Facebook</span></a>
				</p>*}
				<p class="small right tar"><a href="{$smarty.server.REQUEST_URI}#top">#top</a></p>
			</div>
		</footer>