
<?php

	// check owner
	$bdd = ft_connect_bdd();
	$req = $bdd->prepare('SELECT author, text, thread FROM messages WHERE id = :id');
	$req->execute(array('id' => $_GET['id']));
	$ret = $req->fetch();

	if ($ret['author'] == $_SESSION['id'])
	{
		// post form
		echo '<div class="post_message"><p>
						<form method=post action=index.php?page=post>
							<label for=message>Votre mesage :</label>
						<br />
							<textarea name=message id=message rows=10 cols=75 required>'.$ret['text'].'</textarea>

							<input type=hidden name=thread_id value='.$ret['thread'].' />
							<input type=hidden name=msg_id value='.$_GET['id'].' />
						<br />
							<input type=submit value=Poster />
						</form>
					</div></p>';


	}
	else
		echo 'raté, hacker';

?>

