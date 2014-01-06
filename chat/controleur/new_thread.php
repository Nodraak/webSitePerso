<?php
	include_once('modele/init.php');

	if (!isset($_POST['title']) || !isset($_POST['text']))
	{
		echo '<p><form method="post" action="index.php?page=new_thread">
						<table>
							<tr>
								<td><label for="title">Titre du sujet :</label></td>
							</tr><tr>
								<td><input type="text" name="title" id="title" size="99" required /></td>
							</tr><tr>
								<td><label for="text">Votre message :</label></td>
							</tr><tr>
								<td><textarea name="text" id="text" rows=10 cols=75 required></textarea></td>
							</tr><tr>
								<td class="center"><input type="submit" value="Créer le sujet" /></td>
							</tr>
						</table>
					</form><p>';
	}
	else
	{
		$bdd = ft_connect_bdd();

		// create thread
		$req = $bdd->prepare('INSERT INTO threads (created, owner, title, activity) VALUES(NOW(), ?, ?, NOW())');
		$req->execute(array($_SESSION['id'], $_POST['title']));
		$thread_id = $bdd->lastInsertId();

		// post message
		$req = $bdd->prepare('INSERT INTO messages (posted, thread, author, text) VALUES(NOW(), ?, ?, ?)');
		$req->execute(array($thread_id, $_SESSION['id'], $_POST['text']));
		
		// update thread last activity
		$req_msg_id = $bdd->prepare('UPDATE threads SET activity = NOW() WHERE id = ?');
		$req_msg_id->execute(array($thread_id));

		header('Location: index.php?page=message&id='.$thread_id.'&error=0');
		exit();

	}

?>
