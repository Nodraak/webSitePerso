<?php

/******************************************************************************* 
*
*   File : new_thread.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 19:34:21
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-12 14:01:08
*
*******************************************************************************/

	include_once('modele/init.php');
	include_once('modele/message.php');

	// show post form
	if (!isset($_POST['title']) || !isset($_POST['text']))
	{
		include_once('vue/new_thread.php');
	}
	// post data
	else
	{
		$bdd = ft_connect_bdd();

		// create thread
		$req = $bdd->prepare('INSERT INTO threads (created, owner, title, nbMessage) VALUES(NOW(), ?, ?, 1)');
		$req->execute(array($_SESSION['id'], $_POST['title']));
		$thread_id = $bdd->lastInsertId();

		// post msg
		$message = new Message();
		$message->post_message($thread_id, $_POST['text']);

		header('Location: index.php?page=message&id='.$thread_id.'&error=0&offset=1');
	}

?>