<?php


if (isset($_GET['action']))
{
	// if the server is not running start it
	if (exec('mocp -Q %title ; echo $?'))
		exec('mocp -S');

	// set music level of the driver to max
	exec('amixer cset iface=MIXER,name="Master Playback Volume" $VOL > /dev/null');

	// handle action
	if (strcmp($_GET['action'], 'soundUp') == 0)
	{
		exec('mocp -v +2');
	}
	else if (strcmp($_GET['action'], 'soundDown') == 0)
	{
		exec('mocp -v -2');
	}
	else if (strcmp($_GET['action'], 'playMusic') == 0 && isset($_GET['id']))
	{
		exec('mocp -l /home/adur/Musique/music/'.$_GET['id']);
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

/*

mocp -Q %file

2	%state     State
	%file      File
4	%title     Title
	%artist    >Artist
6	%song      >SongTitle
	%album     >Album
8	%tt        >TotalTime
	%tl        >TimeLeft
10	%ts        TotalSec
	%ct        >CurrentTime
12	%cs        CurrentSec
	%b         Bitrate
14	%r         Rate

*/


?>
