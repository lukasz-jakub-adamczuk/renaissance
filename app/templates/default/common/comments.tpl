{if isset($comments) and count($comments) gt 0}<div id="comments">
            <div class="inner">
                <div class="comments">
                    <h2 class="padding">Komentarze <span>({$navigator.loaded})</span></h2>
                    {foreach from=$comments item=c}
                    <section data-comment-id="{$c[$commentPrimaryKey]}">
                        <header class="meta">
                            {if $c.id_author}<a href="{$base}/{#user#}/{$c.author_slug|default:'???'}" rel="nofollow">{$c.author_name}</a>{else}{$c.author_name|default:"Gość"}{/if} ~ {$c.creation_date|date_format:"%d %B %Y, %H:%M"|localize_date}
                            {if false}
                            <a href="{$base}/{$ctrl}-comment/{$c[$commentPrimaryKey]}/remove" class="icon-remove visible-on-hover"></a>
                            {/if}
                        </header>
                        {$c.comment|stripslashes|bbcode|replace:'<br />':'<br>'|humanize}
                    </section>
                    {/foreach}
                </div>
            </div>
        </div>{else}<a id="comments"></a>{/if}

        <div id="comment-form" class="theme">
            <div class="inner">
                <h2 class="padding">Dodaj komentarz</h2>
                <div class="suggests">
                    <p>Wpisz treść komentarza w opowiednim polu. Pamiętaj, że HTML jest <strong>niedozwolony</strong>.</p>
                    <p>Niezarejestrowani użytkownicy uzupełniają również pole <span>autora</span>.</p>
                    <p>Konieczna jest również weryfikacja niezalogowanych użytkowników.</p>
                    <p>Wypowiedzi obraźliwe, infantylne oraz nie na temat będą moderowane - pisząc postaraj się zwiększyć wartość dyskusji.</p>
                </div>
                <form id="add-comment-form" method="post" action="{$base}/form/insert">
                    {foreach from=$commentsForm.request item=value key=vk}
                    <input name="request[{$vk}]" type="hidden" value="{$value}">
                    {/foreach}
                    <input name="dataset[{$commentsForm.object}]" type="hidden" value="{$commentsForm.id_object}">
                    <div>
                        <label for="form-comment">Treść</label>
                        <textarea id="form-comment" name="dataset[comment]" rows="5" cols="40" class="input" placeholder="Wpisz treść komentarza" required></textarea>
                    </div>
                    {if isset($user)}
                    <input name="dataset[id_author]" type="hidden" class="input" value="{$user.id}">
                    <input name="dataset[visible]" type="hidden" class="input" value="1">
                    {else}
                    <div>
                        <label for="form-check">Tymczasowa forma weryfikacji użytkowników (aktualny rok)</label>
                        <input id="form-check" name="dataset[check]" type="text" class="input" placeholder="Wpisz aktualny rok" required>
                    </div>
                    <div>
                        <label for="form-author">Autor</label>
                        <input id="form-author" name="dataset[author]" type="text" class="input" placeholder="Wpisz imię lub pseudonim" required>
                    </div>
                    {/if}
                    <div class="v-padding">
                        <input name="action[add]" type="submit" value="Dodaj komentarz" class="button color">
                    </div>
                </form>
            </div>
        </div>