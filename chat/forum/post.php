<?php
include('../options.php');
?>

<?php
	// Connexion à la base de données
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'adur', 'mdpms');
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}

	if (isset($_SESSION['pseudo']) AND isset($_POST['message']) AND isset($_POST['thread']))
	{
		// post message
		$req = $bdd->prepare('INSERT INTO messages (posted, thread, author, text) VALUES(NOW(), ?, ?, ?)');
		$req->execute(array($_POST['thread'], $_SESSION['id'], $_POST['message']));
		
		// update thread last activity
  	$req_msg_id = $bdd->prepare('UPDATE threads SET activity = NOW() WHERE id = :id');
		$req_msg_id->execute(array('id' => $_POST['thread']));

		header('Location: thread.php?page='.$_POST['thread']);
		exit();
	}
	else
	{
		header('Location: thread.php?page='.$_POST['thread'].'&error=1');
		exit();
	}

?>

