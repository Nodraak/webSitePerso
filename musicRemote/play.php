<?php


if (isset($_GET['action']))
{
	$currentSound = exec('amixer cget iface=MIXER,name="Master Playback Volume"|head -n 3 |tail -n 1 |cut -d "=" -f 2');

	if (strcmp($_GET['action'], 'soundUp') == 0)
	{
		$currentSound++;
		$str = 'amixer cset iface=MIXER,name="Master Playback Volume" '.$currentSound.' > /dev/null';
		exec($str);
	}
	else if (strcmp($_GET['action'], 'soundDown') == 0)
	{
		$currentSound--;
		$str = 'amixer cset iface=MIXER,name="Master Playback Volume" '.$currentSound.' > /dev/null';
		exec($str);
	}
	else if (strcmp($_GET['action'], 'playMusic') == 0 && isset($_GET['id']))
	{
			$str = 'mpg123 /home/adur/Music/music/'.$_GET['id'].' > /dev/null 2>&1 &';
		exec($str);
	}

}

?>