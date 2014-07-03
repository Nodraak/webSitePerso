<?php

/******************************************************************************* 
*
*   File : membre.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 19:24:43
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-11 19:53:30
*
*******************************************************************************/

include_once('modele/init.php');

class Membre
{
	/* VARIABLE */
	private $id;
	private $pseudo;
	private $signedup;
	private $mail;
	private $sign;
	private $avatar; // gravatar url
	private $lastCo;
	public $isValid;

	/* */
	public function __construct($id)
	{
		if (!empty($id))
		{
			$bdd = ft_connect_bdd();
			$req = $bdd->prepare('SELECT pseudo, mail, signedup, sign, lastCo FROM users WHERE id = :id');
			$req->execute(array('id' => $id));
			$data = $req->fetch();
	
			if (!empty($data))
			{
				$this->id = $id;
				$this->set_pseudo($data['pseudo']);
				$this->set_signedup($data['signedup']);
				$this->set_mail($data['mail']);
				$this->set_sign($data['sign']);
				$this->set_avatar($id);
				$this->lastCo = $data['lastCo'];
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
	public function get_pseudo()
	{
		return $this->pseudo;
	}
	public function get_signedup()
	{
		return $this->signedup;
	}
	public function get_mail()
	{
		return $this->mail;
	}
	public function get_sign()
	{
		// empty or isset or isnull
		if (!empty($this->sign))
			return '<div class="paddingTextSign"></div><div class="sign">'.ft_parse_text($this->sign).'</div>';
		else
			return '';
	}
	public function get_sign_raw()
	{
		return $this->sign;
	}

	public function get_edit($message)
	{
		if ($message->get_author() == $_SESSION['id'])
			return '<div class="edit"><a href="?page=edit_msg&id='.$message->get_id().'">Editer le message</a></div>';
		else
			return '';
	}
	public function get_avatar()
	{
		return $this->avatar;
	}
	public function is_valid()
	{
		return $this->isValid;
	}
	public function get_lastCo()
	{
		return $this->lastCo;
	}

	/* SETTER */
	public function set_pseudo($nouveauPseudo)
	{
		if (!empty($nouveauPseudo))
		{
			$this->pseudo = $nouveauPseudo;
			// bdd update
			return 0;
		}
		else
			return 1;
	}
	public function set_signedup($date)
	{
		if (!empty($date))
		{
			$this->signedup = $date;
			// bdd update
			return 0;
		}
		else
			return 1;
	}
	public function set_mail($mail)
	{
		if (!empty($mail))
		{
			$this->mail = $mail;
			// bdd update
			return 0;
		}
		else
			return 1;
	}
	public function set_sign($sign)
	{
		if (!empty($sign))
		{
			$this->sign = $sign;
			// bdd update
		}
		else
			$this->signb = '';
	}
	public function set_avatar($id)
	{
		$matches = glob('img/'.$this->get_id().'.*');
		$nb = count($matches);

		if ($nb == 0)
			$this->avatar = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($id))).'?d=identicon&s=200';	
		else if ($nb == 1 && is_file($matches[0]))
			$this->avatar = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/chat/'.$matches[0];
		else
			error_log('ERROR IN FILE '.__FILE__.' LINE '.__LINE__.' >> number of avatar img > 1 for user id='.$id);

	}

}

		function ft_update_user_info($key, $value)
		{
			$bdd = ft_connect_bdd();

			if (strcmp($key, 'pseudo') == 0)
			{
				$req_check_pseudo = $bdd->prepare('SELECT id FROM users WHERE pseudo = ?');
				$req_check_pseudo->execute(array($_POST['pseudo']));
				$data_check_pseudo = $req_check_pseudo->fetch();

				if ($data_check_pseudo)
				{
					echo '<p>Erreur, le pseudo est déja utilisé.</p>';
					return 1;
				}
				else
				{
					$pseudo = substr($value, 0, 20);
					$req = $bdd->prepare('UPDATE users SET '.$key.' = ? WHERE id = ?');
					$req->execute(array($value, $_SESSION['id']));
					return 0;
				}
			}
			else
			{
				$req = $bdd->prepare('UPDATE users SET '.$key.' = ? WHERE id = ?');
				$req->execute(array($value, $_SESSION['id']));
				return 0;
			}
		}

function ft_update_avatar($isPostFromForm, $id, $fileName = '', $errorServer = 0, $fileSize = 0, $fileTmpName = '')
{
	if ($isPostFromForm == 1)
	{
			$nbError = 0;

			if ($errorServer != 0)
				echo '<p class="alert_ko">Erreur (code = erreur server : '.$errorServer.' - contactez l\'administrateur)</p>', $nbError++;

			if ($fileSize > 100000)
				echo '<p class="alert_ko">Erreur (code = taille en octets)</p>', $nbError++;

			$extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
			$extension_upload = strtolower(substr(strrchr($fileName, '.'), 1));
			if (!in_array($extension_upload,$extensions_valides))
				echo '<p class="alert_ko">Erreur (code = extension non autorisée)</p>', $nbError++;

			$image_sizes = getimagesize($_FILES['avatar']['tmp_name']);
			if ($image_sizes[0] > 200 || $image_sizes[1] > 200)
				echo '<p class="alert_ko">Erreur (code = taille en pixels)</p>', $nbError++;

			if ($nbError == 0)
			{
				@unlink($_SESSION['id'].'.*'); /* @ disable warning if no file(s) exist */
				$newPath = 'img/'.$id.'.'.$extension_upload;
				$resultat = move_uploaded_file($fileTmpName, $newPath);

				if ($resultat)
					echo '<p class="alert_ok">Transfert réussi</p>';
			}
	}
	else
	{
		$url = 'http://www.gravatar.com/avatar/'.md5(strtolower(trim($id))).'?d=identicon&s=200';
		$newPath = 'img/'.$id.'.png';
		file_put_contents($newPath, file_get_contents($url));
	}

}

?>

