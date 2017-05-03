<div id="overlay" class="hidden">
        <div class="dialog">
            {if !isset($smarty.session.user)}
            <header>
                <h3>Logowanie</h3>
                <span id="close-tgr" class="icon-close"></span>
            </header>
            <div>
                {include file='login.tpl'}
            </div>
            {else}
            <header>
                <h3>Nowy początek</h3>
                <span id="close-tgr" class="icon-close"></span>
            </header>
            <div>
                <p>Nasza strona jest szybka i nowoczesna. Staramy się, aby Twoje doświadczenia były jak najlepsze. Pamiętaj o używaniu najnowszej wersji swojej ulubionej przeglądarki.</p>
                <!-- <p><input id="dialog-input" type="checkbox">Nie pokazuj więcej tego komunikatu.</p> -->
                <p class="tar x-margin"><strong>SquareZone</strong></p>
            </div>
            {/if}
        </div>
    </div>