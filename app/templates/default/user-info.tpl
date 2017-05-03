        {if isset($aUser)}<div>
            <header class="inner">
                <!-- <h2>Profil użytkownika</h2> -->
                <h1>{$aUser.name|stripslashes}</h1>
            </header>
            <div class="wrapper">
                <section>
                    <!-- <h3>{$aUser.name|stripslashes} <span class="tag">{$aUser.id_user}</span></h3> -->
                    <div class="clearfix">
                        <div class="column">
                            {if !empty($aUser.avatar)}
                            <img src="image.php?img={$aUser.avatar}&size=240x240" width="240" height="240" class="profile" />
                            {else}
                            <img src="assets/users/no-avatar.jpg" width="240" height="240" class="profile" />
                            {/if}
                        </div><div class="column">
                            <h3>Profil</h3>
                            <ul class="block-values">
                                <li>Użytkownik: <span>{$aUser.name|default:"brak danych"}</span></li>
                                <li>Grupa: <span>{$aUser.group_name|default:"brak danych"}</span></li>
                                <li>Data rejestracji: <span>{$aUser.register_date|default:"brak danych"}</span></li>
                                <li>Ostatnia wizyta: <span>{$aUser.last_visit|default:"brak danych"}</span></li>
                                <li>Adres email: {if isset($user)}<span>{$aUser.email|default:"brak danych"}</span>{else}<span>Tylko dla zalogowanych</span>{/if}</li>
                            </ul>
                        </div><div class="column">
                            <h3>Treść</h3>
                            <ul class="block-values">
                                <li>Aktualności: <span>{$aUser.counters.news|default:0}</span></li>
                                <li>Artykuły: <span>{$aUser.counters.article|default:0}</span></li>
                                <li>Publicystyka: <span>{$aUser.counters.story|default:0}</span></li>
                                <li>Galerie: <span>{$aUser.counters.gallery|default:0}</span></li>
                                <li>Shouty: <span>{$aUser.counters.shout|default:0}</span></li>
                            </ul>
                        </div><div class="column">
                            <h3>Komentarze</h3>
                            <ul class="block-values">
                                <li>Kom. aktualności: <span>{$aUser.comments.news|default:0}</span></li>
                                <li>Kom. gier: <span>{$aUser.comments.article|default:0}</span></li>
                                <li>Kom. publicystyki: <span>{$aUser.comments.story|default:0}</span></li>
                                <li>Kom. galerii: <span>{$aUser.comments.gallery|default:0}</span></li>
                                <li>Kom. użytkowników: <span>{$aUser.comments.user|default:0}</span></li>
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
        {include file='common/comments.tpl' sCommentPrimaryKey='id_user_comment'}
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