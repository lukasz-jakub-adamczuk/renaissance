<div class="items {$type}-theme">
			{foreach from=$items item=object}<article class="item l-item_ _bc" _data-id="{$object[$object.key]}">
					<a href="{$base}/{$object.url}" class="block l-item bc">
						{*<figure>
							<picture>
								<source media="(min-resolution: 192dpi)" srcset="image.php?img={$object.fragment|default:''}&size=640x360&margin=&x=center&y=center 2x" class="spinner">
								<img src="image.php?img={$object.fragment|default:''}&size=320x180&margin=&x=center&y=center" class="spinner">
							</picture>
						</figure>*}
						{image file=$object.fragment size=320x180}
						{if $object.type eq 'news'}
						<strong class="category bgc">News</strong>
						{/if}
						{if $object.type eq 'article'}
						<strong class="category bgc">Artykuły</strong>
						{/if}
						{if $object.type eq 'story'}
						<strong class="category bgc">{$object.category}</strong>
						{/if}
						<span>{$object.title|stripslashes|humanize}</span>
					</a>
					<footer>
						<time class="meta-time _icon-clock-o">{$object.creation_date|humanize_date}</time>
						<!-- <time class="meta-time _icon-clock-o">{$object.creation_date|date_format:'%d-%m-%Y'}</time> -->
						<a href="{$base}/{$object.url}#comments" class="meta-comments _icon-comment">{$object.comments|pluralize:'komentarz':'komentarze':'komentarzy'}</a>
					</footer>
				</article>{/foreach}
			</div>