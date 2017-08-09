{if $article.template eq 'intro' and isset($gameLogo)}
                        <img class="game-logo" src="{$base}/image.php?img={$gameLogo.0.fragment}&size=640x" alt="game logo" />
                    {/if}