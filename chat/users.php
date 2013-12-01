<?php
include('options.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Page perso d'Adrien !</title>
		<link rel="stylesheet" href="styles.css" />
		<?php include('head.php'); ?>
	</head>

	<body>
		<?php include('header.php'); ?>

		<div id=block_page>
			<?php

				if (!isset($_SESSION['pseudo'])) // not logged yet
				{
					echo '<h1>Les membres</h1>';
					echo '<h2>Bienvenu cher visiteur inconnu !</h2>
								<p>Vous n\'avez pas accès a cette page, merci de vous connecter.</p>';
				}
				else // logged, can access threads
				{
					// Connexion à la bdd
					try
					{
						 $bdd = new PDO('mysql:host=localhost;dbname=test', 'adur', 'mdpms');
					}
					catch(Exception $e)
					{
						die('Erreur : '.$e->getMessage());
					}

					$req = $bdd->prepare('SELECT pseudo, mail, signedup FROM users WHERE BINARY id = :id');
					$req->execute(array('id' => $_GET['id']));
					$ret = $req->fetch();

					$grav_url = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($_GET['id']))).'?d=identicon&s=75';

					if (!$ret['pseudo'])
					{
				echo '<h2 class="center">Membres : ... allo ?</h1>';
						echo '<p class="important">Erreur, le membre est introuvable. Il s\'est peut-être perdu ?</p>';
					}
					else
					{
						echo '<h2 class="center">Membre : '.$ret['pseudo'].'</h2>';
						
						echo '<div class="user"><table>
										<tr>
											<td class="avatar">
												<img src='.$grav_url.'alt=pseudo_gravatar />
											</td>
									
											<td class="texte">
												<p>Pseudo : '.$ret['pseudo'].'</p>
												<p>Email : '.$ret['mail'].'</p>
												<p>Date d\'inscription : '.$ret['signedup'].'</p>
											</td>
										</tr>
									</table></div>';
					}

					$req->closeCursor();
				}
			?>


		</div>

		<?php include('footer.php'); ?>
	</body>
</html>
