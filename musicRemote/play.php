<?php


if (isset($_GET['action']))
{
	// start server
	$str = 'mocp -S';
	exec($str);

	// handle action
	if (strcmp($_GET['action'], 'soundUp') == 0)
	{
		exec('mocp -v +1');
	}
	else if (strcmp($_GET['action'], 'soundDown') == 0)
	{
		exec('mocp -v -1');
	}
	else if (strcmp($_GET['action'], 'playMusic') == 0 && isset($_GET['id']))
	{
		exec('mocp -l /home/adur/Music/music/'.$_GET['id']);
	}
	else if (strcmp($_GET['action'], 'play') == 0)
	{
		 exec('mocp -U');
	}
	else if (strcmp($_GET['action'], 'pause') == 0)
	{
		exec('mocp -P');
	}

}

?>