{if isset($aGameInfo)}
					<aside>
						<ul class="x-style key-value">
							<li>Studio: <span>{$aGameInfo.developer}</span></li>
							<li>Wydawca: <span>{$aGameInfo.publisher}</span></li>
							<li>Gatunek: <span>{$aGameInfo.genre}</span></li>
							<li>
								{foreach from=$aGameInfo.system item=platform key=pk}
								<span>{$pk|upper}</span>
								<ul class="x-style">
									{if isset($platform.media)}<li>Nośnik: <span>{$platform.media}</span></li>{/if}
									{foreach from=$platform.release item=date key=dk}
									<li>{$dk|upper}: <span>{$date}</span></li>
									{/foreach}
								</ul>
								{/foreach}
							</li>
						</ul>
					</aside>{/if}