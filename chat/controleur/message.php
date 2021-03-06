<?php

/******************************************************************************* 
*
*   File : 
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 13:45:05
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-12 14:22:23
*
*******************************************************************************/

	include_once('modele/init.php');
	include_once('modele/forum.php');
	include_once('modele/message.php');
	include_once('modele/membre.php');

	if (isset($_GET['error']) && strcmp($_GET['error'], '0') != 0)
	{
		echo '<p class="alert_ko">Erreur, le message n\'a pas été posté, le formulaire comportait une erreur. (Erreur : '.$_GET['error'].')</p>';
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

			$nbPages = (int)(($forum->get_nbMessage()-1) / NB_MESSAGES_PER_PAGE) + 1;
			if (strcmp($_GET['offset'], 'last') == 0)
				$_GET['offset'] = $nbPages;

			if (isset($_GET['offset']))
				$startId = ($_GET['offset']-1) * NB_MESSAGES_PER_PAGE;
			else
				$startId = 0;
			
			$bdd = ft_connect_bdd();
			$ret = $bdd->prepare('SELECT id FROM messages WHERE thread = ? ORDER BY id ASC LIMIT '.$startId.', '.NB_MESSAGES_PER_PAGE);
			$ret->execute(array($_GET['id']));

			include_once('vue/message.php');

		}
	}
?>
