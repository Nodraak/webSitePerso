<?php
	include_once('modele/init.php');
	include_once('modele/membre.php');

	$bdd = ft_connect_bdd();

	if (isset($_GET['id']))
	{
		$membre = new Membre($_GET['id']);

		include_once('vue/user_one.php');
	}
	else
	{
		include_once('vue/user_all.php');
	}

?>

