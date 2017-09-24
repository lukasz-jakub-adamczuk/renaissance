<a id="komentarze"></a>
{if isset($comments) and count($comments) gt 0}
<div class="comments">
    <h2>Komentarze <span>({$navigator.loaded})</span></h2>
    {foreach from=$comments item=c}
    <section id="komentarz-{$c[$commentPrimaryKey]}" data-comment-id="{$c[$commentPrimaryKey]}">
        <header class="comment-header">
            {if $c.id_author}<a href="{$base}/{#user#}/{$c.author_slug}" rel="nofollow">{$c.author_name}</a>{else}{$c.author_name|default:"Gość"}{/if} ~ {$c.creation_date|date_format:"%d %B %Y, %H:%M"|localize_date}
            {if $c.visible eq 0}<span>Ten komentarz wymaga akceptacji moderatora.</span>{/if}
            {if $usr::atLeast('admin')}
            <a href="{$base}/{$ctrl}-comment/{$c[$commentPrimaryKey]}" class="icon-edit visible-on-hover"></a>
            {/if}
            {if $usr::atLeast('moderator')}
            <a href="{$base}/{$ctrl}-comment/{$c[$commentPrimaryKey]}/remove" class="icon-remove visible-on-hover"></a>
            {if $c.visible eq 0}<a href="{$base}/{$ctrl}-comment/{$c[$commentPrimaryKey]}/accept" class="icon-checkmark visible-on-hover"></a>{/if}
            {/if}
        </header>
        {if $c.visible eq 0}
        <div class="blured">
            {'Przykro mi, ale nie przeczytasz tak łatwo tego komentarza...'|humanize}
        <div>
        {else}
        <div>
            {$c.comment|stripslashes|bbcode|replace:'<br />':'<br>'|humanize}
        <div>
        {/if}
    </section>
    {/foreach}
</div>
{/if}

<div id="dodaj-komentarz">
    <div class="comment-form">
        <h2>Dodaj komentarz</h2>
        <div class="suggestions">
            <p>Wpisz treść komentarza w opowiednim polu. Pamiętaj, że HTML jest <strong>niedozwolony</strong>.</p>
            <p>Niezarejestrowani użytkownicy uzupełniają również pole <span>autora</span>.</p>
            <p>Konieczna jest również weryfikacja niezalogowanych użytkowników.</p>
            <p>Wypowiedzi obraźliwe, infantylne oraz nie na temat będą moderowane - pisząc postaraj się zwiększyć wartość dyskusji.</p>
        </div><form id="add-comment-form" method="post" action="{$base}/form/comment">
            {foreach from=$commentsForm.request item=value key=vk}
            <input name="request[{$vk}]" type="hidden" value="{$value}">
            {/foreach}
            <input name="dataset[{$commentsForm.object}]" type="hidden" value="{$commentsForm.id_object}">
            <div>
                <label for="form-comment">Treść</label>
                <textarea id="form-comment" name="dataset[comment]" rows="5" cols="40" class="input" placeholder="Wpisz treść komentarza" required></textarea>
            </div>
            {if $usr::set()}
            <input name="dataset[id_author]" type="hidden" class="input" value="{$usr::getId()}">
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
            <div class="form-buttons">
                <input name="action[add]" type="submit" value="Dodaj komentarz" class="button color">
            </div>
        </form>
    </div>
</div>