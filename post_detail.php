<?php

	session_start();

	$user_id = $_SESSION['user_id'];

	$post_id = $_GET['post_id'];

	echo $user_id. "<br>";
	echo $post_id;

?>