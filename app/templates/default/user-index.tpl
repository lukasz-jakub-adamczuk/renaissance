        <article>
            <header class="inner">
                <h2>Użytkownicy</h2>
            </header>
            <div class="wrapper">
                <section>
                    <div class="clearfix">
                        <div class="column">
                            <h3>Aktualności</h3>
                            {if isset($aNewsAuthorsEver)}
                            <ul class="_x-padding x-style key-value">
                                {foreach from=$aNewsAuthorsEver item=nae}
                                <li{if isset($user) and $nae.id_user eq $user.id} class="marked"{/if}><a href="{$base}/{#user#}/{$nae.slug|default:$nae.id_user}">{$nae.name}:</a> <span>{$nae.total}</span></li>
                                {/foreach}
                            </ul>
                            {/if}
                        </div><div class="column">
                            <h3>Artykuły</h3>
                            {if isset($aArticleAuthorsEver)}
                            <ul class="_x-padding x-style key-value">
                                {foreach from=$aArticleAuthorsEver item=aae}
                                <li{if isset($user) and $aae.id_user eq $user.id} class="marked"{/if}><a href="{$base}/{#user#}/{$aae.slug|default:$aae.id_user}">{$aae.name}:</a> <span>{$aae.total}</span></li>
                                {/foreach}
                            </ul>
                            {/if}
                        </div><div class="column">
                            <h3>Publicystyka</h3>
                            {if isset($aStoryAuthorsEver)}
                            <ul class="_x-padding x-style key-value">
                                {foreach from=$aStoryAuthorsEver item=sae}
                                <li{if isset($user) and $sae.id_user eq $user.id} class="marked"{/if}><a href="{$base}/{#user#}/{$sae.slug|default:$sae.id_user}">{$sae.name}:</a> <span>{$sae.total}</span></li>
                                {/foreach}
                            </ul>
                            {/if}
                        </div><div class="column">
                            <h3>Komentarze aktualności</h3>
                            {if isset($aNewsCommentsAuthorsEver)}
                            <ul class="_x-padding x-style key-value">
                                {foreach from=$aNewsCommentsAuthorsEver item=ncae}
                                <li{if isset($user) and $ncae.id_user eq $user.id} class="marked"{/if}><a href="{$base}/{#user#}/{$ncae.slug|default:$ncae.id_user}">{$ncae.name}</a>: <span>{$ncae.total}</span></li>
                                {/foreach}
                            </ul>
                            {/if}
                        </div><div class="column">
                            <h3>Komentarze artykułów</h3>
                            {if isset($aArticleCommentsAuthorsEver)}
                            <ul class="_x-padding x-style key-value">
                                {foreach from=$aArticleCommentsAuthorsEver item=acae}
                                <li{if isset($user) and $acae.id_user eq $user.id} class="marked"{/if}><a href="{$base}/{#user#}/{$acae.slug|default:$acae.id_user}">{$acae.name}</a>: <span>{$acae.total}</span></li>
                                {/foreach}
                            </ul>
                            {/if}
                        </div><div class="column">
                            <h3>Komentarze publicystyki</h3>
                            {if isset($aStoryCommentsAuthorsEver)}
                            <ul class="_x-padding x-style key-value">
                                {foreach from=$aStoryCommentsAuthorsEver item=scae}
                                <li{if isset($user) and $scae.id_user eq $user.id} class="marked"{/if}><a href="{$base}/{#user#}/{$scae.slug|default:$scae.id_user}">{$scae.name}</a>: <span>{$scae.total}</span></li>
                                {/foreach}
                            </ul>
                            {/if}
                        </div><div class="column">
                            <h3>Oceny gier</h3>
                            {if isset($aArticleVerdictsAuthorsEver)}
                            <ul class="_x-padding x-style key-value">
                                {foreach from=$aArticleVerdictsAuthorsEver item=avae}
                                <li{if isset($user) and $avae.id_user eq $user.id} class="marked"{/if}><a href="{$base}/{#user#}/{$avae.slug|default:$avae.id_user}">{$avae.name}</a>: <span>{$avae.total}</span></li>
                                {/foreach}
                            </ul>
                            {/if}
                        </div>
                    </div>
                </section>
                <footer class="theme">
                    <div class="inner theme-dark">
                        <!-- cos tu bedzie jeszcze -->
                    </div>
                </footer>
            </div>
        </article>