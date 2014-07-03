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
	private $data;
	public $isValid;

	/* */
	public function __construct()
	{
		if (isset($_SESSION['id']))
		{
			$bdd = ft_connect_bdd();
			$req = $bdd->prepare('SELECT idThread FROM notifs WHERE (idMembre = ? AND nonRead = 1)');
			$req->execute(array($_SESSION['id']));

			$this->data = array();
			while ($elem = $req->fetch())
				$this->data[] = $elem;
			$this->isValid = 1;
		}
		else
			$this->isValid = 0;
	}

	public function count()
	{
		return count($this->data);
	}

	public function getId($id)
	{
		return isset($this->data[$id]) ? $this->data[$id][0] : 0;
	}

	public function getTitle($id)
	{
		$bdd = ft_connect_bdd();
		$req = $bdd->prepare('SELECT title FROM threads WHERE id = ?');
		$req->execute(array($this->getId($id)));

		$ret = $req->fetch();

		return $ret[0];
	}
}
?>
