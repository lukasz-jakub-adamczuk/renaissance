<h2>Użytkownicy</h2>
<section class="main-items">
    {foreach from=$names item=name key=$nk}<div class="_front-item regular-item">
        <h3>{$name}</h3>
        <ul class="clean-list">
            {foreach from=$users[$nk] item=nae}
            <li{if $usr::set() and $nae.id_user eq $usr::getId()} class="marked"{/if}>
                <a href="{$base}/{#user#}/{$nae.slug|default:$nae.id_user}">{$nae.name}</a>:
                <span>{$nae.total}</span>
            </li>
            {/foreach}
        </ul>
    </div>{/foreach}
</section>
