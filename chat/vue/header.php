<?php

echo '
<header>
	<div class="left"></div>
	
	<div class="middle center">
	<nav>
		<ul>
			<li><a href="index.php">Accueil</a></li>
			<li><a href="index.php?page=forum&offset=1">Forums</a></li>
			<li><a href="index.php?page=user">Membres</a></li>
		</ul>
	</nav>
	</div>

	<div class="right">
		<ul>';


		include_once('modele/notif.php');
		$notif = new Notif();
		$nb = $notif->count();
		echo '<li>'.$nb.' notification(s)</li>';
		
		if (isset($_SESSION['pseudo'])) // yet logged
			echo '<li><a href="index.php?page=logout">Se déconnecter</a></li>';
		else // not logged yet
			echo '<li><a href="index.php?page=login">Se connecter</a></li>';

			echo '
		</ul>
	</div>
</header>';

?>
