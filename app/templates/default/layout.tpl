{config_load file='variables.conf' section='controllers'}
<!DOCTYPE html>
<html>
{include file='header.tpl'}
<body>
	{if $smarty.const.DEBUG_MODE}{include file='debug.tpl'}{/if}
	{include file='dialog.tpl'}
	<main>
		{include file='nav.tpl'}
		<!-- only for desktop -->
		{include file='search.tpl'}
		{include file='breadcrumbs.tpl'}

		{include file="$content.tpl"}

		{include file='footer.tpl'}
		
		{include file='modal.tpl'}
	</main>
	{include file='scripts.tpl'}
</body>
</html>