<?php

/******************************************************************************* 
*
*   File : list.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-23 18:18:25
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-23 18:20:55
*
*******************************************************************************/

<<<<<<< HEAD
	echo '<p id="current">none</p>
				<p>Sound level :
					<button type="button" onClick="updateSoundM()">-</button>
					<span id="currentLevel">none</span>
					<button type="button" onClick="updateSoundP()">+</button>
				</p>';

	$path = '/home/adur/Music/music/';

	$fileAll = scandir($path);

	echo "<table>\n";
	foreach ($fileAll as $music)
	{
		if (strcmp('.', $music) != 0 && strcmp('..', $music) != 0)
		{
			echo '<tr><td><button type="button" onClick="updateCurrent(\''.$music.'\')" id="'.$music.'" >'.$music.'</button></td></tr>';
			echo "\n";
		}
	}
	echo '</table>';

?>