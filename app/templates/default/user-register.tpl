		<div>
			<header class="inner">
				<h2>Rejestracja nowego użytkownika</h2>
				<!-- <h1>{$aUser.name|stripslashes}</h1> -->
			</header>
			<div class="inside">
				<section class="center">
					<!-- <h3>{$aUser.name|stripslashes} <span class="tag">{$aUser.id_user}</span></h3> -->
					<form method="post" action="{$base}/{#user#}/rejestracja">
						<div>
							<label for="register-name">Nazwa użytkownika</label>
							<input id="register-name" name="register[name]" type="text" class="input" value="{$smarty.post.register.name|default:''}" placeholder="Wpisz nazwę użytkownika" required>
							<p class="tip">Nazwa użytkownika musi być unikalna, ponieważ służy do identyfikacji w serwisie.</p>
						</div>
						<div>
							<label for="register-email">Adres email</label>
							<input id="register-email" name="register[email]" type="email" class="input" value="{$smarty.post.register.email|default:''}" placeholder="Wpisz adres email" required>
							<p class="tip">Adres email jest konieczny w przypadku odzyskiwania hasła.</p>
						</div>
						<div>
							<label for="register-password">Hasło</label>
							<input id="register-password" name="register[password]" type="password" class="input" minlength="8" maxlength="16" required>
						</div>
						<div>
							<label for="register-password-retype">Powtórz hasło</label>
							<input id="register-password-retype" name="register[password_retype]" type="password" class="input" minlength="8" maxlength="16" required>
						</div>
						<div>
							<p>Coś o akceptacji regulaminu albo polityce prywatności?</p>
							
						</div>
						
						<div class="buttons">
							<button type="submit" class="button color">Zarejestruj</button>
						</div>
					</form>
				</section>
				<footer class="theme">
					<div class="inner theme-dark">
						Będzie pan zadowolony
					</div>
				</footer>
			</div>
		</div>