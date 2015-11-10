		<article>
			<header class="inner">
				<h2>Stream...</h2>
			</header>
			<div class="wrapper">
				<section>
					index.tpl
					{foreach from=$aActivities item=a}
					<div class="box">
						<h2><a href="{$base}/news/{$a.slug}">{$a.id_news} {$a.title|stripslashes}</a></h2>
						<div>
							{$a.markup|stripslashes}
						</div>
						<span>{$a.id_author} {$a.user|default:'unknown'} <time>{$a.creation_date}</time> <span>Komentarze: {$a.comments|default:'0'}</span>
					</div>
					{/foreach}
				</section>
			</div>
		</article>