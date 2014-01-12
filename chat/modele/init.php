<?php

/******************************************************************************* 
*
*   File : init.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-12 12:49:42
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-12 13:59:20
*
*******************************************************************************/

	error_reporting(E_ALL); // loging to /App/MAMP/logs/php.logs (approximate path)
	ini_set('display_errors', 1); // show errors online

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
			die('Erreur new PDO - ft_connect_bdd() in '.$e->getFile().' L.'.$e->getLine().' : '.$e->getMessage());
		}

		return $bdd;
	}

	// remove a get variable in an url
	function removeqsvar($url, $varname)
	{
		list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
		parse_str($qspart, $qsvars);
		unset($qsvars[$varname]);
		$newqs = http_build_query($qsvars);
		return $urlpart . '?' . $newqs;
	}

	// array of pages authorized for acces without loging
	$page_acces_not_logged = array('login', 'signup', 'lost_pass');

	// config variables
	const NB_FORUMS_PER_PAGE = 10; /* may be set to 15 */
	const NB_MESSAGES_PER_PAGE = 10; /* may be set to 15 or 20 */

?>
