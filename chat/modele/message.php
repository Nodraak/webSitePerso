<?php

/******************************************************************************* 
*
*   File : message.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 19:35:28
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-12 12:35:52
*
*******************************************************************************/

	include_once('modele/init.php');

	class Message
	{
		private $id;
		private $posted; // posted or edited
		private $thread;
		private $author;
		private $text;
		
		public $isValid;

		/*===*/
		public function __construct($id = -1)
		{
			if ($id != -1)
			{
				$bdd = ft_connect_bdd();
				$req = $bdd->prepare('SELECT author, thread, posted, text FROM messages WHERE id = :id');
				$req->execute(array('id' => $id));
				$data = $req->fetch();

				if (!empty($data))
				{
					$this->id = $id;
					$this->posted = $data['posted'];
					$this->author = $data['author'];
					$this->thread = $data['thread'];
					$this->text = $data['text'];
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
		public function get_posted()
		{
			return strtotime($this->posted);
		}
		public function get_thread()
		{
			return $this->thread;
		}
		public function get_author()
		{
			return $this->author;
		}
		public function get_text_raw()
		{
			return $this->text;
		}
		public function get_text_parse()
		{
			return ft_parse_text($this->text);
		}
		/* SETTER */
		public function set_thread($id)
		{
			$this->thread = $id;
		}
		public function set_author($id)
		{
			$this->author = $id;
		}
		public function set_text($text)
		{
			$this->text = $text;
		}

		/* OTHER */
		public function update_thread_activity()
		{
			$bdd = ft_connect_bdd();

			$req = $bdd->prepare('UPDATE threads SET activity = NOW() WHERE id = ?');
			$req->execute(array($this->get_thread()));
		}
		public function update_thread_nbMessage()
		{
			$bdd = ft_connect_bdd();

			$req = $bdd->prepare('UPDATE threads SET nbMessage = nbMessage+1 WHERE id = ?');
			$req->execute(array($this->get_thread()));
		}
		public function post_message($thread_id, $text)
		{
			$bdd = ft_connect_bdd();
			
			// post msg in bdd
			$req = $bdd->prepare('INSERT INTO messages (posted, thread, author, text) VALUES(NOW(), ?, ?, ?)');
			$req->execute(array($thread_id, $_SESSION['id'], $text));
			
			// get msg data and build object
			$id = $bdd->lastInsertId();
			$this->__construct($id);

			$this->update_thread_activity();
			$this->update_thread_nbMessage();
		}
		public function edit_message($text)
		{
			$bdd = ft_connect_bdd();

			$req = $bdd->prepare('UPDATE messages SET text = ?, posted = NOW() WHERE id = ?');
			$req->execute(array($text, $this->get_id()));

			$this->update_thread_activity();
		}
	}
	
?>
