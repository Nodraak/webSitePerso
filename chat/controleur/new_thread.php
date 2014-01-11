<?php
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
		$req = $bdd->prepare('INSERT INTO threads (created, owner, title) VALUES(NOW(), ?, ?)');
		$req->execute(array($_SESSION['id'], $_POST['title']));
		$thread_id = $bdd->lastInsertId();

		// post msg
		$message = new Message();
		$message->post_message($thread_id, $_POST['text']);

		header('Location: index.php?page=message&id='.$thread_id.'&error=0');
	}

?>