{if isset($aMusicInfo)}
                    <img class="logo" src="assets/games/{$aArticle.category_abbr}/logo.jpg" alt="game ost logo" />
                    <aside>
                        <h3>{$aMusicInfo.title}</h3>
                        <ul class="x-style key-value fixed-cols">
                            <li>Numer katalogowy: <span>{$aMusicInfo['catalog-number']}</span></li>
                            <li>Wydawca: <span>{$aMusicInfo.publisher}</span></li>
                            <li>Data wydania: <span>{$aMusicInfo['release-date']}</span></li>
                            <li>Kompozycja: <span>{$aMusicInfo.composer}</span></li>
                            <li>Aranżacja: <span>{$aMusicInfo.arranger}</span></li>
                            <li>Miejsce nagrania: <span>{$aMusicInfo.recorded}</span></li>
                            <li>Nośnik: <span>{$aMusicInfo.format}</span></li>
                        </ul>
                    </aside>{/if}