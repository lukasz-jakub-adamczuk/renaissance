{config_load file='variables.conf' section='controllers'}
<!DOCTYPE html>
<html lang="pl">
{include file='head.tpl'}
<body>
    {if $smarty.const.DEBUG_MODE}{include file='debug.tpl'}{/if}
    {include file='header.tpl'}
    <main>
        <!-- only for desktop -->
        {include file='search.tpl'}
        {include file='breadcrumbs.tpl'}

        {include file='messages.tpl'}
        <div class="main-content">
            {include file="$content.tpl"}
        </div>
    </main>
    {include file='footer.tpl'}
    {include file='scripts.tpl'}
</body>
</html>
