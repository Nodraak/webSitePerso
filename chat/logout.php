<?php include('options.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Page perso d'Adrien !</title>
		<link rel="stylesheet" href="styles.css" />
		<meta http-equiv="refresh" content="0; url=index.php" />
		<?php include('head.php'); ?>
	</head>

	<body>
		<?php
	 		$_SESSION = array();
			session_destroy();
		?>
		<p>Si la page ne s'actualise pas automatiquement, <a href="index.php">cliquez ici</a>.</p>
	
	</body>
</html>
