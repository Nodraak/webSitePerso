
<?php
	include_once('modele/init.php');
	include_once('modele/signup.php');

	$bdd = ft_connect_bdd();

	if (empty($_POST['pseudo']) && empty($_POST['mail']) && empty($_POST['pass']) && empty($_POST['passre']))
	{
		if (isset($_GET['id']))
		{
			$req = $bdd->prepare('SELECT pseudo, mail FROM users WHERE id = :id');
			$req->execute(array('id' => $_GET['id']));

			//$grav_url = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($_GET['id']))).'?d=identicon&s=75';
			$req_data = $req->fetch();
		}

		echo '<h2>Editer mon profil</h2>';
	
		if (empty($req_data))
		{
			echo '<p class="alert_ko">Ereur, le membre n\'a pas été trouvé.</p>';
		}
		else if ($_GET['id'] != $_SESSION['id'])
		{
			echo '<p class="alert_ko">Ereur, vous n\'avez pas les droits requis pour accéder à cette page.</p>';
		}
		else
		{
					echo '<p>
									<form method="post" action="index.php?page=edit_user&id='.$_GET['id'].'">
											<label for="pseudo"><span class="title">Pseudo :</span></label><br />
											<input type="text" name="pseudo" id="pseudo" value="'.$req_data['pseudo'].'"><br />
											<input type="submit" value="Mettre à jour les informations" />
									</form>
								</p>
								<p>
									<form method="post" action="index.php?page=edit_user&id='.$_GET['id'].'">
											<label for="mail"><span class="title">Adresse email :</span></label><br />
											<input type="email" name="mail" id="mail" size="40" value="'.$req_data['mail'].'"/><br />
											<input type="submit" value="Mettre à jour les informations" />
									</form>
								</p>
								<p>
									<form method="post" action="index.php?page=edit_user&id='.$_GET['id'].'">
											<label for="pass"><span class="title">Mot de passe :</span></label><br />
											<input type="password" name="pass" id="pass" /><br />
											<label for="passre">Vérification :</label><br />
											<input type="password" name="passre" id="passre" /><br />
											<input type="submit" value="Mettre à jour les informations" />
									</form>		
								</p>';


		}
	}
	else
	{	
		if (!empty($_POST['pseudo']))
		{
			$req_pseudo = $bdd->prepare('UPDATE users SET pseudo = ? WHERE id = ?');
			$req_pseudo->execute(array($_POST['pseudo'], $_SESSION['id']));
			echo '<p class="alert_ok">Votre pseudo a bien été mis à jour.</p>';
		}
		else
			echo '<p>Votre pseudo n\'a pas été modifié.</p>';

		if (!empty($_POST['mail']))
		{
			$req_mail = $bdd->prepare('UPDATE users SET mail = ? WHERE id = ?');
			$req_mail->execute(array($_POST['mail'], $_SESSION['id']));
			echo '<p class="alert_ok">Votre adresse email a bien été mise à jour.</p>';
		}
		else
			echo '<p>Votre adresse email n\'a pas été modifiée.</p>';

		if (!empty($_POST['pass']) && !empty($_POST['passre']) && $_POST['pass'] == $_POST['passre'])
		{
			$pass_hache = sha1($_POST['pass']);
			$req_pass = $bdd->prepare('UPDATE users SET pass = ? WHERE id = ?');
			$req_pass->execute(array($pass_hache, $_SESSION['id']));
			echo '<p class="alert_ok">Votre mot de passe a bien été mis à jour.</p>';
		}
		else
			echo '<p>Votre mot de passe n\'a pas été modifié.</p>';
	}

?>

