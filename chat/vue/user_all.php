<?php
	include_once('modele/init.php');
	include_once('modele/membre.php');

		$bdd = ft_connect_bdd();
		$req = $bdd->query('SELECT COUNT(*) FROM users');
		$nb = $req->fetchColumn();

		echo '<h2>'.$nb.' membres trouvés :</h2>';

		echo '<table>';
		foreach ($bdd->query('SELECT id FROM users ORDER BY id ASC') as $data)
		{
			$membre = new Membre($data['id']);

			echo '<tr>';
				echo '<td width="30"><img src='.$membre->get_avatar(25).'alt=pseudo gravatar /></td>';
				echo '<td><a href="?page=user&id='.$membre->get_id().'">'.$membre->get_pseudo().'</a></td>';
			echo '</tr>';
		}
		echo '</table>';

?>

