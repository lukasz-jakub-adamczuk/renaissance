{if isset($verdict)}<h2 class="padding">Werdykt</h2>
                        <div class="verdict" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
                            <img src="assets/users/avatars/{$verdict.author_slug}.png" alt="{$verdict.author_name}"><span itemprop="ratingValue" class="score">{$verdict.rating}</span>
                            <meta itemprop="worstRating" content="0">
                            <meta itemprop="bestRating" content="10">
                            <p>{$verdict.verdict|stripslashes|humanize}</p>
                            <div class="features">
                                <h4>Zalety</h4>
                                <ul class="advantages">
                                    {foreach from=$verdict.plus item=p}
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
                                    {foreach from=$verdict.minus item=m}
                                    <li>
                                        <span class="icon-minus-circle"></span>
                                        <span>{$m}</span>
                                    </li>
                                    {/foreach}
                                </ul>
                            </div>
                            {*<div class="rating editor-score">
                                <strong>Redakcja</strong>
                                <span>{$verdict.rating}</span>
                            </div>*}
                        </div>{/if}