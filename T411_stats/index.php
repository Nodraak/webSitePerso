<?php include_once('options.php'); ?>
<?php include_once('get.php'); ?>
<?php include_once('vue.php'); ?>

<!DOCTYPE html>
<html>
	<head>
		<title>Page perso d'Adrien ! - Accueil</title>
		<?php include("head.php"); ?>
	</head>

	<body>
		<?php include("header.php"); ?>

		<div id=block_page>
		
			<?php
				$dataPath = '/home/adur/t411_sh/stat_analyse/Data/';
				
				if (!isset($_GET['page'])) // list files
				{
					echo '<h1>stats T411 - Home</h1>';
					ft_print_links($dataPath);
				}
				else // show datas
				{
					echo '<h1>stats T411 -- '.$_GET['page'];
					if (isset($_GET['duration']))	echo ' -- Duration : '.$_GET['duration'];
					else													echo ' -- All';
					echo '</h1>';

					ft_print_stats_page($dataPath);
				}
			?>
		</div>

		<?php include("footer.php"); ?>
	</body>
</html>
