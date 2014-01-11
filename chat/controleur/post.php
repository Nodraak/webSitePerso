<?php
	include_once('modele/init.php');
	include_once('modele/message.php');

	if (isset($_SESSION['pseudo']) && isset($_POST['message']) & isset($_POST['thread_id']))
	{
		// post msg
		if (!isset($_POST['msg_id']))
		{	
			$message = new Message();
			$message->post_message($_POST['thread_id'], $_POST['message']);
		}
		// edit
		else
		{
			$message = new Message($_POST['msg_id']);

			// check owner
			if ($message->get_author() == $_SESSION['id'])
			{	
				$message->edit_message($_POST['message']);
			}
			else
			{
				echo '<p class="alert_ko">Erreur in '.__FILE__.' l.'.__LINE.'.</p>';
				exit();
			}
		}

		header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=0');
	}
	else
	{
		if (!isset($_SESSION['pseudo']))
			header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=pseudo');
		if (!isset($_SESSION['message']))
			header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=message');
		if (!isset($_SESSION['thread']))
			header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=thread_id');
	}

?>