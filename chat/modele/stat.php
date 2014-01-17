<?php

/******************************************************************************* 
*
*   File : stat.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-17 22:14:01
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-17 22:44:20
*
*******************************************************************************/

	include_once('modele/init.php');

	$bdd = ft_connect_bdd();

	// check if stat is yet saved
	$req = $bdd->prepare('SELECT id FROM stats WHERE ip = ?');
	$req->execute(array($_SERVER['REMOTE_ADDR']));
	$ret = $req->fetch();

	if ($ret) // update
	{
		$pseudo = (isset($_SESSION['id']) ? $_SESSION['id'] : 0);

		$req = $bdd->prepare('UPDATE stats SET timestamp = NOW(), page = ?, idPseudo = ? WHERE id = ?');
		$req->execute(array($_SERVER['QUERY_STRING'], $pseudo, $ret['id']));
	}
	else // add
	{
		$pseudo = (isset($_SESSION['id']) ? $_SESSION['id'] : 0);

		$req = $bdd->prepare('INSERT INTO stats (ip, timestamp, page, idPseudo) VALUES (?, NOW(), ?, ?)');
		$req->execute(array($_SERVER['REMOTE_ADDR'], $_SERVER['QUERY_STRING'], $pseudo));
	}

	// get nb active
	$req = $bdd->query('SELECT COUNT(*) FROM stats WHERE timestamp > NOW() - 300');
	//$ret = $req->fetch();

	$nbCo = $ret[0];
?>
