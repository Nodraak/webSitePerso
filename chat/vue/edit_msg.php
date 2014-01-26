<?php

	if ($message->get_author() == $_SESSION['id'])
	{
		// post form
		echo '<div class="post_message"><p>
				<form method=post action=index.php?page=post>
					<label for=message>Votre mesage :</label>
				<br />
					<textarea name=message id=message rows=20 cols=75 required>'.$message->get_text_raw().'</textarea>

					<input type=hidden name=thread_id value='.$message->get_thread().' />
					<input type=hidden name=msg_id value='.$_GET['id'].' />
				<br />
					<input type=submit value=Poster />
				</form>
			</div></p>';
	}
	else
	{
		echo '<p class="alert_ko">Erreur, vous n\'êtes pas autorisé à accéder à cette page.</p>';
	}
	
?>
