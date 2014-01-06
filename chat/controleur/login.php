<?php
	include_once('modele/init.php');
	include_once('modele/login.php');

	echo '<h2>Connexion</h2>';

	// mdp envoyé
	if (isset($_POST['pseudo']) AND isset($_POST['pass']))
	{
		$bdd = ft_connect_bdd();
		$pass_hashe = sha1($_POST['pass']);
		$req = $bdd->prepare('SELECT id FROM users WHERE pseudo = :pseudo AND pass = :pass');
		$req->execute(array('pseudo' => $_POST['pseudo'], 'pass' => $pass_hashe));
	
		$resultat = $req->fetch();
		if (!$resultat) // mdp incorrect
		{
			echo '<p class="alert_ko">Erreur, pseudo et/ou mot de passe incorrect(s), merci de réesayer.</p>';
			ft_print_login_form();
		}
		else // mdp correct
		{
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['pseudo'] = $_POST['pseudo'];
			header('Location: index.php');
		}
	}
	else // premiere visite de la page
	{
		ft_print_login_form();
	}

?>

