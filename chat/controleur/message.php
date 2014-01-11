<?php
	include_once('modele/init.php');
	include_once('modele/forum.php');
	include_once('modele/message.php');
	include_once('modele/membre.php');

	if (isset($_GET['error']) && $_GET['error'] != 0)
	{
		echo '<p class="alert_ko">Erreur, le message n\'a pas été posté, le formulaire était incomplet. (Code d\'erreur : '.$_GET['error'].')</p>';
	}
	else
	{
		if (isset($_GET['error']) && $_GET['error'] == 0)
		{
			echo '<p class="alert_ok">Votre message a bien été posté (ou édité).</p>';
		}

		if (!isset($_GET['id']))
		{
			echo'<p class="alert_ko">Erreur, la page demandée n\'a pas  été trouvée.</p>';
		}
		else
		{
			$forum = new Forum($_GET['id']);
			
			$bdd = ft_connect_bdd();
			$ret = $bdd->prepare('SELECT id FROM messages WHERE thread = ?');
			$ret->execute(array($_GET['id']));

			include_once('vue/message.php');

		}
	}
?>