<?php
	error_reporting(E_ALL | E_STRICT);
	date_default_timezone_set("Europe/Paris");

	if (isset($_GET['debug']))
	{
		echo 	'<div class="debug">'.
					'<strong>DEBUG :</strong><br>'.
					'File : '.$_SERVER['PHP_SELF'].'<br>'.
					'Last modified : '.date("Y-m-d H:i:s", getlastmod()).
					'</div>';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="styles.css">
		<link rel="icon" href="favicon.ico" />
		<title>iTeam</title>
	</head>

	<body>
		<?php include('header.php'); ?>

		<div class="page">
			<h1 class="logo">iTeam - Home</h1>
	
			<?php include('aside.php'); ?>

			<div class="text justify">
				<div class="article">
					<h2>Bonjour !</h2>
					<p>Site en construction les enfants, merci de patienter.</p>
				</div>
				<div class="article">
					<h2>Lorem ipsum</h2>
					<?php include('lorem_ipsum.html'); ?>
				</div>
			</div>

		</div>

		<?php include('footer.php'); ?>
	</body>
</html>

