<div itemscope itemtype="http://schema.org/Review" class="relative">
<meta itemprop="datePublished" content="{$aArticle.creation_date|date_format:'%Y-%m-%d'}">
<h2 class="padding">Statystyka</h2>
{if isset($aArticle.template) and $aArticle.template eq 'review'}<ul class="x-style key-value padding">
							<li>Data publikacji: <span>{$aArticle.creation_date|date_format:'%d %B %Y'}</span></li>
							<li>Autor: <span itemprop="author">{$aArticle.author_name|default:$aArticle.id_author}</span></li>
							<li>Artykuł czytany: <span>{$aArticle.views}</span></li>
							{if $aArticle.rated gt 0}<li>Głosy oddane: <span>{$aArticle.rated}</span></li>
							<li>Średnia ocen: <span>{if $aArticle.sum eq "0"}0{else}{($aArticle.sum/$aArticle.rated)|string_format:'%.1f'|replace:',':'.'}{/if}</span></li>{/if}
						</ul>
						{else}
						<ul class="x-style key-value padding">
							<li>Data publikacji: <span>{$aArticle.creation_date}</span></li>
							<li>Autor: <span>{$aArticle.author_name|default:$aArticle.id_author}</span></li>
							<li>Artykuł czytany: <span>{$aArticle.views}</span></li>
							{if $aArticle.rated gt 0}<li>Głosy oddane: <span>{$aArticle.rated}</span></li>
							<li>Średnia ocen: <span>{if $aArticle.sum eq "0"}0{else}{($aArticle.sum/$aArticle.rated)|string_format:'%.1f'|replace:',':'.'}{/if}</span></li>{/if}
						</ul>{/if}
						{*{if $aArticle.template eq 'review'}
						<div class="rating community-score">
							<strong>Społeczność</strong>
							{if $aArticle.rated > 10}
							<span>{($aArticle.sum/$aArticle.rated)|string_format:'%.1f'|replace:',':'.'}</span>
							{else}
							<span>?</span>
							{/if}
						</div>
						{/if}*}
</div>
