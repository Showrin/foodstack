<?php 

// ---------------------- It's the php file to check email availability accessed by sign_up.php file via ajax -----------------------------------------

	$str = $_GET['q'];

	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');

	$email_id_search_query = "SELECT email FROM users WHERE email = '$str'";

	$result = mysqli_query($connection, $email_id_search_query);

	if ($row = mysqli_fetch_assoc($result)) {
		echo "This Email id is already registered";
	}

?>