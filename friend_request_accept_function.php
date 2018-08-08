<?php

	session_start();

	if (!$user_id = $_SESSION['user_id']) {
		
		header("Location:login.php");
	}

	$person_id = $_GET['q'];

	$date = date("d M Y");

	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');
		
	$friend_list_inserting_query = "INSERT INTO friend_list VALUES ('', '$person_id', '$user_id')";

	mysqli_query($connection, $friend_list_inserting_query);

	$friend_request_deleting_query = "DELETE FROM friend_requests 
											WHERE 
											(getter_id = '$user_id' AND sender_id = '$person_id')";


	mysqli_query($connection, $friend_request_deleting_query);

	$notify_sender_query = "INSERT INTO notifications VALUES ('', '$person_id', '$user_id', '', 'friend', '$date')";

	mysqli_query($connection, $notify_sender_query);

?>