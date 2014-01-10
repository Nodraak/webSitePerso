<?php
	include_once('modele/init.php');
	include_once('modele/forum.php');
	include_once('modele/membre.php');

	$bdd = ft_connect_bdd();

				if (!isset($_SESSION['pseudo'])) // not logged yet
				{
					echo '<h2>Bienvenue cher visiteur inconnu !</h2>
								<p>Vous n\'avez pas accès a cette page, merci de vous connecter.</p>';
				}
				else // logged, can access threads
				{
					echo '<p><a href="index.php?page=new_thread">Créer un nouveau sujet</a></p>';

					$req_thread = $bdd->query('SELECT id FROM threads ORDER BY activity DESC');

					while ($data_thread = $req_thread->fetch())
					{
						$forum = new Forum($data_thread['id']);
						$author = new Membre($forum->get_owner());

						echo '<div class="thread"><table>
										<tr>
											<td class="title"><a href="index.php?page=message&id='.$forum->get_id().'">'.$forum->get_title().'</a></td>
											<td class="time time_activity">Dernier message le ' . date('d/m/Y à H\hi', $forum->get_activity()) . '</td>
										</tr><tr>
											<td class="auteur"><a href="index.php?page=user&id='.$forum->get_owner().'">'.$author->get_pseudo().'</a></td>
											<td class="time time_created">Créé le ' . date('d/m/Y à H\hi', $forum->get_created()) . '</td>
										</tr>
									</table></div>';
					}

				}
			?>

