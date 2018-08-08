<?php

	session_start();

	if (!$user_id = $_SESSION['user_id']) {
		
		header("Location:login.php");
	} else {
		session_destroy();

		header("Location:login.php");
	}

?>