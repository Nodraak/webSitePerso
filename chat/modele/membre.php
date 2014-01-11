
<?php
	include_once('modele/init.php');

class Membre
{
	/* VARIABLE */
	private $id;
	private $pseudo;
	private $signedup;
	private $mail;
	private $sign;
	private $avatar;
	public $isValid;

	/* */
	public function __construct($id)
	{
		if (!empty($id))
		{
			$bdd = ft_connect_bdd();
			$req = $bdd->prepare('SELECT pseudo, mail, signedup, sign FROM users WHERE id = :id');
			$req->execute(array('id' => $id));
			$data = $req->fetch();
	
			if (!empty($data))
			{
				$this->id = $id;
				$this->set_pseudo($data['pseudo']);
				$this->set_signedup($data['signedup']);
				$this->set_mail($data['mail']);
				$this->set_sign($data['sign']);
				$this->set_avatar('http://www.gravatar.com/avatar/'.md5(strtolower(trim($this->id))).'?d=identicon&s=');
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
		return substr($this->pseudo, 0, 10);
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
		if (!empty($this->sign))
			return '<div class="paddingTextSign"></div><div class="sign">'.ft_parse_text($this->sign).'</div>';
		else
			return '';
	}
	public function get_edit($message)
	{
		if ($message->get_author() == $_SESSION['id'])
			return '<div class="edit"><a href="?page=edit_msg&id='.$message->get_id().'">Editer le message</a></div>';
		else
			return '';
	}



	public function get_avatar($size)
	{
		return $this->avatar.$size;
	}
	public function is_valid()
	{
		return $this->isValid;
	}

	/* SETTER */
	public function set_pseudo($nouveauPseudo)
	{
		if (!empty($nouveauPseudo) && strlen($nouveauPseudo) < 10)
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
	public function set_avatar($url)
	{
		if (!empty($url))
		{
			$this->avatar = $url;
			// bdd update
			return 0;
		}
		else
			return 1;
	}

}

?>

