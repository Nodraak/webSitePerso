<!--
/******************************************************************************* 
*
*   File : 
*
*   Author : Adrien Chardon
*   Date :   2014-01-12 20:12:00
*
*   Last Modified by :   Adrien Chardon
*   Last Modified time : 2014-01-23 16:49:05
*
*******************************************************************************/
-->

<?php include('options.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Page perso d'Adrien ! - Accueil</title>
		<?php include("head.php"); ?>
	</head>

	<body>
		<div id="block_page">

			<span class="fontSize">
				<button type="button" id="fontM">-</button>
				<span id="fontSize">undef</span>
				<button type="button" id="fontP">+</button>
			</span>

			<h1>Home</h1>

			<h2><?php
				$h = date('H');
				if ($h > 8 &&  $h <= 12)
					echo "Bonjour";
				elseif ($h > 12 && $h <= 16)
					echo "Bonne apres-midi";
				elseif ($h > 16 && $h <= 22)
					echo "Bonsoir";
				elseif ($h > 22 || $h <= 8)
					echo "Bonne nuit";
				else
					echo "oups, il est quelle heure ? Et sinon";
			?>, vous allez bien ? </h2>
			<p>Moi je vais plutôt bien !</p>
			<p>Tenez voici la date complète : <?php
			echo 'nous sommes le '.date('d').'/'.date('m').'/'.date('Y').' et il est '.date('H').'h'.date('i');
			?></p>

			<h2>C'est quoi ce site ?</h2>
			<p>Un site perso qui va me permettre d'apprendre le HTML, le CSS et
				peut-être d'autre langages web.</p>

			<h2>Et il parle de quoi ton site ?</h2>
			<p>Comme il faut bien trouver un sujet, ce sera l'informatique et la
				programmation. Bah oui je suis pas a l'ECE pour rien !
				J'y mettrais des choses que je juge utiles, comme :</p>
			<p>
				<ul>
					<li><a href=chat/index.php>miaou</a> (vous aurez compris : chat).
					<li><a href=iteam/index.php>iTeam</a>
				</ul>
			</p>

			<h2>Pourquoi ton site il est tout moche ?</h2>
				<p>Tout simplement parce que j'en suis qu'a la page 47 sur 248
				du tuto sur le HTML !<br />
			<span class="barre">Et puis si vous êtes pas content vous pouvez
				aller voir ailleurs</span>.</p>
		</div>

		<?php include("footer.php"); ?>
		<script src="script.js"></script>
	</body>
</html>
