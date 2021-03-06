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

					$this->updateNotifSetOff($_SESSION['id'], $this->thread);
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

			$this->updateNotifSetOn($this->thread);
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
			
			$req = $bdd->prepare('SELECT posted FROM messages WHERE author = ? AND thread = ? ORDER BY posted DESC LIMIT 0,1');
			$req->execute(array($_SESSION['id'], $thread_id));
			$ret = $req->fetch();

			$req_now = $bdd->query('SELECT NOW()');
			$ret_now = $req_now->fetch();

			// get notif when new msg
			$this->followThread($this->thread);

			// check anti flood
			if (strtotime($ret['posted']) + 60*5 < strtotime($ret_now[0]))
			{
				// post msg in bdd
				$req = $bdd->prepare('INSERT INTO messages (posted, thread, author, text) VALUES(NOW(), ?, ?, ?)');
				$req->execute(array($thread_id, $_SESSION['id'], $text));
			
				// get msg data and build object
				$id = $bdd->lastInsertId();
				$this->__construct($id);
		
				// update stats
				$this->update_thread_activity();
				$this->update_thread_nbMessage();

				// update last activity
				$req = $bdd->prepare('UPDATE users SET lastCo = NOW() WHERE id = ?');
				$req->execute(array($_SESSION['id']));

				return '0';
			}
			else
				return 'anti_flood';
		}

		public function edit_message($text)
		{
			$bdd = ft_connect_bdd();
			$req = $bdd->prepare('UPDATE messages SET text = ?, posted = NOW() WHERE id = ?');
			$req->execute(array($text, $this->get_id()));

			$this->update_thread_activity();
		}

		/*=== NOTIF ===*/
		private function updateNotifSetOff($user, $thread)
		{
			$bdd = ft_connect_bdd();
			$req = $bdd->prepare('UPDATE notifs SET nonRead = 0 WHERE (idMembre = ? AND idThread = ?)');
			$req->execute(array($user, $thread));
		}

		private function updateNotifSetOn($thread)
		{
			$bdd = ft_connect_bdd();
			$req = $bdd->prepare('UPDATE notifs SET nonRead = 1 WHERE (idThread = ? AND idMembre != ?)');
			$req->execute(array($thread, $_SESSION['id']));

			$this->followThread($thread);
		}

		private function followThread($thread)
		{
			$bdd = ft_connect_bdd();

			// check if already followed
			$req = $bdd->prepare('SELECT id FROM notifs WHERE (idMembre = ? AND idThread = ?)');
			$req->execute(array($_SESSION['id'], $thread));
			$ret = $req->rowCount();

			// if not followed
			if ($ret == 0)
			{
				$req = $bdd->prepare('INSERT INTO notifs (idMembre, idThread, nonRead) VALUES (?, ?, 0)');
				$req->execute(array($_SESSION['id'], $thread));
			}
		}
		
	}
	
?>
