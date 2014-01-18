<?php
	include_once('modele/init.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Page perso d'Adrien ! - Chat</title>
		<?php include_once('vue/head.php'); ?>
	</head>

	<body>
		<?php include_once('vue/header.php'); ?>

		<div id=block_page>
<?php
				if (!empty($_GET['page']) && is_file('controleur/'.$_GET['page'].'.php'))
				{
					if (!isset($_SESSION['pseudo']) && !in_array($_GET['page'], $page_acces_not_logged))
						echo '<p class="alert_ko">Vous n\'êtes pas autorisé a accéder à cette page, merci de vous connecter.</p>';
					else
						include_once('controleur/'.$_GET['page'].'.php');	
				}
				else
				{
					include_once('controleur/home.php');
				}
		</div>

		<?php include_once('vue/footer.php'); ?>
	</body>
</html>
