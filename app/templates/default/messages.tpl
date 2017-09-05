{if isset($aMsgs)}
<div class="messages">
    {foreach from=$aMsgs item=msg}
    <span{if isset($msg.type)} class="msg {$msg.type}"{/if}>
        {$msg.text}
    </span>
    {/foreach}
</div>
{/if}