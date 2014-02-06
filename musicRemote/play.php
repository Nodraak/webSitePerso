<?php


if (isset($_GET['action']))
{
	// start server if not running
	if (exec('mocp -Q %file ; echo $?'))
		exec('mocp -S');

	// handle action
	if (strcmp($_GET['action'], 'soundUp') == 0)
	{
		exec('mocp -v +3');
	}
	else if (strcmp($_GET['action'], 'soundDown') == 0)
	{
		exec('mocp -v -3');
	}
	else if (strcmp($_GET['action'], 'playMusic') == 0 && isset($_GET['id']))
	{
		exec('mocp -l /home/adur/Music/music/'.$_GET['id']);
		error_log('try to sstart music');
	}
	else if (strcmp($_GET['action'], 'play') == 0)
	{
		 exec('mocp -U');
	}
	else if (strcmp($_GET['action'], 'pause') == 0)
	{
		exec('mocp -P');
	}
	else if (strcmp($_GET['action'], 'getInfo') == 0)
	{
		exec('mocp -Q	%artist', $ret);
		exec('mocp -Q	%song', $ret);
		exec('mocp -Q	%album', $ret);
		exec('mocp -Q	%ts', $ret);
		exec('mocp -Q	%cs', $ret);

		$data = $ret[0].'#'.$ret[1].'#'.$ret[2].'#'.$ret[4].'#'.$ret[3];

		echo($data);
	}
	else if (strcmp($_GET['action'], 'getIfPlaying') == 0)
	{
		echo exec('mocp -Q %state');
	}

}

?>
