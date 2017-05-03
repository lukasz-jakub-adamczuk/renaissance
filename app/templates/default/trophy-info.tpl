        <article>
            <header class="inner">
                <h2>Trofeum</h2>
            </header>
            <div class="wrapper">
                <section>
                    <h3>{$aTrophy.name|stripslashes}</h3>
                    <div class="trophy">
                        <span class="icon-trophy large {$aTrophy.type|default:'normal'}"></span>
                        <span class="name">{$aTrophy.name|stripslashes}</span>
                        <p>{$aTrophy.description|stripslashes}</p>
                    </div>
                </section>
            </div>
        </article>