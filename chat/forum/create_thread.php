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
			<h2 class="center">Créer un nouveau sujet</h2>

			<?php
				if (!isset($_SESSION['pseudo'])) // not logged yet
				{
					echo '<h2>Bienvenue cher visiteur inconnu !</h2>
								<p>Vous n\'avez pas accès a cette page, merci de vous connecter.</p>';
				}
				else // logged, can create threads
				{
					if (! (isset($_POST['title']) AND isset($_POST['message']))) // erreur form.
					{
						echo
				'<div class="create_thread"><p>
						<form method=post action=create_thread.php>
							<label for=title>Choississez un titre :</label>
							<input type="text" name="title" id="title" size="30" maxlength=""required />
						<br /><br />
							<label for=message>Votre mesage :</label>
						<br /><br />
							<div class="center">
							<textarea name=message id=message rows=10 cols=75 required></textarea>
							</div>
						<br />
							<div class="center">
							<input type=submit value=Poster />
							</div>
						</form>
					</div></p>';
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

						// save mysql date
						$ret_time = $bdd->query("SELECT NOW() as 'now'");
						$row_time = $ret_time->fetch();
						$now = $row_time['now'];

						// create thread
						$req_ct = $bdd->prepare("INSERT INTO threads (created, owner, title, activity) VALUES (?, ?, ?, ?)");
						$req_ct->execute(array($now, $_SESSION['id'], $_POST['title'], $now));

						// get thread id
						$req_gtid = $bdd->prepare("SELECT id FROM threads WHERE BINARY created = :now");
						$req_gtid->execute(array('now' => $now));
						$ret_tid = $req_gtid->fetch();

						// post
						$req = $bdd->prepare('INSERT INTO messages (posted, thread, author, text) VALUES(NOW(), ?, ?, ?)');
						$req->execute(array($ret_tid['id'], $_SESSION['id'], $_POST['message']));
												
						// redirection thread
						header('Location: thread.php?page='.$ret_tid['id']);
						exit();
					}
				}
			?>


		</div>

		<?php include('../footer.php'); ?>
	</body>
</html>
