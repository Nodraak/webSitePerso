<?php
	include_once('modele/init.php');
	include_once('modele/membre.php');

		$membre = new Membre($_GET['id']);

		echo '<h2>Membre : '.$membre->get_pseudo().'</h2>';
	
		if ($_GET['id'] == $_SESSION['id'])
			echo '<p><a href="?page=edit_user&id='.$_GET['id'].'">Editer le profil</a></p>';

		
		if (!$membre->is_valid())
		{
			echo '<p class="alert_ko">Ereur, le membre n\'a pas été trouvé.</p>';
		}
		else
		{
			echo '<div class="user">
						<div class="col1">
							<table>
								<tr>
									<td class="avatar"><img src='.$membre->get_avatar(75).'alt=pseudo gravatar /></td>
								</tr>
							</table>
						</div>
						<div class="col2">
							<table>
								<tr>
									<td>Pseudo : '.$membre->get_pseudo().'</td>
								</tr>
								<tr>
									<td>Inscription : '.date('d/m/Y', strtotime($membre->get_signedup())).'</td>
								</tr>
								<tr>
									<td>Email : '.$membre->get_mail().'</td>
								</tr>
							</table>
						</div>
					</div>';
		}

?>

