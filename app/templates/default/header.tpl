<header class="ch-core-header">
    <input type="checkbox" class="ch-menu-state" id="ch-menu-state">
    <script>document.querySelector('#ch-menu-state').checked = false;</script>

    {*MAIN HEADER*}
    <div class="ch-header-main">
        <div class="ch-inner-container">
            <a class="ch-logo" href="/">
                <i class="ch-icon ch-icon-logo"></i>
                <h1 class="ch-icon-label">Squarezone</h1>
            </a>
            <div class="ch-nav-search-container">
                <nav class="ch-main-links" role="navigation" aria-label="quick navigation">
                    <ul class="ch-nav-list">
                      {*{{#skin.importantSections}}*}
                          {*<li class="ch-list-item item-{{@index}}"><a href="{{url}}">{{name}}</a></li>*}
                      {*{{/skin.importantSections}}*}
                      <li class="ch-list-item item-1"><a href="{$base}/gry/final-fantasy-xv/recenzja">Final Fantasy XV</a></li>
                      <li class="ch-list-item item-1"><a href="{$base}/gry/rise-of-the-tomb-raider/recenzja">Rise of the Tomb Raider</a></li>
                    </ul>
                </nav>
                <form class="ch-search" action="{$base}/szukaj" role="search" method="get" target="_top">
                    <i class="ch-icon ch-icon-search"></i>
                    <input type="search" name="search" id="ch-qs-query" autocomplete="off" placeholder="Szukaj w Squarezone"  aria-label="Szukaj w Squarezone">
                    <div id="ch-qs-loader" class="ch-qs-loader">
                        <div class="loader"></div>
                    </div>
                    <i id="ch-qs-cleaner" class="ch-qs-cleaner"></i>
                    <button class="ch-search-submit" type="submit" aria-label="Submit"></button>
                </form>
            </div>
            <div class="ch-widgets">
                <div class="ch-subscribe-btn-container"></div>
                {if isset($user)}
                <div class="ch-login">
                    <a class="ch-user-name" href="{#user#}/{$user.slug}">{$user.name}</a>
                </div>
                {/if}
                <div class="ch-menu-trigger" role="button" aria-controls="navigation" tabindex="0" aria-label="Meny">
                    <span class="ch-menu-label ch-menu-label-open">Menu</span>
                    <span class="ch-menu-label ch-menu-label-close">Zamknij</span>

                    <div class="ch-menu-icon ch-menu-icon-squeeze">
                       <span class="ch-menu-icon-box">
                           <span class="ch-menu-icon-inner"></span>
                       </span>
                    </div>
                    <label aria-hidden="true" for="ch-menu-state"></label>
                </div>
            </div>
        </div>
    </div>

    {*SUB-HEADER*}
    <div class="ch-header-sub" role="navigation" aria-label="submenu">
        <div class="ch-inner-container">
            
          {*{{#if section.name}}
              <div class="ch-section-links ch-sub-links">
                  <div class="ch-section-label-container">
                      <h2 class="ch-section-label">{{section.name}}</h2>
                  </div>
                {{#if section.subSections}}
                    <span class="ch-dropdown-trigger" aria-haspopup="true">Emne
                    <i class="ch-icon ch-icon-chevron-down"></i>
                  </span>
                    <div class="ch-subsections-container">
                        <ul class="ch-subsections">
                          {{#section.subSections}}
                              <li><a href="{{url}}">{{name}}</a></li>
                          {{/section.subSections}}
                        </ul>
                    </div>
                {{/if}}
              </div>
          {{else}}
              <div class="ch-main-links ch-sub-links">
                  <ul class="ch-subsections" role="navigation" aria-label="submenu">
                    {{#skin.importantSections}}
                        <li><a href="{{url}}">{{name}}</a></li>
                    {{/skin.importantSections}}
                  </ul>
              </div>
          {{/if}}*}
        </div>
    </div>

    {*MAIN MENU*}
    <div id="ch-menu" role="navigation" aria-label="global navigation">
        <div class="ch-outer-container">
            <div class="ch-inner-container">
                <div class="ch-inner-container-wrapper">
                    <div id="ch-qs-result" class="ch-qs-result"></div>
                    <div class="ch-menu-group ch-menu-group-nav">
                        <ul class="ch-menu-area ch-menu-area-nav" aria-label="sections menu">
                            <li>
                                <div class="ch-section-name-container">
                                    <a class="ch-menu-section " href="{$base}/gry">Gry</a>
                                    <i class="ch-icon ch-icon-chevron-down"></i>
                                </div>
                                <ul class="ch-menu-subsections">
                                    <li><a href="{$base}/gry/final-fantasy-vii/wstep">Final Fantasy VII</a></li>
                                    <li><a href="{$base}/gry/chrono-trigger/wstep">Chrono Trigger</a></li>
                                    <li><a href="{$base}/gry/vagrant-story/wstep">Vagrant Story</a></li>
                                </ul>
                            </li>
                            <li>
                                <div class="ch-section-name-container">
                                    <a class="ch-menu-section " href="{$base}/publicystyka">Publicystyka</a>
                                    <i class="ch-icon ch-icon-chevron-down"></i>
                                </div>
                                <ul class="ch-menu-subsections">
                                    <li><a href="{$base}/publicystyka/fanfiki">Fanfiki</a></li>
                                    <li><a href="{$base}/publicystyka/artykuly">Artykuły</a></li>
                                    <li><a href="{$base}/publicystyka/wywiady">Wywiady</a></li>
                                    <li><a href="{$base}/publicystyka/relacje">Relacje</a></li>
                                </ul>
                            </li>
                            <li>
                                <div class="ch-section-name-container">
                                    <a class="ch-menu-section " href="{$base}/galerie">Galerie</a>
                                    <i class="ch-icon ch-icon-chevron-down"></i>
                                </div>
                                <ul class="ch-menu-subsections">
                                    <li><a href="{$base}/galerie/cosplay" class="">Cosplay</a></li>
                                    <li><a href="{$base}/galerie/tapety" class="">Tapety</a></li>
                                    <li><a href="{$base}/galerie/fanart" class="">FanArt</a></li>
                                </ul>
                            </li>
                                <li>
                                    <div class="ch-section-name-container">
                                        <a class="ch-menu-section " href="{$base}/mistrzostwa">Mistrzostwa</a>
                                        <i class="ch-icon ch-icon-chevron-down"></i>
                                    </div>
                                    <ul class="ch-menu-subsections">
                                        <li><a href="{$base}/mistrzostwa/hero-cup-2017" class="new">Hero Cup 2017</a></li>
                                        <li><a href="{$base}/mistrzostwa/heroine-cup-2016" class="">Heroine Cup 2016</a></li>
                                        <li><a href="{$base}/mistrzostwa/hero-cup-2015" class="">Hero Cup 2015</a></li>
                                    </ul>
                                </li>
                            {*{{#sectionsMenu}}
                                <li>
                                    <div class="ch-section-name-container">
                                        <a class="ch-menu-section {{#if @last}}ch-sitemap-trigger{{/if}}" href="{{url}}">{{name}}</a>
                                        {{#if subSections}}
                                            <i class="ch-icon ch-icon-chevron-down"></i>
                                        {{/if}}
                                    </div>
                                    <ul class="ch-menu-subsections">
                                        {{#subSections}}
                                            <li><a href="{{url}}" class="{{#isNew}}new{{/isNew}}">{{name}}</a></li>
                                        {{/subSections}}
                                    </ul>
                                </li>
                            {{/sectionsMenu}}*}
                        </ul>
                        <div class="ch-menu-area ch-menu-area-sitemap" aria-label="sitemap">
                            <div class="ch-sitemap-divider">
                                <div class="ch-sitemap-title"><i class="ch-icon ch-icon-chevron-down"></i>???</div>
                            </div>
                            {*<ul class="ch-sitemap-list">
                                <li class="ch-sitemap-list-group">
                                    <ul>
                                        <li><a href="...">a</a></li>
                                        <li><a href="...">c</a></li>
                                        <li><a href="...">c</a></li>
                                    </ul>
                                </li>
                            </ul>*}
                            {*{{#sectionsMenu}}
                                {{#if @last}}
                                    <div class="ch-sitemap-divider">
                                        <div class="ch-sitemap-title"><i class="ch-icon ch-icon-chevron-down"></i>{{this.name}}</div>
                                    </div>
                                    <ul class="ch-sitemap-list">
                                        {{#each this.siteMap}}
                                            <li class="ch-sitemap-list-group">
                                                <ul>
                                                    {{#each this}}
                                                        <li><a href="{{this.url}}">{{this.name}}</a></li>
                                                    {{/each}}
                                                </ul>
                                            </li>
                                        {{/each}}
                                    </ul>
                                {{/if}}
                            {{/sectionsMenu}}*}
                        </div>
                    </div>
                    <div class="ch-menu-group ch-menu-group-info">
                        <ul class="ch-menu-area-pub" aria-label="publication menu">
                            <!-- <li><i class="ch-icon ch-icon-logo-short"></i></li> -->
                            <li><a href="{$base}/uzytkownicy">Użytkownicy</a></li>
                            <li><a href="http://forum.squarezone.pl">Forum</a></li>
                          {*{{#skin.publicationMenu}}*}
                              {*<li><a href="{{url}}">{{name}}</a></li>*}
                          {*{{/skin.publicationMenu}}*}
                        </ul>
                        {if not isset($user)}
                        <div class="message">
                            {include file='login.tpl'}
                        </div>
                        {/if}
                        <div id="user-nav">
                        {if isset($user)}
                            
                            <a id="auth-tgr" href="{#user#}/{$user.slug}" data-user-sign-in="true">
                                {if !empty($user.avatar)}
                                <img src="image.php?img={$user.avatar}&size=64x64" alt="{$user.slug}" width="32" height="32">
                                {else}
                                <img src="assets/users/no-avatar.jpg" alt="{$user.slug}" width="32" height="32">
                                {/if}
                            </a>
                            <a href="{$base}/auth/logout" class="log-out-tgr">Wyloguj</a>
                        {else}
                            {*<a id="auth-tgr" href="{$smarty.server.REQUEST_URI}#modal" data-user-sign-in="_false">
                                <span class="icon-user"></span>
                            </a>*}
                        {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {*<script>window.__CORE_HEADER_CONFIG__ = {{{stringedBrowserConfig}}};</script>*}
</header>
