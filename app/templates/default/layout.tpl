{config_load file='variables.conf' section='controllers'}
<!DOCTYPE html>
<html>
{include file='head.tpl'}
<body>
    {if $smarty.const.DEBUG_MODE}{include file='debug.tpl'}{/if}
    {include file='header.tpl'}
    <main>
        <!-- only for desktop -->
        {include file='search.tpl'}
        {include file='breadcrumbs.tpl'}

        {include file="$content.tpl"}
    </main>
    {include file='footer.tpl'}
    {include file='scripts.tpl'}
</body>
</html>
