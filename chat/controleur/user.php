<?php
	include_once('modele/init.php');

	$bdd = ft_connect_bdd();

	if (isset($_GET['id']))
	{
		$req = $bdd->prepare('SELECT signedup, pseudo, mail FROM users WHERE id = :id');
		$req->execute(array('id' => $_GET['id']));

		$grav_url = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($_GET['id']))).'?d=identicon&s=75';
		$req_data = $req->fetch();

		echo '<h2>Membre : '.$req_data['pseudo'].'</h2>';

		echo '<div class="user">
						<div class="col1">
							<table>
								<tr>
									<td class="avatar"><img src='.$grav_url.'alt=pseudo gravatar /></td>
								</tr>
							</table>
						</div>
						<div class="col2">
							<table>
								<tr>
									<td>Pseudo : '.$req_data['pseudo'].'</td>
								</tr>
								<tr>
									<td>Inscription : '.date('d/m/Y', strtotime($req_data['signedup'])).'</td>
								</tr>
								<tr>
									<td>Email : '.$req_data['mail'].'</td>
								</tr>
							</table>
						</div>
					</div>';
	}
	else
	{
		$req = $bdd->query('SELECT COUNT(*) FROM users ORDER BY id ASC');
		$nb = $req->fetchColumn();

		echo '<h2>'.$nb.' membres trouvés :</h2>';

		echo '<table>';
		foreach ($bdd->query("SELECT pseudo, id FROM users ORDER BY id ASC") as $data)
		{
			echo '<tr>';
				$grav_url = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($data['id']))).'?d=identicon&s=25';
				echo '<td width="30"><img src='.$grav_url.'alt=pseudo gravatar /></td>';
				echo '<td><a href="?page=user&id='.$data['id'].'">'.$data['pseudo'].'</a></td>';
			echo '</tr>';
		}
		echo '</table>';
	}

?>

