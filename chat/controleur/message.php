<?php
	include_once('modele/init.php');
	include_once('modele/forum.php');
	include_once('modele/message.php');
	include_once('modele/membre.php');

	if (isset($_GET['error']) && $_GET['error'] != 0)
	{
		echo '<p class="alert_ko">Erreur, le message n\'a pas été posté, le formulaire était incomplet. (Error info : '.$_GET['error'].')</p>';
	}
	else
	{
				if (isset($_GET['error']) && $_GET['error'] == 0)
				{
					echo '<p class="alert_ok">Votre message a bien été posté (ou édité).</p>';
				}

				if (!isset($_GET['id']))
				{
					echo'<h2>Bienvenue cher visiteur !</h2>'
							.'<p class="alert_ko">Erreur, la page demandée n\'a pas  été trouvée.</p>';
				}
				else
				{
					$bdd = ft_connect_bdd();
					$forum = new Forum($_GET['id']);
					$ret = $bdd->prepare('SELECT id FROM messages WHERE thread = :thread');
					$ret->execute(array('thread' => $_GET['id']));

					echo '<h2>'.$forum->get_title().'</h2>';

					while ($data = $ret->fetch())
					{
						$message = new Message($data['id']);
						$author = new Membre($message->get_author());
						
						echo '
						<table>
							<tr class="topBar">
								<td class="author"><a href="index.php?page=user&id='.$message->get_author().'">'.$author->get_pseudo().'</a></td>
								<td class="timeEdit">
									<div class="time">Posté (ou édité) le '.date('d/m/Y à H\hi', $message->get_posted()).'</div>'
									.$author->get_edit($message).'</td>
							</tr>
							<tr class="content">
								<td class="avatar"><img src="'.$author->get_avatar(80).'" alt="pseudo gravatar" /></td>
								<td class="textSignBorder">
									<div class="textSign">
										<div class="text">'.$message->get_text().'</div>
										'.$author->get_sign().'
									</div>
								</td>
							</tr>
						</table>';
					}

					$ret->closeCursor();

					echo '<div class="post_message"><p>
									<form method=post action=index.php?page=post>
										<label for=message>Votre mesage :</label>
									<br />
										<textarea name=message id=message rows=10 cols=75 required></textarea>

										<input type=hidden name=thread_id value='.$_GET['id'].' />
									<br />
										<input type=submit value=Poster />
									</form>
								</div></p>';

				}
	}
?>

