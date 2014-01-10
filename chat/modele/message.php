
<?php
	include_once('modele/init.php');

	class Message
	{
		private $id;
		private $posted;
		//private $edited;
		private $thread;
		private $author;
		private $text;
		public $isValid;

		/*===*/
		public function __construct($id)
		{
			if (!empty($id))
			{
				$bdd = ft_connect_bdd();
				$req = $bdd->prepare('SELECT author, posted, text FROM messages WHERE id = :id');
				$req->execute(array('id' => $id));
				$data = $req->fetch();

				if (!empty($data))
				{
					$this->id = $id;
					$this->posted = $data['posted'];
					$this->author = $data['author'];
					$this->thread = $id;
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
		public function get_text()
		{
			return ft_parse_text($this->text);
		}

	}

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

