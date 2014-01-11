<?php
	include_once('modele/init.php');
	include_once('modele/signup.php');
	include_once('modele/membre.php');

	// no post data
	if (empty($_POST['pseudo']) && empty($_POST['mail']) && empty($_POST['pass']) && empty($_POST['passre']))
	{
		if (isset($_GET['id']))
		{
			$membre = new Membre($_GET['id']);
		}

		echo '<h2>Editer mon profil</h2>';
		
		if (!$membre->isValid)
		{
			echo '<p class="alert_ko">Ereur, le membre n\'a pas été trouvé.</p>';
		}
		else if ($membre->get_id() != $_SESSION['id'])
		{
			echo '<p class="alert_ko">Ereur, vous n\'avez pas les droits requis pour accéder à cette page.</p>';
		}
		else
		{
			echo '<p>
					<form method="post" action="index.php?page=edit_user&id='.$membre->get_id().'">
						<label for="pseudo"><span class="title">Pseudo :</span></label><br />
						<input type="text" name="pseudo" id="pseudo" value="'.$membre->get_pseudo().'"><br />
						<input type="submit" value="Mettre à jour les informations" />
					</form>
				</p>
				<p>
					<form method="post" action="index.php?page=edit_user&id='.$membre->get_id().'">
						<label for="mail"><span class="title">Adresse email :</span></label><br />
						<input type="email" name="mail" id="mail" size="40" value="'.$membre->get_mail().'"/><br />
						<input type="submit" value="Mettre à jour les informations" />
					</form>
				</p>
				<p>
					<form method="post" action="index.php?page=edit_user&id='.$membre->get_id().'">
						<label for="pass"><span class="title">Mot de passe :</span></label><br />
						<input type="password" name="pass" id="pass" /><br />
						<label for="passre">Vérification :</label><br />
						<input type="password" name="passre" id="passre" /><br />
						<input type="submit" value="Mettre à jour les informations" />
					</form>		
				</p>';

		}
	}
	// post data
	else
	{	
		function ft_update_user_info($key, $value)
		{
			$bdd = ft_connect_bdd();
			$req_pseudo = $bdd->prepare('UPDATE users SET '.$key.' = ? WHERE id = ?');
			$req_pseudo->execute(array($value, $_SESSION['id']));
		}

		if (!empty($_POST['pseudo']))
		{
			ft_update_user_info('pseudo', $_POST['pseudo']);
			echo '<p class="alert_ok">Votre pseudo a bien été mis à jour.</p>';
		}
		else
			echo '<p>Votre pseudo n\'a pas été modifié.</p>';

		if (!empty($_POST['mail']))
		{
			ft_update_user_info('mail', $_POST['mail']);
			echo '<p class="alert_ok">Votre adresse email a bien été mis à jour.</p>';
		}
		else
			echo '<p>Votre adresse email n\'a pas été modifiée.</p>';

		if (!empty($_POST['pass']) && !empty($_POST['passre']) && $_POST['pass'] == $_POST['passre'])
		{
			$pass_hache = sha1($_POST['pass']);
			ft_update_user_info('pass', $pass_hache);
			echo '<p class="alert_ok">Votre mot de passe a bien été mis à jour.</p>';
		}
		else
			echo '<p>Votre mot de passe n\'a pas été modifié.</p>';
	}

?>
