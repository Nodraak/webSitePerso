<?php include('options.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Page perso d'Adrien !</title>
		<link rel="stylesheet" href="styles.css" />
		<?php include('head.php'); ?>
	</head>

	<body>
		<?php include('header.php'); ?>

		<div id=block_page>
			<h1>Accueil</h1>

			<h2>Bienvenue cher visiteur !</h2>
			<p>Bonjour, comment allez vous ?</p>
			<?php
				if (isset($_SESSION['pseudo'])) // yet logged
				{
					echo '<p>Vous êtes actuellement connecté en tant que <strong>'.$_SESSION['pseudo'].'</strong>.</p>';
				}
				else // not logged yet
				{
					echo '<p>Vous n\'êtes actuellement pas connecté. Vous pouvez vous connecter en <a href="login.php">cliquant ici</a>.</p>';
				}
			?>

		</div>

		<?php include('footer.php'); ?>
	</body>
</html>
