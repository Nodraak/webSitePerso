<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="styles.css" />
		<title>Page perso d'Adrien !</title>
	</head>

	<body>
		<header>
			<nav>
				<ul>
					<li><a href=index.html>Home</a></li>
					<li><a href=links/home.html>Liens</a></li>
					<li><a href=memos/home.html>Memos</a></li>
				</ul>
			</nav>
		</header>
		
		<div id=block_page>

		<h1><?php echo "du php ....";
			echo "autre chose";
		?>Petit facebook familial, pour tester les formulaire le php toussa toussa ..</h1>
		<p>Nous aurions besoin de qq infos</p>

		<form method="post" action="traitement.php">
			<fieldset> <legend>La base</legend>
			<p>
				<label for="pseudo">Votre pseudo : </label>
				<input type="text" name="pseudo" id="pseudo" />
			</p>
			<p>
				<label for="pseudo2">Votre pseudo : (2) </label>
				<input type="text" name="pseudo2" id="pseudo2" placeholder="bon ok ya un bug" size="60" />
			</p>
			<p>
				<label for="password">Un mot de passe : </label>
				<input type="password" name="password" id="password" placeholder="un bon hein !" />
			</p>
			<p>
				<label for="idees">Qq idées d'amelioration ?</label><br />
				<textarea name="idees" id="idees" rows="5" cols="40">No way bro', il est ouf ton site !</textarea>	
			</p>
			<p>
				<label for="email">Un mail pour vous joindre : </label>
				<input type="email" name="email" id="email" />
			</p>
			<p>
				<label for="age">Entrez votre age svp : </label>
				<input type="number" min="1" max="99" />
			</p>
			</fieldset>
			<fieldset> <legend>Du bonus</legend>
			<p>Aller on continue, maintenant des checkbox et tt ... :</p>
			<p>
				Cochez les aliments que vous aimez manger : <br />
				<input type="checkbox" name="frites" id="frites" />
					<label for="frites">Frites</label> <br />
				<input type="checkbox" name="steak" id="steak" />
					<label for="steak">Steak haché</label><br />
				<input type="checkbox" name="epinards" id="epinards" />
					<label for="epinards">Epinards</label><br />
				<input type="checkbox" name="huitres" id="huitres" />
					<label for="huitres">Huitres</label>
			</p>
			<p>
				Veuillez indiquer la tranche d'âge dans laquelle vous vous situez :<br />
				<input type="radio" name="age" value="moins15" id="moins15" checked />
					<label for="moins15">Moins de 15 ans</label><br />
				<input type="radio" name="age" value="medium15-25" id="medium15-25" />
					<label for="medium15-25">15-25 ans</label><br />
				<input type="radio" name="age" value="medium25-40" id="medium25-40" />
					<label for="medium25-40">25-40 ans</label><br />
				<input type="radio" name="age" value="plus40" id="plus40" />
					<label for="plus40">Encore plus vieux que ça ?!</label>
			</p>
			<p>
				<label for="pays">Dans quel pays habitez-vous ?</label><br />
				<select name="pays" id="pays">
				<optgroup label="Europe">
					<option value="france">France</option>
					<option value="espagne">Espagne</option>
					<option value="italie">Italie</option>
					<option value="royaume-uni">Royaume-Uni</option>
				</optgroup>
				<optgroup label="Autres">
					<option value="canada">Canada</option>
					<option value="etats-unis">États-Unis</option>
					<option value="chine">Chine</option>
					<option value="japon">Japon</option>
				</optgroup>
				</select>
			</p>
			</fieldset>

			<span class="test">test<input type="submit" value="Envoyer" /></span>

		</form>

		<p>Merci !</p>

		</div>
	</body>
</html>
