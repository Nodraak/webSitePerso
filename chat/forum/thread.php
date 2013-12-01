<?php
include('../options.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Page perso d'Adrien ! - Chat</title>
		<link rel="stylesheet" href="../styles.css" />
		<?php include('../head.php'); ?>
	</head>

	<body>
		<?php include('header.php'); ?>

		<div id=block_page>

			<?php
//mysqli_real_escape_string

				if (!isset($_SESSION['pseudo'])) // not logged yet
				{
					echo '<h1>Chat - Erreur</h1>'
							.'<h2>Bienvenue cher visiteur inconnu !</h2>'
							.'<p>Vous n\'avez pas accès a cette page,'
							.' merci de vous connecter.</p>';
				}
				else if (!isset($_GET['page']))
				{
					echo '<h1>Chat - Accueil</h1>'
							.'<h2>Bienvenue cher visiteur !</h2>'
							.'<p>Une erreur est survenue : la page demandée n\'a pas'
							.' été trouvée.</p>';
				}
				else
				{
					// Connexion à la bdd
					try
					{
						 $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'adur', 'mdpms');
					}
					catch(Exception $e)
					{
						die('Erreur : '.$e->getMessage());
					}

					$ret = $bdd->prepare('SELECT author, posted, text FROM messages
						WHERE BINARY thread = :thread');
					$ret->execute(array('thread' => $_GET['page']));

					$get_title = $bdd->prepare('SELECT title FROM threads WHERE BINARY id = :id');
					$get_title->execute(array('id' => $_GET['page']));
					$ret_title = $get_title->fetch();

					echo '<h2 class="center">Sujet : '.$ret_title['title'].'</h2>';

					while ($data = $ret->fetch())
					{
						$text = nl2br(htmlspecialchars($data['text']));
						$author_id = $data['author'];
						$posted = strtotime($data['posted']);
						$grav_url = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($author_id))).'?d=identicon&s=75';

						$req_author = $bdd->prepare('SELECT pseudo FROM users WHERE BINARY id = :id');
						$req_author->execute(array('id' => $author_id));
						$req_author_data = $req_author->fetch();
						$author = $req_author_data['pseudo'];

						echo '<div class="message"><table><tr>
										<td class="auteur"><a href="../users.php?id='.$author_id.'">'.$author.'</a></td>
										<td class="time">Posté le '.date('d/m/Y à H\hi', $posted).'</td>
									</tr><tr>
										<td class="avatar"><img src='.$grav_url.'alt=pseudo_gravatar /></td>
										<td class="texte">' . $text . '</td>
									</tr></table></div>';

						$req_author->closeCursor();
					}

					$ret->closeCursor();


					if (isset($_GET['error']) AND $_GET['error'] == 1)
					{
						echo '<p style=color:red>Erreur dans le formulaire.</p>';
					}

					echo '<div class="post_message"><p>
									<form method=post action=post.php>
										<label for=message>Votre mesage :</label>
									<br />
										<textarea name=message id=message rows=10 cols=75 required></textarea>

										<input type=hidden name=thread value='.$_GET['page'].' />
									<br />
										<input type=submit value=Poster />
									</form>
								</div></p>';

				}
			?>

		</div>

		<?php include('../footer.php'); ?>
	</body>
</html>
