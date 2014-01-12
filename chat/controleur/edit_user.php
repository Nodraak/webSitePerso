<?php

/******************************************************************************* 
*
*   File : edit_user.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 19:14:21
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-11 19:23:25
*
*******************************************************************************/

	include_once('modele/init.php');
	include_once('modele/membre.php');

	// no post data
	if (empty($_POST['pseudo']) && empty($_POST['mail']) && empty($_POST['pass']) && empty($_POST['passre']) && !isset($_FILES['avatar']) && empty($_POST['sign']))
	{
		if (isset($_GET['id']))
		{
			$membre = new Membre($_GET['id']);
		}

		echo '<h2>Editer mon profil</h2>';
		
		if (isset($membre) && !$membre->isValid)
		{
			echo '<p class="alert_ko">Ereur, le membre n\'a pas été trouvé.</p>';
		}
		else if (!isset($membre) || $membre->get_id() != $_SESSION['id'])
		{
			echo '<p class="alert_ko">Ereur, vous n\'avez pas les droits requis pour accéder à cette page.</p>';
		}
		else
		{
			echo '<p>
					<form method="post" action="index.php?page=edit_user&id='.$membre->get_id().'">
						<label for="pseudo"><span class="title">Pseudo :</span></label><br />
						<input type="text" name="pseudo" id="pseudo" value="'.$membre->get_pseudo().'" required /><br />
						<input type="submit" value="Mettre à jour le pseudo" />
					</form>
				</p>
				<p>
					<form method="post" action="index.php?page=edit_user&id='.$membre->get_id().'">
						<label for="mail"><span class="title">Adresse email :</span></label><br />
						<input type="email" name="mail" id="mail" size="40" value="'.$membre->get_mail().'" required /><br />
						<input type="submit" value="Mettre à jour l\'adresse email" />
					</form>
				</p>
				<p>
					<form method="post" action="index.php?page=edit_user&id='.$membre->get_id().'">
						<label for="pass"><span class="title">Mot de passe :</span></label><br />
						<input type="password" name="pass" id="pass" /><br />
						<label for="passre">Vérification :</label><br />
						<input type="password" name="passre" id="passre" required /><br />
						<input type="submit" value="Mettre à jour le mot de passe" />
					</form>		
				</p>
				<p>
					<form method="post" action="index.php?page=edit_user&id='.$membre->get_id().'">
						<label for="sign"><span class="title">Signature :</span></label><br />
						<input type="text" name="sign" id="sign" size="40" value="'.$membre->get_sign_raw().'" required /><br />
						<input type="submit" value="Mettre à jour la signature" />
					</form>
				</p>
				<p>
					<form method="post" action="index.php?page=edit_user&id='.$membre->get_id().'" enctype="multipart/form-data">
						<label for="avatar"><span class="title">Avatar :</span>	</label><br />
						Image png, jpg ou gif, de 50 ko maximum, de 200*200 px maximum.<br />
						<input type="file" name="avatar" id="avatar" required /><br />
						<input type="submit" value="Mettre à jour l\'avatar" />
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

		if (isset($_FILES['avatar']))
		{
			$nbError = 0;

			if ($_FILES['avatar']['error'] != 0)
				echo '<p>Erreur (code = server : '.$_FILES['avatar']['error'].')</p>', $nbError++;

			if ($_FILES['avatar']['size'] > 100000)
				echo '<p>Erreur (code = size_bytes)</p>', $nbError++;

			$extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
			$extension_upload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
			if (!in_array($extension_upload,$extensions_valides))
				echo '<p>Erreur (code = extension)</p>', $nbError++;

			if ($nbError == 0)
			{
				$image_sizes = getimagesize($_FILES['avatar']['tmp_name']);
				if ($image_sizes[0] > 200 || $image_sizes[1] > 200)
					echo '<p>Erreur (code = size_px)</p>', $nbError++;

				if ($nbError == 0)
				{
					$newPath = 'img/'.$_SESSION['id'].'.'.$extension_upload;
					$resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $newPath);

					if ($resultat)
						echo '<p class="alert_ok">Transfert réussi</p>';
				}
			}
		}

		if (!empty($_POST['sign']))
		{
			ft_update_user_info('sign', $_POST['sign']);
			echo '<p class="alert_ok">Votre signature a bien été mise à jour.</p>';
		}
		else
			echo '<p>Votre signature n\'a pas été modifiée.</p>';

	}

?>
