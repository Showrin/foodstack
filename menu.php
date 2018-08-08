<?php

	$menu_id = $_GET['menu_id'];

	session_start();

	$user_id = $_SESSION['user_id'];

	echo $user_id;

	echo $menu_id;

?>