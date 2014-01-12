<?php

/******************************************************************************* 
*
*   File : user_one.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 19:10:21
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-11 21:07:01
*
*******************************************************************************/

	include_once('modele/init.php');
	include_once('modele/membre.php');

		function ft_get_human_timestamp($timestamp)
		{
			if ($timestamp < 60) // < 1 mn
			{
				return '0 minute(s) (à l\'instant quoi)';
			}
			else if ($timestamp < 60*60) // < 1 hour
			{
				$ret = (int)($timestamp/60);
				return $ret.' minute(s)';
			}
			else if ($timestamp < 60*60*24) // < 1 day
			{
				$ret = (int)($timestamp/(60*60));
				return $ret.' heure(s)';
			}
			else if ($timestamp < 60*60*24*31) // < 1 month
			{
				$ret = (int)($timestamp/(60*60*24));
				return $ret.' jours';
			}
			else
			{
				$ret = (int)($timestamp/(60*60*24*31));
				return $ret.' mois';
			}

		}

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
			$lastCo = ft_get_human_timestamp(time()-strtotime($membre->get_lastCo()));

			echo '<div class="user">
						<div class="col1">
							<table>
								<tr>
									<td class="avatar"><img src='.$membre->get_avatar().' alt=avatar style="max-width: 75px; max-height: 75px;" /></td>
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
								<tr>
									<td>Dernière connexion : Il y a environ '.$lastCo.'.</td>
								</tr>
							</table>
						</div>
					</div>';
		}

?>

