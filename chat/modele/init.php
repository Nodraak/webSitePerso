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

	function ft_parse_text($in)
	{
		$tmp = nl2br(htmlspecialchars($in));

		// escape char, must be first
		$tmp = str_replace('\[', '&#91', $tmp);
		// tab
		$tmp = str_replace('\t', '&nbsp;&nbsp;&nbsp;&nbsp;', $tmp);

		// smiley must be before color (purple)
		$tmp = str_replace(':p', '<span class="smiley_p"></span>', $tmp);

		$tmp = preg_replace('#\[b\](.+)\[/b\]#sU', '<span class="bold">$1</span>', $tmp);
		$tmp = preg_replace('#\[i\](.+)\[/i\]#sU', '<span class="italic">$1</span>', $tmp);
		$tmp = preg_replace('#\[u\](.+)\[/u\]#sU', '<span class="underline">$1</span>', $tmp);
		$tmp = preg_replace('#\[s\](.+)\[/s\]#sU', '<span class="barre">$1</span>', $tmp);
		$tmp = preg_replace('#\[c\](.+)\[/c\]#sU', '<div class="center">$1</div>', $tmp);


		// color
		$tmp = preg_replace('#\[color=(.+)\](.+)\[/color\]#sU', '<span style="color:$1;">$2</span>', $tmp);
		// link
		$tmp = preg_replace('#\[a=(.+)\](.+)\[/a\]#sU', '<a href="http://$1">$2</a>', $tmp);
		// size
		$tmp = preg_replace('#\[size=(.+)\](.+)\[/size\]#sU', '<span class="fontSize$1">$2</span>', $tmp);

		return $tmp;
	}

?>
