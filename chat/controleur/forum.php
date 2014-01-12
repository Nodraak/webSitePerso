<?php

/******************************************************************************* 
*
*   File : forum.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-11 11:54:30
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-12 12:24:05
*
*******************************************************************************/

	include_once('modele/init.php');
	include_once('modele/forum.php');
	include_once('modele/membre.php');

	echo '<h2>Forums</h2>';
	echo '<p><a href="index.php?page=new_thread">Créer un nouveau sujet</a></p>';

	$bdd = ft_connect_bdd();
	$req_thread = $bdd->query('SELECT id FROM threads ORDER BY activity DESC LIMIT 0, 15');

	while ($data_thread = $req_thread->fetch())
	{
		$forum = new Forum($data_thread['id']);
		$author = new Membre($forum->get_owner());

		echo '<div class="thread"><table>
				<tr>
					<td class="title"><a href="index.php?page=message&id='.$forum->get_id().'&offset=1">'.$forum->get_title().'</a></td>
					<td class="time time_activity">'.$forum->get_nbMessage().' messages, dernière activité le ' . date('d/m/Y à H\hi', $forum->get_activity()) . '</td>
				</tr><tr>
					<td class="auteur"><a href="index.php?page=user&id='.$forum->get_owner().'">'.$author->get_pseudo().'</a></td>
					<td class="time time_created">Créé le ' . date('d/m/Y à H\hi', $forum->get_created()) . '</td>
				</tr>
			</table></div>';
	}

?>