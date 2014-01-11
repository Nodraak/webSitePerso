<?php
	include_once('modele/init.php');

	class Forum
	{
		private $id;
		private $created;
		private $activity;
		private $title;
		private $owner;
		public $isValid;

		/*===*/
		public function __construct($id)
		{
			if (!empty($id))
			{
				$bdd = ft_connect_bdd();
				$req = $bdd->prepare('SELECT created, activity, title, owner FROM threads WHERE id = :id');
				$req->execute(array('id' => $id));
				$data = $req->fetch();
	
				if (!empty($data))
				{
					$this->id = $id;
					$this->created = $data['created'];
					$this->activity = $data['activity'];
					$this->title = $data['title'];
					$this->owner = $data['owner'];
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
			return htmlspecialchars($this->title);
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

	}
?>