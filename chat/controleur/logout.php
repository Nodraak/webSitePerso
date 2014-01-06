
<?php
	include_once('modele/init.php');
	$_SESSION = array();
	session_destroy();

	echo '<p>Si la page ne s\'actualise pas automatiquement, <a href="index.php">cliquez ici</a>.</p>';

	header('Location: index.php');

?>


