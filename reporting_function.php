<?php

	session_start();

	$user_id = $_SESSION['user_id'];

	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');

	$post_id = $_GET['q'];

	$report_checking_query = "SELECT * FROM reports WHERE post_id = '$post_id' AND reporter_id = '$user_id'";

	$report_checking_result = mysqli_query($connection, $report_checking_query);

	$post_select_query = "SELECT * FROM posts WHERE post_id = '$post_id'";

	$selected_post = mysqli_query($connection, $post_select_query);

	$post = mysqli_fetch_assoc($selected_post);


	if (mysqli_num_rows($report_checking_result)) {

		$report_amount = $post['reports']-1;

		$post_report_update_query = "UPDATE posts SET reports = '$report_amount' WHERE post_id = '$post_id'";

		mysqli_query($connection, $post_report_update_query);

		$report_list_delete_query = "DELETE FROM reports WHERE post_id = '$post_id' AND reporter_id = '$user_id'";

		mysqli_query($connection, $report_list_delete_query);

	} else {

		$report_amount = $post['reports']+1;

		$post_report_update_query = "UPDATE posts SET reports = '$report_amount' WHERE post_id = '$post_id'";

		mysqli_query($connection, $post_report_update_query);

		$report_list_insert_query = "INSERT INTO reports VALUES ('', '$post_id', '$user_id')";

		mysqli_query($connection, $report_list_insert_query);


	
	}






	// 

	$report_checking_result = mysqli_query($connection, $report_checking_query);

	if (mysqli_num_rows($report_checking_result)) {
		
		echo "1";
	} else {

		echo "0";
	}


?>