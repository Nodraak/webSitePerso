<?php

/******************************************************************************* 
*
*   File : login.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 12:01:59
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-13 16:48:01
*
*******************************************************************************/

	include_once('modele/init.php');

	echo '<h2>Connexion</h2>';

	// mdp envoyé
	if (isset($_POST['pseudo']) && isset($_POST['pass']))
	{
		$bdd = ft_connect_bdd();
		$pass_hashe = sha1($_POST['pass']);
		$req = $bdd->prepare('SELECT id FROM users WHERE pseudo = ? AND pass = ?');
		$req->execute(array($_POST['pseudo'], $pass_hashe));
		$resultat = $req->fetch();

		if (!$resultat) // mdp incorrect
		{
			echo '<p class="alert_ko">Erreur, pseudo et/ou mot de passe incorrect(s), merci de réesayer.</p>';
			include_once('vue/login.php');
		}
		else // mdp correct
		{
			$_SESSION['id'] = $resultat['id'];
			$_SESSION['pseudo'] = $_POST['pseudo'];

			$req = $bdd->prepare('UPDATE users SET lastCo = NOW() WHERE id = ?');
			$req->execute(array($_SESSION['id']));

			header('Location: index.php');
		}
	}
	else // premiere visite de la page
	{
		include_once('vue/login.php');
	}

?>

