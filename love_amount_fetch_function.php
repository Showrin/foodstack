<?php

	session_start();

	$user_id = $_SESSION['user_id'];

	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');

	$post_id = $_GET['q'];

	$post_select_query = "SELECT * FROM posts WHERE post_id = '$post_id'";

	$selected_post = mysqli_query($connection, $post_select_query);

	$post = mysqli_fetch_assoc($selected_post);

	echo $post['loves'];

?>