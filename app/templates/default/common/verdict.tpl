{if isset($aVerdict)}<h2 class="padding">Werdykt</h2>
                        <div class="verdict" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                            <img src="assets/site/redaction/{$aVerdict.author_slug}.png" alt="{$aVerdict.author_name}"><span itemprop="ratingValue" class="score">{$aVerdict.rating}</span>
                            <meta itemprop="worstRating" content="0">
                            <meta itemprop="bestRating" content="10">
                            <p>{$aVerdict.verdict|stripslashes|humanize}</p>
                            <div class="features">
                                <h4>Zalety</h4>
                                <ul class="advantages">
                                    {foreach from=$aVerdict.plus item=p}
                                    <li>
                                        <span class="icon-plus-circle"></span>
                                        <span>{$p}</span>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                            <div class="features">
                                <h4>Wady</h4>
                                <ul class="disadvantages">
                                    {foreach from=$aVerdict.minus item=m}
                                    <li>
                                        <span class="icon-minus-circle"></span>
                                        <span>{$m}</span>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                            {*<div class="rating editor-score">
                                <strong>Redakcja</strong>
                                <span>{$aVerdict.rating}</span>
                            </div>*}
                        </div>{/if}