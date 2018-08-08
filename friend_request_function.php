<?php

	session_start();

	if (!$user_id = $_SESSION['user_id']) {
		
		header("Location:login.php");
	}

	$person_id = $_GET['q'];

	$date = date("d M Y");

	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');
		
	$friend_request_sending_query = "INSERT INTO friend_requests VALUES ('', '$person_id', '$user_id', '$date')";

	$result = mysqli_query($connection, $friend_request_sending_query);

	echo "Sent";

?>