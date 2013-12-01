<?php include("options.php"); ?>

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
			<h1>Chat - S'inscrire</h1>
				<?php
					function ft_print_form()
					{
						echo '<p><form method="post" action="signup.php">
									<table>
										<tr>
											<td><label for="pseudo">Pseudo : </label></td>
											<td><input type="text" name="pseudo" id="pseudo" maxlength="10" required /></td>
										</tr><tr>
											<td><label for="pass">Mot de passe :</label></td>
											<td><input type="password" name="pass" id="pass" required /></td>
										</tr><tr>
											<td><label for="passre">Vérification du mot de passe :</label></td>
											<td><input type="password" name="passre" id="passre" required /></td>
										</tr><tr>
											<td><label for="mail">Adresse email :</label></td>
											<td><input type="email" name="mail" id="mail" size="30" required /></td>
										</tr><tr>
											<td colspan="2" class="center"><input type="submit" value="S\'inscrire" /></td>
										</tr>
									</table>
									</form></p>';
					}

					// form envoyé mais faux
					if (isset($_POST['pseudo']) AND isset($_POST['pass']) AND isset($_POST['passre']) AND isset($_POST['mail']))
					{
						try
						{
							$bdd = new PDO('mysql:host=localhost;dbname=test', 'adur', 'mdpms');
						}
						catch (Exception $e)
						{
							die('Erreur : '.$e->getMessage());
						}

						$req_check_pseudo = $bdd->prepare('SELECT id FROM users WHERE BINARY pseudo = :pseudo');
						$req_check_pseudo->execute(array('pseudo' => $_POST['pseudo']));
						$data_check_pseudo = $req_check_pseudo->fetch();

						if ($_POST['pass'] == $_POST['passre'] AND !$data_check_pseudo) // check mail unique
						{
							$pass_hache = sha1($_POST['pass']);
							$req = $bdd->prepare('INSERT INTO users(pseudo, pass, mail, signedup)
																								VALUES(:pseudo, :pass, :mail, NOW())');
							$req->execute(array('pseudo' => $_POST['pseudo'], 'pass' => $pass_hache, 'mail' => $_POST['mail']));
							
							echo '<p>Votre compte a bien été créé.<br />
										Vous pouvez maintenant vous connecter en <a href="login.php">cliquant ici</a>.</p>';
						}
						else // form incorrect
						{
							echo '<p class="important">Erreur dans le formulaire, merci de réesayer.</p>';
							ft_print_form();
						}
					}
					else // premiere visite de la page
					{
						ft_print_form();
					}
				?>

		</div>

		<?php include('footer.php'); ?>
	</body>
</html>
