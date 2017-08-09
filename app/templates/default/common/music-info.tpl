{if isset($musicInfo)}
                    <img class="logo" src="assets/games/{$article.category_abbr}/logo.jpg" alt="game ost logo" />
                    <aside>
                        <h3>{$musicInfo.title}</h3>
                        <ul class="x-style key-value fixed-cols">
                            <li>Numer katalogowy: <span>{$musicInfo['catalog-number']}</span></li>
                            <li>Wydawca: <span>{$musicInfo.publisher}</span></li>
                            <li>Data wydania: <span>{$musicInfo['release-date']}</span></li>
                            <li>Kompozycja: <span>{$musicInfo.composer}</span></li>
                            <li>Aranżacja: <span>{$musicInfo.arranger}</span></li>
                            <li>Miejsce nagrania: <span>{$musicInfo.recorded}</span></li>
                            <li>Nośnik: <span>{$musicInfo.format}</span></li>
                        </ul>
                    </aside>{/if}