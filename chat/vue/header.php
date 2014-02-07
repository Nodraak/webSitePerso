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

if (isset($_SESSION['id']) && $_SESSION['id'] == 1)
{
		include_once('modele/notif.php');
		$notif = new Notif();
		if ($notif->isValid)
		{
			$nb = $notif->count();
			echo '<li class="menuNotif">'.$nb.' notification(s)
							<ul>';
								for ($i = 0; $i < $nb; $i++)
								{
									echo '<li><a href="index.php?page=message&id='.$notif->getId($i).'&offset=1">'.$notif->getTitle($i).'</a></li>';
								}

			echo '</ul>
					</li>';
		}
}
		if (isset($_SESSION['pseudo'])) // yet logged
			echo '<li><a href="index.php?page=logout">Se déconnecter</a></li>';
		else // not logged yet
			echo '<li><a href="index.php?page=login">Se connecter</a></li>';

			echo '
		</ul>
	</div>
</header>';

?>
