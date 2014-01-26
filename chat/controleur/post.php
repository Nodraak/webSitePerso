<?php
	include_once('modele/init.php');
	include_once('modele/message.php');

	if (isset($_SESSION['pseudo']) && isset($_POST['message']) & isset($_POST['thread_id']))
	{
		// post msg
		if (!isset($_POST['msg_id']))
		{	
			$message = new Message();
			$ret = $message->post_message($_POST['thread_id'], $_POST['message']);
			header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error='.$ret.'&offset=last');
			exit();
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
				echo '<p class="alert_ko">Erreur in '.__FILE__.' l.'.__LINE__.'.</p>';
				exit();
			}
		}

		header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=0&offset=last');
	}
	else
	{
		if (!isset($_SESSION['pseudo']))
			header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=pseudo&offset=last');
		if (!isset($_SESSION['message']))
			header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=message&offset=last');
		if (!isset($_SESSION['thread']))
			header('Location: index.php?page=message&id='.$_POST['thread_id'].'&error=thread_id&offset=last');
	}

?>
