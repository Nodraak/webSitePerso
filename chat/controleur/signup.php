<?php
	include_once('modele/init.php');

	echo'<h2>Bienvenue futur membre !</h2>';

	// form envoyé
	if (isset($_POST['pseudo']) && isset($_POST['pass']) && isset($_POST['passre']) && isset($_POST['mail']))
	{
		$bdd = ft_connect_bdd();
		
		$req_check_pseudo = $bdd->prepare('SELECT id FROM users WHERE pseudo = ?');
		$req_check_pseudo->execute(array($_POST['pseudo']));
		$data_check_pseudo = $req_check_pseudo->fetch();

		// pass !=
		if ($_POST['pass'] != $_POST['passre'])
		{
			echo '<p class="alert_ko">Erreur : les mots de passe ne correspondent pas, merci de réesayer.</p>';
			include_once('vue/signup.php');
		}
		// pseudo deja enregistre
		else if ($data_check_pseudo)
		{
			echo '<p class="alert_ko">Erreur : le pseudo est déja pris, merci d\'en choisir un autre.</p>';
			include_once('vue/signup.php');
		}
		// tout est ok
		else
		{
			$pass_hache = sha1($_POST['pass']);
			$pseudo = substr($_POST['pseudo'], 0, 20);
			
			$req = $bdd->prepare('INSERT INTO users (pseudo, pass, mail, signedup, lastCo) VALUES (:pseudo, :pass, :mail, NOW(), NOW())');
			$req->execute(array('pseudo' => $pseudo, 'pass' => $pass_hache, 'mail' => $_POST['mail']));
							
			echo '<p class="alert_ok">Votre compte a bien été créé.</p>
					<p>Vous pouvez maintenant vous connecter en <a href="index.php?page=login">cliquant ici</a>.</p>';
		}
	}
	else // premiere visite de la page
	{
		include_once('vue/signup.php');
	}
?>

