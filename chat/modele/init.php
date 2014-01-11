<?php
	error_reporting(E_ALL); // loging
	ini_set('display_errors', 1); // show errors online

	date_default_timezone_set('Europe/Paris');
	session_start();

	function ft_connect_bdd()
	{
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=chat;charset=utf8', 'root', 'root');
		}
		catch (Exception $e)
		{
			die('Erreur new PDO - ft_connect_bdd() in '.$e->getFile().' L.'.$e->getLine().' : '.$e->getMessage());
		}

		return $bdd;
	}

	// array of pages authorized for acces without loging
	$page_acces_not_logged = array('login', 'signup', 'lost_pass');

?>