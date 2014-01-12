<?php

/******************************************************************************* 
*
*   File : 
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 13:45:05
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-12 12:19:11
*
*******************************************************************************/

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
			if (isset($_GET['offset']))
				$startId = ($_GET['offset']-1)*15;
			else
				$startId = 0;
			$endId = $startId + 15;


			$forum = new Forum($_GET['id']);
			
			$bdd = ft_connect_bdd();
			$ret = $bdd->prepare('SELECT id FROM messages WHERE thread = ? ORDER BY id ASC LIMIT '.$startId.', '.$endId);
			$ret->execute(array($_GET['id']));

			include_once('vue/message.php');

		}
	}
?>