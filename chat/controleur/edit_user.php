
<?php
	include_once('modele/init.php');
	include_once('modele/signup.php');

	$bdd = ft_connect_bdd();
	$req = $bdd->prepare('SELECT signedup, pseudo, mail FROM users WHERE id = :id');
	$req->execute(array('id' => $_GET['id']));

	//$grav_url = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($_GET['id']))).'?d=identicon&s=75';
	$req_data = $req->fetch();

	echo '<h2>Membre : '.$req_data['pseudo'].'</h2>';
	
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
					echo '<p><form method="post" action="index.php?page=signup">
									<table>
										<tr>
											<td><label for="pseudo">Pseudo : </label></td>
											<td><input type="text" name="pseudo" id="pseudo" maxlength="10" value="'.$req_data['pseudo'].'"></td>
										</tr><tr>
											<td><label for="pass">Mot de passe :</label></td>
											<td><input type="password" name="pass" id="pass" /></td>
										</tr><tr>
											<td><label for="passre">Vérification du mot de passe :</label></td>
											<td><input type="password" name="passre" id="passre" /></td>
										</tr><tr>
											<td><label for="mail">Adresse email :</label></td>
											<td><input type="email" name="mail" id="mail" size="30" /></td>
										</tr><tr>
											<td colspan="2" class="center"><input type="submit" value="Mettre à jour les informations" /></td>
										</tr>
									</table>
								</form></p>';

	}

?>

