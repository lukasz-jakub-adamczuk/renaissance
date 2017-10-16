<h1>{$siteUser.name|stripslashes}</h1>
<section>
    <!-- {image file=$siteUser.avatar} -->
    {if $siteUser.avatar}
        <img src="{$siteUser.avatar}" alt="">
    {/if}

    <h3>Profil</h3>
    <ul class="block-values">
        <li>Użytkownik: <span>{$siteUser.name|default:"brak danych"}</span></li>
        <li>Grupa: <span>{$siteUser.group_name|default:"brak danych"}</span></li>
        <li>Data rejestracji: <span>{$siteUser.register_date|default:"brak danych"}</span></li>
        <li>Ostatnia wizyta: <span>{$siteUser.last_visit|default:"brak danych"}</span></li>
        <li>Adres email: {if $usr::set()}<span>{$siteUser.email|default:"brak danych"}</span>{else}<span>Tylko dla zalogowanych</span>{/if}</li>
    </ul>

    <h3>Treść</h3>
    <ul class="block-values">
        <li>Aktualności: <span>{$siteUser.counters.news|default:0}</span></li>
        <li>Artykuły: <span>{$siteUser.counters.article|default:0}</span></li>
        <li>Publicystyka: <span>{$siteUser.counters.story|default:0}</span></li>
        <li>Galerie: <span>{$siteUser.counters.gallery|default:0}</span></li>
        <li>Shouty: <span>{$siteUser.counters.shout|default:0}</span></li>
    </ul>

    <h3>Komentarze</h3>
    <ul class="block-values">
        <li>Kom. aktualności: <span>{$siteUser.comments.news|default:0}</span></li>
        <li>Kom. gier: <span>{$siteUser.comments.article|default:0}</span></li>
        <li>Kom. publicystyki: <span>{$siteUser.comments.story|default:0}</span></li>
        <li>Kom. galerii: <span>{$siteUser.comments.gallery|default:0}</span></li>
        <li>Kom. użytkowników: <span>{$siteUser.comments.user|default:0}</span></li>
    </ul>
</section>
{include file='partials/comments.tpl' commentPrimaryKey='id_user_comment'}
