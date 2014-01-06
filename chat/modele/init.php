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





?>
