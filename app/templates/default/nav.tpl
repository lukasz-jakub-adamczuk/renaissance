		<nav class="main-nav">
			<div class="inner clearfix">
				<a href="{$base}">
					<picture class="site-logo">
						<source media="(min-resolution: 192dpi)" srcset="{$base}/assets/site/bg/logo_@2X.png 2x">
						<img src="{$base}/assets/site/bg/logo.png" width="225" height="35" alt="Squarezone" title="Squarezone">
					<picture>
				</a>
				<input id="searchbox-toggle" type="checkbox">
				<!-- <div class="inner"> -->
					<form method="get" action="{$base}/{#search#}/" class="searchbox">
						<input name="search" type="search" class="input" placeholder="Szukaj..." value="{$smarty.get.search|default:''}">
						<button type="submit" class="button icon-search"></button>
					</form>
				<!-- </div> -->
			</div>
		</nav>
		<nav class="sub-nav">
			<input id="menu-toggle" type="checkbox">
			<div class="inner clearfix">
				
				<label for="menu-toggle" id="menu-tgr" class="menu-icon icon-menu left"></label>
				<label for="searchbox-toggle" id="search-tgr" class="menu-icon icon-search"></label>
				<ul class="inner nav-top left">
					{foreach from=$aNavTop item=nt key=ntk}<li class="{$ntk}-theme">
						<a id="link-to-{$ntk}" href="{if isset($nt.external) and $nt.external eq true}{$nt.url}{else}{$base}/{$nt.url}{/if}" class="bc{if $ntk eq $ctrl} active{/if}">
							{$nt.name}
						</a>
					</li>{/foreach}
				</ul>
				<div id="user-nav">
					{if isset($user)}
						<a href="{$base}/auth/logout" class="log-out-tgr">Wyloguj</a>
						<a id="auth-tgr" href="{#user#}/{$user.slug}" data-user-sign-in="true">
							{if !empty($user.avatar)}
							<img src="image.php?img={$user.avatar}&size=64x64" alt="{$user.slug}" width="32" height="32">
							{else}
							<img src="assets/users/no-avatar.jpg" alt="{$user.slug}" width="32" height="32">
							{/if}
						</a>
					{else}
						<a id="auth-tgr" href="{$smarty.server.REQUEST_URI}#modal" data-user-sign-in="_false">
							<span class="icon-user"></span>
						</a>
					{/if}
				</div>
				
			</div>
		</nav>