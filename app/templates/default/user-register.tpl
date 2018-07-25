<header class="inner">
    <h2>Rejestracja nowego użytkownika</h2>
    <!-- <h1>{$aUser.name|stripslashes}</h1> -->
</header>
<style rel="stylesheet" type="text/css">
{literal}
.tip {
    color: #888;
}
.form-field {
    margin-bottom: 1em;
}
{/literal}
</style>
<section class="center">
    <!-- <h3>{$aUser.name|stripslashes} <span class="tag">{$aUser.id_user}</span></h3> -->
    <form method="post" action="{$base}/{#user#}/rejestracja">
        <div class="form-field">
            <label for="register-name">Nazwa użytkownika</label>
            <input id="register-name" name="register[name]" type="text" class="input" value="{$smarty.post.register.name|default:''}" placeholder="Wpisz nazwę użytkownika" required>
            {if isset($errors.name)}
                <div class="messages" style="margin-top: .5em;">
                {foreach $errors.name as $err}
                    <p class="msg alert" style="padding: .5em;">{$err}</p>
                {/foreach}
                </div>
            {/if}
            <p class="tip">Nazwa użytkownika musi być unikalna, ponieważ służy do identyfikacji w serwisie.</p>
        </div>
        <div class="form-field">
            <label for="register-email">Adres email</label>
            <input id="register-email" name="register[email]" type="email" class="input" value="{$smarty.post.register.email|default:''}" placeholder="Wpisz adres email" required>
            {if isset($errors.email)}
                <div class="messages" style="margin-top: .5em;">
                {foreach $errors.email as $err}
                    <p class="msg alert" style="padding: .5em;">{$err}</p>
                {/foreach}
                </div>
            {/if}
            <p class="tip">Adres email jest konieczny w przypadku odzyskiwania hasła.</p>
        </div>
        <div class="form-field">
            <label for="register-password">Hasło</label>
            <input id="register-password" name="register[password]" type="password" class="input" minlength="8" maxlength="16" required value="{$smarty.post.register.password|default:''}" >
            {if isset($errors.password)}
                <div class="messages" style="margin-top: .5em;">
                {foreach $errors.password as $err}
                    <p class="msg alert" style="padding: .5em;">{$err}</p>
                {/foreach}
                </div>
            {/if}
        </div>
        <div class="form-field">
            <label for="register-password-retype">Powtórzone hasło</label>
            <input id="register-password-retype" name="register[password_retype]" type="password" class="input" minlength="8" maxlength="16" required value="{$smarty.post.register.password_retype|default:''}" >
            {if isset($errors.password_retype)}
                <div class="messages" style="margin-top: .5em;">
                {foreach $errors.password_retype as $err}
                    <p class="msg alert" style="padding: .5em;">{$err}</p>
                {/foreach}
                </div>
            {/if}
        </div>
        <div class="form-field">
            <label for="register-challenge">Wyzwanie dla ludzi</label>
            <input id="register-challenge" name="register[challenge]" class="input" required>
            {if isset($errors.challenge)}
                <div class="messages" style="margin-top: .5em;">
                {foreach $errors.challenge as $err}
                    <p class="msg alert" style="padding: .5em;">{$err}</p>
                {/foreach}
                </div>
            {/if}
            <p class="tip">Wpisz numer aktualnego miesiąca.</p>
        </div>
        <div class="messages" style="margin-top: .5em;">
            <p class="msg info" style="padding: .5em;">Odzyskiwanie hasła jeszcze nie działa, więc lepiej pamiętaj swoje hasło ;)</p>
        </div>
        {*<div>
            <label for="register-password-retype">Akceptuję polityce prywatności?</label>
        </div>*}
        <div class="buttons">
            <button type="submit" class="button color">Zarejestruj</button>
        </div>
    </form>
</section>