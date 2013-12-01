
<header>
	<nav>
		<ul>
			<li><a href="index.php">Accueil</a></li>
			<li><a href="forum/index.php">Forums</a></li>

			<?php
				if (isset($_SESSION['pseudo'])) // yet logged
				{
					echo '<li><a href="logout.php">Se déconnecter</a></li>';
				}
				else // not logged yet
				{
					echo '<li><a href="login.php">Se connecter</a></li>';
				}
			?>
		</ul>
	</nav>
</header>

