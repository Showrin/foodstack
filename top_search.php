<?php

	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');

	//=============== Top Searching ======================

	if (isset($_POST['top_search'])) {

		$search_text = $_POST['search'];

		$people_search_suggestion_query = "SELECT * FROM users WHERE first_name = '$search_text'";

		$people_suggestion_result = mysqli_query($connection, $people_search_suggestion_query);

		$restaurant_search_suggestion_query = "SELECT * FROM restaurants WHERE restaurant_name = '$search_text'";

		$restaurant_suggestion_result = mysqli_query($connection, $restaurant_search_suggestion_query);

		$menu_search_suggestion_query = "SELECT * FROM menues WHERE menu_name = '$search_text'";

		$menu_suggestion_result = mysqli_query($connection, $menu_search_suggestion_query);


		if (mysqli_num_rows($people_suggestion_result)) {

			header("Location:profile_list.php?search_text=$search_text");

		} else if (mysqli_num_rows($restaurant_suggestion_result)) {

			header("Location:restaurant_list.php?search_text=$search_text");
		} else {

			header("Location:menu_list.php?search_text=$search_text");
		}
	}

	//=============== Top Searching ======================

?>