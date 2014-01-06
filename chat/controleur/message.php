<?php
	include_once('modele/init.php');
	include_once('modele/message.php');

	if (isset($_GET['error']) && $_GET['error'] != 0)
	{
		echo '<p class="alert_ko">Erreur, le message n\'a pas été posté, le formulaire était incomplet. (Error info : '.$_GET['error'].')</p>';
	}
	else
	{
				if (isset($_GET['error']) && $_GET['error'] == 0)
				{
					echo '<p class="alert_ok">Votre message a bien été posté.</p>';
				}

				if (!isset($_GET['id']))
				{
					echo'<h2>Bienvenue cher visiteur !</h2>'
							.'<p class="alert_ko">Erreur, la page demandée n\'a pas  été trouvée.</p>';
				}
				else
				{
					$bdd = ft_connect_bdd();

					$req_title = $bdd->prepare('SELECT title FROM threads WHERE id = ?');
					$req_title->execute(array($_GET['id']));
					$title = $req_title->fetch();
					echo '<h2>'.$title['title'].'</h2>';

					$ret = $bdd->prepare('SELECT author, posted, text FROM messages WHERE thread = :thread');
					$ret->execute(array('thread' => $_GET['id']));

					while ($data = $ret->fetch())
					{
						$text = ft_parse_text($data['text']);
						$author_id = $data['author'];
						$posted = strtotime($data['posted']);
						$grav_url = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($author_id))).'?d=identicon&s=80';

						$req_author = $bdd->prepare('SELECT pseudo, sign FROM users WHERE id = :id');
						$req_author->execute(array('id' => $author_id));
						$req_author_data = $req_author->fetch();
						$author = $req_author_data['pseudo'];


						if(empty($req_author_data['sign']))
							$sign = '';
						else
							$sign = '<div class="paddingTextSign"></div><div class="sign">'.ft_parse_text($req_author_data['sign']).'</div>';

						echo '
						<table>
							<tr class="topBar">
								<td class="author"><a href="index.php?page=user&id='.$author_id.'">'.$author.'</a></td>
								<td class="time">Posté le '.date('d/m/Y à H\hi', $posted).'</td>
							</tr>
							<tr class="content">
								<td class="avatar"><img src='.$grav_url.'alt=pseudo gravatar /></td>
								<td class="textSignBorder">
									<div class="textSign">
										<div class="text">'.$text.'</div>
										'.$sign.'
									</div>
								</td>
							</tr>
						</table>';

						$req_author->closeCursor();
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

