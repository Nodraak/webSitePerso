
<meta charset="utf-8" />
<link rel="icon" type="image/png" href="favicon.png">
<link rel="stylesheet" type="text/css" href="style/global.css" />
<link rel="stylesheet" type="text/css" href="style/form.css" />

<?php
	if (!empty($_GET['page']) && is_file('style/'.$_GET['page'].'.css'))
		echo '<link rel="stylesheet" href="style/'.$_GET['page'].'.css" />';
?>

