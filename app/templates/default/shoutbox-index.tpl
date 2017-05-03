        <section>
            <header class="inner center">
                <h2>Shoutbox</h2>
            </header>
            <!-- <input type="button" class="worker-8" value="Run Worker8"> -->
            <!-- <input type="button" class="get-shouts" value="get Shoits"> -->
            <div class="inner shoutbox">
                {if isset($user)}
                <form id="shout-post" method="post" action="{$base}/shoutbox/insert">
                    <textarea id="shout-input" name="shout" rows="3" cols="20" class="shout-input" placeholder="Napisz coś..."></textarea>
                    <div class="buttons">
                        <input type="submit" class="button" value="Wyślij">
                    </div>
                </form>
                {else}
                <p class="warning">Konieczne logowanie.</p>
                {/if}
                {if isset($aShouts)}
                <ul class="shouts x-style key-value">
                    {foreach from=$aShouts item=shouts}
                    <li>
                        <img class="author-on-{$shouts.0.class}" src="{$base}{if isset($shouts.0.avatar)}{$shouts.0.avatar}{else}/assets/users/no-avatar.jpg{/if}" alt="{$shouts.0.user_name|default:'Gość'}" width="50" height="50">
                        <!-- <div class="shout"> -->
                            <span>{$shouts.0.user_name}</span> {*$shouts.0.id_author} {$shouts.0.user_slug*}
                            {foreach from=$shouts item=s key=sk}
                            <p class="shout{if $sk eq 0} from-{$shouts.0.class}{/if}">
                                {$s.shout|stripslashes|humanize}
                                <time>{$s.creation_date}</time>
                            </p>
                            {/foreach}
                        <!-- </div> -->

                    </li> 
                    {/foreach}
                </ul>
                {/if}
            </div>
        </section>