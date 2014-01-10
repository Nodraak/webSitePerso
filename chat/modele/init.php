<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	date_default_timezone_set('Europe/Paris');
	session_start();

	function ft_connect_bdd()
	{
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'adur', 'mdpms');
		}
		catch (Exception $e)
		{
			die('Erreur : '.$e->getMessage());
		}

		return $bdd;
	}

	// array of pages authorized for acces without loging
	$page_acces_not_logged = array('login', 'signup', 'lost_pass');

?>
