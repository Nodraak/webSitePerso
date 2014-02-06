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

	echo
		'<table class="control">
			<tr>
				<td>
					<table class="cell"><tr>
					<td><button type="button" onClick="play()">Play</button></td>
					<td><button type="button" onClick="pause()">Pause</button></td>
					</tr></table>
				</td>
				<td id="title">
					Titre : none
				</td>
			</tr>
			<tr>
				<td>
					<table class="cell"><tr>
					<td><button type="button" onClick="soundDown()">-</button></td>
					<td><button type="button" onClick="soundUp()">+</button></td>
					</tr></table>
				</td>
				<td id="album">
					Album : none
				</td>
			</tr>
			<tr>
				<td>
					<table class="cell"><tr>
					<td id="timeCurrent">none</td>
					<td id="timeLeft">none</td>
					</tr></table>
				</td>
				<td id="artist">
					Artiste : none
				</td>
			</tr>
		</table>';

	$path = '/home/adur/Music/music/';

	$fileAll = scandir($path);

	echo "<table>\n";
	foreach ($fileAll as $music)
	{
		if (strcmp('.', $music) != 0 && strcmp('..', $music) != 0)
		{
			echo '<tr><td><button type="button" onClick="playMusic(\''.$music.'\')" id="'.$music.'" >'.$music.'</button></td></tr>';
			echo "\n";
		}
	}
	echo '</table>';

?>
