		<article>
			<header class="inner">
				<h2>Trofea</h2>
			</header>
			<div class="wrapper">
				<section>
					<ol class="readable">
					{foreach from=$aTypes item=art}
						<li><a href="{$base}/trophy/{$art.slug}">{$art.name}</a> ({$art.items|default:'???'})</li>
					{/foreach}
					</ol>
				</section>
			</div>
		</article>