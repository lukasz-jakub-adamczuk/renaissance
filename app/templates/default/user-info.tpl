{if isset($siteUser)}<div>
    <header class="inner">
        <!-- <h2>Profil użytkownika</h2> -->
        <h1>{$siteUser.name|stripslashes}</h1>
    </header>
    <div class="wrapper">
        <section>
            <!-- <h3>{$siteUser.name|stripslashes} <span class="tag">{$siteUser.id_user}</span></h3> -->
            <div class="clearfix">
                <div class="column">
                    {image file=$siteUser.avatar size=240x240}
                </div><div class="column">
                    <h3>Profil</h3>
                    <ul class="block-values">
                        <li>Użytkownik: <span>{$siteUser.name|default:"brak danych"}</span></li>
                        <li>Grupa: <span>{$siteUser.group_name|default:"brak danych"}</span></li>
                        <li>Data rejestracji: <span>{$siteUser.register_date|default:"brak danych"}</span></li>
                        <li>Ostatnia wizyta: <span>{$siteUser.last_visit|default:"brak danych"}</span></li>
                        <li>Adres email: {if isset($user)}<span>{$siteUser.email|default:"brak danych"}</span>{else}<span>Tylko dla zalogowanych</span>{/if}</li>
                    </ul>
                </div><div class="column">
                    <h3>Treść</h3>
                    <ul class="block-values">
                        <li>Aktualności: <span>{$siteUser.counters.news|default:0}</span></li>
                        <li>Artykuły: <span>{$siteUser.counters.article|default:0}</span></li>
                        <li>Publicystyka: <span>{$siteUser.counters.story|default:0}</span></li>
                        <li>Galerie: <span>{$siteUser.counters.gallery|default:0}</span></li>
                        <li>Shouty: <span>{$siteUser.counters.shout|default:0}</span></li>
                    </ul>
                </div><div class="column">
                    <h3>Komentarze</h3>
                    <ul class="block-values">
                        <li>Kom. aktualności: <span>{$siteUser.comments.news|default:0}</span></li>
                        <li>Kom. gier: <span>{$siteUser.comments.article|default:0}</span></li>
                        <li>Kom. publicystyki: <span>{$siteUser.comments.story|default:0}</span></li>
                        <li>Kom. galerii: <span>{$siteUser.comments.gallery|default:0}</span></li>
                        <li>Kom. użytkowników: <span>{$siteUser.comments.user|default:0}</span></li>
                    </ul>
                </div>
            </div>
        </section>
        <footer id="trophies" class="theme">
            <div class="inner theme-dark">
                <p></p>
                {*<h2 class="padding">Trofea</h2>
                <div class="trophy">
                    <span class="icon-trophy bronze"></span>
                    <span class="name">Zwykły użytkownik</span>
                    <p>Statystyczna osoba korzystająca z naszego serwisu.</p>
                </div>
                <div class="trophy">
                    <span class="icon-trophy silver"></span>
                    <span class="name">Prawdziwy bohater</span>
                    <p>Osoba zasłużona dla działania naszego serwisu.</p>
                </div>
                <div class="trophy">
                    <span class="icon-trophy gold"></span>
                    <span class="name">Bohater SquareZone</span>
                    <p>Wybitna i aktywna osoba. Rozpoznawalny głos naszego serwisu.</p>
                </div>
                <div class="trophy">
                    <span class="icon-trophy platinum"></span>
                    <span class="name">Redaktor naczelny</span>
                    <p>Osoba wyznaczająca kierunek rozwoju naszego serwisu.</p>
                </div>*}
            </div>
        </footer>
    </div>
</div>
{include file='common/comments.tpl' commentPrimaryKey='id_user_comment'}
{else}
<div>
    <header class="inner">
        <h1>Błąd</h1>
    </header>
    <section class="inner">
        <p>Brak szukanego użytkownika!</p>
    </section>
</div>
{/if}