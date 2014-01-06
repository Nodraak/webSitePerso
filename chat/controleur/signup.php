<?php
	include_once('modele/init.php');
	include_once('modele/signup.php');

	// form envoyé
	if (isset($_POST['pseudo']) AND isset($_POST['pass']) AND isset($_POST['passre']) AND isset($_POST['mail']))
	{
		$bdd = ft_connect_bdd();
		$req_check_pseudo = $bdd->prepare('SELECT id FROM users WHERE pseudo = :pseudo');
		$req_check_pseudo->execute(array('pseudo' => $_POST['pseudo']));
		$data_check_pseudo = $req_check_pseudo->fetch();

		// pass !=
		if ($_POST['pass'] != $_POST['passre'])
		{
			echo '<p class="alert_ko">Erreur : les mots de passe ne correspondent pas, merci de réesayer.</p>';
			ft_print_signup_form();
		}
		// pseudo deja enregistre
		else if ($data_check_pseudo) // check mail unique, utile ?
		{
			echo '<p class="alert_ko">Erreur : le pseudo est déja pris, merci de réesayer.</p>';
			ft_print_signup_form();
		}
		// tout est ok
		else
		{
			$pass_hache = sha1($_POST['pass']);
			$req = $bdd->prepare('INSERT INTO users(pseudo, pass, mail, signedup) VALUES(:pseudo, :pass, :mail, NOW())');
			$req->execute(array('pseudo' => $_POST['pseudo'], 'pass' => $pass_hache, 'mail' => $_POST['mail']));
							
			echo '<p class="alert_ok">Votre compte a bien été créé.<br />
						Vous pouvez maintenant vous connecter en <a href="index.php?page=login">cliquant ici</a>.</p>';
		}
	}
	else // premiere visite de la page
	{
		ft_print_signup_form();
	}
?>

