<?php

	echo '<h2>Bienvenue cher visiteur !</h2>
		<p>Bonjour, comment allez vous ?</p>';

		if (isset($_SESSION['pseudo'])) // yet logged
		{
			echo '<p>Vous êtes actuellement connecté en tant que <strong>'.$_SESSION['pseudo'].'</strong></p>';
		}
		else // not logged yet
		{
			echo '<p>Vous n\'êtes actuellement pas connecté. Vous pouvez vous connecter en <a href="index.php?page=login">cliquant ici</a>.</p>';
		}

?>