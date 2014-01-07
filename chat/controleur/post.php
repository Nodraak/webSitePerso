<?php
include('../options.php');
?>

<?php

	if (isset($_SESSION['pseudo']) AND isset($_POST['message']) AND isset($_POST['thread_id']))
	{
		$bdd = ft_connect_bdd();

		// post msg
		if (!isset($_POST['msg_id']))
		{
			$req = $bdd->prepare('INSERT INTO messages (posted, thread, author, text) VALUES(NOW(), ?, ?, ?)');
			$req->execute(array($_POST['thread_id'], $_SESSION['id'], $_POST['message']));
		}
		// edit
		else
		{
			// check owner
			$req = $bdd->prepare('SELECT author FROM messages WHERE id = :id');
			$req->execute(array('id' => $_POST['msg_id']));
			$ret = $req->fetch();

			if ($ret['author'] == $_SESSION['id'])
			{
				$req_edit = $bdd->prepare('UPDATE messages SET text = ?, posted = NOW() WHERE id = ?');
				$req_edit->execute(array($_POST['message'], $_POST['msg_id']));
			}
			else
			{
				exit();
			}
		}

		// update thread last activity
		$req_msg_id = $bdd->prepare('UPDATE threads SET activity = NOW() WHERE id = ?');
		$req_msg_id->execute(array($_POST['thread_id']));

		header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=0');
		exit();
	}
	else
	{
		if (!isset($_SESSION['pseudo']))
			header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=pseudo');
		if (!isset($_SESSION['message']))
			header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=message');
		if (!isset($_SESSION['thread']))
			header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=thread_id');
		exit();
	}

?>

