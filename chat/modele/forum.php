<?php

/******************************************************************************* 
*
*   File : forum.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 14:53:37
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-11 19:39:50
*
*******************************************************************************/

	include_once('modele/init.php');

	class Forum
	{
		private $id;
		private $created;
		private $activity;
		private $title;
		private $owner;
		private $nbMessage;
		public $isValid;

		/*===*/
		public function __construct($id)
		{
			if (!empty($id))
			{
				$bdd = ft_connect_bdd();
				$req = $bdd->prepare('SELECT created, activity, title, owner, nbMessage FROM threads WHERE id = :id');
				$req->execute(array('id' => $id));
				$data = $req->fetch();
	
				if (!empty($data))
				{
					$this->id = $id;
					$this->created = $data['created'];
					$this->activity = $data['activity'];
					$this->title = $data['title'];
					$this->owner = $data['owner'];
					$this->nbMessage = $data['nbMessage'];
					$this->isValid = 1;
				}
				else
					$this->isValid = 0;
			}
			else
				$this->isValid = 0;

		}

		/* GETTER */
		public function get_id()
		{
			return $this->id;
		}
		public function get_title()
		{
			return htmlspecialchars(substr($this->title, 0, 50));
		}
		public function get_created()
		{
			return strtotime($this->created);
		}
		public function get_activity()
		{
			return strtotime($this->activity);
		}
		public function get_owner()
		{
			return $this->owner;
		}
		public function get_nbMessage()
		{
			return $this->nbMessage;
		}

	}
?>