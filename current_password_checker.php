<?php 

// ---------------------- It's the php file to password accessed by index.php file via ajax -----------------------------------------

	session_start();

	$user_id = $_SESSION['user_id'];

	$password = $_GET['q'];
	$password = md5($password);
	$password = sha1($password);

	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');

	$password_search_query = "SELECT * FROM users WHERE user_id = '$user_id'";

	$result = mysqli_query($connection, $password_search_query);

	$row = mysqli_fetch_assoc($result);
	
	if ($row['password'] != $password) {
		
		echo "Password you typed is incorrect";
	}

?>