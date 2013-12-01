<?php include('options.php'); ?>

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
			<h1>Se connecter</h1>

			<h2>Connexion</h2>
				<?php
					function ft_print_form()
					{
						echo '<p><form method="post" action="login.php">
									<table>
										<tr>
											<td><label for="pseudo">Pseudo : </label></td>
											<td><input type="text" name="pseudo" id="pseudo" size="10" maxlength="10" required';
						if (isset($_POST['pseudo']))
							echo ' value="'.$_POST['pseudo'].'"';					
						echo ' /></td>
										</tr><tr>
											<td><label for="pass">Mot de passe :</label></td>
											<td><input type="password" name="pass" id="pass" required /></td>
										</tr><tr>
											<td colspan="2" class="center"><input type="submit" value="Se connecter" /></td>
										</tr>
									</table>
									</form></p>';
					}

					function ft_print_signup()
					{
						echo '<h2>Nouveau ?</h2>
									<p>Inscrivez vous en <a href="signup.php">cliquant ici</a>.</p>';
					}

					// mdp envoyé
					if (isset($_POST['pseudo']) AND isset($_POST['pass']))
					{
						try
						{
							$bdd = new PDO('mysql:host=localhost;dbname=test', 'adur', 'mdpms');
						}
						catch (Exception $e)
						{
							die('Erreur : '.$e->getMessage());
						}
						$req = $bdd->prepare('SELECT id FROM users WHERE BINARY pseudo = :pseudo AND BINARY pass = :pass');
						$pass_hashe = sha1($_POST['pass']);
						$req->execute(array('pseudo' => $_POST['pseudo'], 'pass' => $pass_hashe));
	
						$resultat = $req->fetch();
						if (!$resultat) // mdp incorrect
						{
							echo '<p class="important">Erreur, pseudo et/ou mot de passe incorrect(s), merci de réesayer. La base de données tient compte de la casse.</p>';
							ft_print_form();
							ft_print_signup();
						}
						else // mdp correct
						{
							session_start();
							$_SESSION['id'] = $resultat['id'];
							$_SESSION['pseudo'] = $_POST['pseudo'];
							header('Location: index.php');
						}
					}
					else // premiere visite de la page
					{
						ft_print_form();
						ft_print_signup();
					}
				?>

		</div>

		<?php include('footer.php'); ?>
	</body>
</html>
