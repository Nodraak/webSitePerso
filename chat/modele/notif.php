<?php

/******************************************************************************* 
*
*   File : notif.php
*
*   Author : Adrien Chardon
*   Date :   2014-02-06 19:24:43
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-02-06 19:53:30
*
*******************************************************************************/

include_once('modele/init.php');

class Notif
{
	/* VARIABLE */
	public $data;

	/* */
	public function __construct()
	{
			$bdd = ft_connect_bdd();
			$req = $bdd->prepare('SELECT idThread FROM notifs WHERE idMembre = ?');
			$req->execute(array($_SESSION['id']));

			$this->data = array();
			while ($elem = $req->fetch())
				$this->data[] = $elem;
	}

	public function count()
	{
		return count($this->data);
	}
}
?>
