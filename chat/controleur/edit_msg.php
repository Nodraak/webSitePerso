<?php
	include_once('modele/init.php');	
	include_once('modele/message.php');	

	$message = new Message($_GET['id']);

	include_once('vue/edit_msg.php');
?>
