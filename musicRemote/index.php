<!--
/******************************************************************************* 
*
*   File : index.php
*
*   Author : Adrien Chardon
*   Date :   2014-01-23 16:50:10
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-23 18:18:57
*
*******************************************************************************/
-->

<!DOCTYPE html>
<html>
	<head>
		<title>Page perso d'Adrien ! - MusicRemote</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="styles.css" />
	</head>

	<body>
		<header>
			<nav>
				<ul>
					<li><a href=index.php>Home</a></li>
					<li><a href=chat/index.php>Chat</a></li>
					<li><a href=iteam/index.php>iTeam</a></li>
					<li><a href=T411_stats/>T411 stats</a></li>
					<li><a href=musicRemote/>musicRemote</a></li>
				</ul>
			</nav>
		</header>

		<div id="block_page">

			<?php include_once('gui.php') ?>

		</div>

		<footer>
			<p>Page perso, aucun droits reservés.</p>
		</footer>

		<script src="script.js"></script>
	</body>
</html>

