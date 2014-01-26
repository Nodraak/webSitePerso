<?php


if (isset($_GET['id']))
{
	$str = 'mpg123 /home/adur/Music/music/'.$_GET['id'].' > /dev/null 2>&1 &';
	exec($str);
}
else if (isset($_GET['level']))
{
	$current = exec('amixer cget iface=MIXER,name="Master Playback Volume"|head -n 3 |tail -n 1 |cut -d "=" -f 2');

	echo 'coucou'.$current;

	if (strcmp($_GET['level'], 'P') == 0)
	{
		$current++;
		$str = 'amixer cset iface=MIXER,name="Master Playback Volume" '.$current.' > /dev/null';
		exec($str);
	}
	if (strcmp($_GET['level'], 'M') == 0)
	{
		$current--;
		$str = 'amixer cset iface=MIXER,name="Master Playback Volume" '.$current.' > /dev/null';
		exec($str);
	}

}

?>
