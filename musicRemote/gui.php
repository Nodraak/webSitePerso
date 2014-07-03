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

/*=== CONTROL ===*/

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

/*=== LIST TABLE HEADER ===*/

	echo '<table class="list">';
	echo '<tr>
					<th>N°</th>
					<th>Titre</th>
					<th>Artiste</th>
					<th>Album</th>
			</tr>';

/*=== LIST TABLE DATA ===*/

	$fileAll = scandir('/home/adur/Musique/music/');
	exec('exiftool /home/adur/Musique/music/* | grep Title', $title);
	exec('exiftool /home/adur/Musique/music/* | grep Artist', $artist);
	exec('exiftool /home/adur/Musique/music/* | grep Album', $album);

	$i = 0;
	foreach ($fileAll as $music)
	{
		if (strcmp('.', $music) != 0 && strcmp('..', $music) != 0)
		{
			
			echo '<tr>
							<td id="listId">'.($i+1).'</td>
							<td id="listTitle"><button type="button" onClick="playMusic(\''.$music.'\')" id="'.$music.'" >'.substr($title[$i], 34, 30).'</button></td>
							<td id="listArtist">'.substr($artist[$i], 34, 30).'</td>
							<td id="listAlbum">'.substr($album[$i], 34, 30).'</td>
						</tr>';
			$i++;
		}
	}
	echo '</table>';

?>
