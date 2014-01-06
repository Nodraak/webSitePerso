<?php
	include_once('modele/init.php');


				if (!isset($_SESSION['pseudo'])) // not logged yet
				{
					echo '<h2>Bienvenue cher visiteur inconnu !</h2>
								<p>Vous n\'avez pas accès a cette page, merci de vous connecter.</p>';
				}
				else // logged, can access threads
				{
					echo '<p><a href="index.php?page=new_thread">Créer un nouveau sujet</a></p>';

					$bdd = ft_connect_bdd();
					$req_thread = $bdd->query('SELECT title, owner, created, activity, id FROM threads ORDER BY activity DESC');

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
											<td class="title"><a href="index.php?page=message&id='.$data_thread['id'].'">'.$title.'</a></td>
											<td class="time time_activity">Dernier message le ' . date('d/m/Y à H\hi', $activity) . '</td>
										</tr><tr>
											<td class="auteur"><a href="index.php?page=user&id='.$data_thread['owner'].'">'.$author.'</a></td>
											<td class="time time_created">Créé le ' . date('d/m/Y à H\hi', $created) . '</td>
										</tr>
									</table></div>';

						$req_author->closeCursor();
					}

					$req_thread->closeCursor();

				}
			?>

