<?php

	session_start();

	$user_id = $_SESSION['user_id'];

	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');

	$post_id = $_GET['q'];

	$love_checking_query = "SELECT * FROM loves WHERE post_id = '$post_id' AND lover_id = '$user_id'";

	$love_checking_result = mysqli_query($connection, $love_checking_query);

	$post_select_query = "SELECT * FROM posts WHERE post_id = '$post_id'";

	$selected_post = mysqli_query($connection, $post_select_query);

	$post = mysqli_fetch_assoc($selected_post);


	if (mysqli_num_rows($love_checking_result)) {

		$love_amount = $post['loves']-1;

		$post_love_update_query = "UPDATE posts SET loves = '$love_amount' WHERE post_id = '$post_id'";

		mysqli_query($connection, $post_love_update_query);

		$love_list_delete_query = "DELETE FROM loves WHERE post_id = '$post_id' AND lover_id = '$user_id'";

		mysqli_query($connection, $love_list_delete_query);

	} else {

		$love_amount = $post['loves']+1;

		$post_love_update_query = "UPDATE posts SET loves = '$love_amount' WHERE post_id = '$post_id'";

		mysqli_query($connection, $post_love_update_query);

		$love_list_insert_query = "INSERT INTO loves VALUES ('', '$post_id', '$user_id')";

		mysqli_query($connection, $love_list_insert_query);



		$notification_checking_query = "SELECT * FROM notifications WHERE post_id = '$post_id'";

		$notification_checking_result = mysqli_query($connection, $notification_checking_query);

		if(!mysqli_num_rows($notification_checking_result)){

			$post_owner_id_select_query = "SELECT * FROM posts WHERE post_id = '$post_id'";

			$post_owner_id_select_result = mysqli_query($connection, $post_owner_id_select_query);


			$post_owner = mysqli_fetch_assoc($post_owner_id_select_result);

			$getter_id = $post_owner['post_giver_id'];

			$date = date("d M Y");

			$love_notification_send_query = "INSERT INTO notifications VALUES ('', '$getter_id', '$user_id', '$post_id', 'love', '$date')";

			mysqli_query($connection, $love_notification_send_query);


		}
	}






	// 

	$love_checking_result = mysqli_query($connection, $love_checking_query);

	if (mysqli_num_rows($love_checking_result)) {
		
		echo "1";
	} else {

		echo "0";
	}


?>