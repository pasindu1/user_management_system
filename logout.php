<?php 

	session_start();
	echo "Pasindu Weerasinghe";
	echo "Pasindu Weerasinghe";
echo "Pasindu Weerasinghe";
echo "Pasindu Weerasinghe";
	$_SESSION= array();

	if (isset($_COOKIE['session_name()'])) {
		setcookie(session_name(), '', time()-86400,'/');

	}

	session_destroy();

	header('Location: index.php?logout=yes');






 ?>
