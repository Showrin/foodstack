<?php

	$restaurant_id = $_GET['restaurant_id'];

	session_start();

	$user_id = $_SESSION['user_id'];

	echo $user_id;

	echo $restaurant_id;

?>