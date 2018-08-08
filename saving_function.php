<?php

	session_start();

	$user_id = $_SESSION['user_id'];

	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');

	$post_id = $_GET['q'];

	$save_checking_query = "SELECT * FROM saved_posts WHERE post_id = '$post_id' AND saver_id = '$user_id'";

	$save_checking_result = mysqli_query($connection, $save_checking_query);


	if (mysqli_num_rows($save_checking_result)) {

		$save_list_delete_query = "DELETE FROM saved_posts WHERE post_id = '$post_id' AND saver_id = '$user_id'";

		mysqli_query($connection, $save_list_delete_query);

	} else {

		$save_list_insert_query = "INSERT INTO saved_posts VALUES ('', '$post_id', '$user_id')";

		mysqli_query($connection, $save_list_insert_query);


	
	}






	// 

	$save_checking_result = mysqli_query($connection, $save_checking_query);

	if (mysqli_num_rows($save_checking_result)) {
		
		echo "1";
	} else {

		echo "0";
	}


?>