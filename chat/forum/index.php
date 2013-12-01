<?php include('../options.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Page perso d'Adrien !</title>
		<link rel="stylesheet" href="../styles.css" />
		<?php include('../head.php'); ?>
	</head>

	<body>
		<?php include('header.php'); ?>

		<div id=block_page>
			<h2 class="center">Forums</h2>
			<div class="new_subject">
				<a href="create_thread.php">Créer un nouveau sujet</a>
			</div>

			<?php
				if (!isset($_SESSION['pseudo'])) // not logged yet
				{
					echo '<h2>Bienvenue cher visiteur inconnu !</h2>
								<p>Vous n\'avez pas accès a cette page, merci de vous connecter.</p>';
				}
				else // logged, can access threads
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

					$req_thread = $bdd->query('SELECT title, owner, created, activity, id FROM threads ORDER BY activity DESC LIMIT 0, 10');

					while ($data_thread = $req_thread->fetch())
					{
						$title = htmlspecialchars($data_thread['title']);
						$created = strtotime($data_thread['created']);
						$activity = strtotime($data_thread['activity']);
						
						$req_author = $bdd->prepare('SELECT pseudo FROM users WHERE id = :id');
						$req_author->execute(array('id' => $data_thread['owner']));
						$req_author_data = $req_author->fetch();
						$author = $req_author_data['pseudo'];

						echo '<div class="thread"><table>
										<tr>
											<td class="title"><a href="../forum/thread.php?page='.$data_thread['id'].'">'.$title.'</a></td>
											<td class="time time_activity">Dernier message le ' . date('d/m/Y à H\hi', $activity) . '</td>
										</tr><tr>
											<td class="auteur"><a href="../users.php?id='.$data_thread['owner'].'">'.$author.'</a></td>
											<td class="time time_created">Créé le ' . date('d/m/Y à H\hi', $created) . '</td>
										</tr>
									</table></div>';

						$req_author->closeCursor();
					}

					$req_thread->closeCursor();

				}
			?>


		</div>

		<?php include('../footer.php'); ?>
	</body>
</html>
