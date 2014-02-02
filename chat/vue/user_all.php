<?php
	include_once('modele/init.php');
	include_once('modele/membre.php');

	$bdd = ft_connect_bdd();
	$req = $bdd->query('SELECT COUNT(*) FROM users');
	$nb = $req->fetchColumn();

	echo '<h2>'.$nb.' membres trouvés :</h2>';

	echo '<table>';
	$users = $bdd->query('SELECT id FROM users ORDER BY id ASC');
	foreach ($users as $data)
	{
		$membre = new Membre($data['id']);

		echo '<tr>';
			echo '<td width="30"><img src='.$membre->get_avatar().' alt="avatar member id='.$membre->get_id().'" style="max-width: 25px; max-height: 25px;" /></td>';
			echo '<td><a href="?page=user&id='.$membre->get_id().'">'.$membre->get_pseudo().'</a></td>';
		echo '</tr>';
		echo "\n";
	}
	echo '</table>';

?>
