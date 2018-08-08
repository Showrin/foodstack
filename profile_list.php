<?php

	// session_start();

	// $user_id = $_SESSION['user_id'];

	// $search_text = $_GET['search_text'];

	// $connection = mysqli_connect('localhost', 'root', '', 'foodstack');

	// $people_search_suggestion_query = "SELECT * FROM users WHERE first_name = '$search_text'";

	// $people_suggestion_result = mysqli_query($connection, $people_search_suggestion_query);

	// while ($people = mysqli_fetch_assoc($people_suggestion_result)) {

 //        echo $people['first_name'];
 //    }

	// echo $user_id;

	// echo $search_text;

?>



<?php

	// session_start();

	// $user_id = $_SESSION['user_id'];

	// $search_text = $_GET['search_text'];

	// $connection = mysqli_connect('localhost', 'root', '', 'foodstack');

	// $menu_search_suggestion_query = "SELECT * FROM menues WHERE menu_name = '$search_text'";

	// $menu_suggestion_result = mysqli_query($connection, $menu_search_suggestion_query);

	// while ($menu = mysqli_fetch_assoc($menu_suggestion_result)) {

	// 	echo $menu['menu_name']; 
 //    }

	// echo $user_id;

	// echo $search_text;

?>




<?php

	// session_start();

	// $user_id = $_SESSION['user_id'];

	// $search_text = $_GET['search_text'];

	// $connection = mysqli_connect('localhost', 'root', '', 'foodstack');

	// $restaurant_search_suggestion_query = "SELECT * FROM restaurants WHERE restaurant_name = '$search_text'";

	// $restaurant_suggestion_result = mysqli_query($connection, $restaurant_search_suggestion_query);

	// while ($restaurant = mysqli_fetch_assoc($restaurant_suggestion_result)) {

 //        echo $restaurant['restaurant_name'];
 //    }

	// echo $user_id;

	// echo $search_text;

?>







<?php

	session_start();

	if (!$user_id = $_SESSION['user_id']) {
		
		header("Location:login.php");
	}


	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');
		
	$search_query = "SELECT * FROM users WHERE user_id = '$user_id'";
		
	$result = mysqli_query($connection, $search_query);

	$row = mysqli_fetch_assoc($result);


	$name = $row['first_name'] . " " . $row['last_name'];
	$pro_pic = $row['pro_pic'];
	$city = $row['city'];


	//=============== Review Posting ======================

	// echo date("d M Y");

	if (isset($_POST['post'])) {

		$restaurant_name = $_POST['restaurant'];
		$menu_name = $_POST['menu'];
		$city = $_POST['city'];
		$rating = $_POST['rating'];
		$opinion = $_POST['opinion'];
		$date = date("d M Y");

		$restaurant_availability_checking_query = "SELECT * FROM restaurants WHERE restaurant_name = '$restaurant_name' AND city = '$city'";

		$available_restaurarant = mysqli_query($connection, $restaurant_availability_checking_query);

		if (mysqli_num_rows($available_restaurarant)) {

			$restaurant_info = mysqli_fetch_assoc($available_restaurarant);

			$this_restaurant_id = $restaurant_info['restaurant_id'];

			$menu_availability_checking_query = "SELECT * FROM menues WHERE menu_name = '$menu_name' AND restaurant_id = '$this_restaurant_id'";

			$available_menu = mysqli_query($connection, $menu_availability_checking_query);

			if (mysqli_num_rows($available_menu)) {

				$menu_info = mysqli_fetch_assoc($available_menu);

				$this_menu_id = $menu_info['menu_id'];
				$this_menu_rating = $menu_info['average_rating'];

				$final_rating = number_format((($this_menu_rating + $rating)/2), 2);

				$menu_rating_update_query = "UPDATE menues SET average_rating = '$final_rating' WHERE menu_id = '$this_menu_id'";

				mysqli_query($connection, $menu_rating_update_query);

				$post_insert_query = "INSERT INTO posts VALUES ('', '$user_id', '$this_restaurant_id', '$this_menu_id', '$date', '$rating', '$opinion', '', '', '')";

				mysqli_query($connection, $post_insert_query);

				$post_id_select_query = "SELECT * FROM posts WHERE (post_giver_id = '$user_id' AND restaurant_id = '$this_restaurant_id' AND menu_id = '$this_menu_id' AND date = '$date')";

				$selected_post = mysqli_query($connection, $post_id_select_query);

				$this_post = mysqli_fetch_assoc($selected_post);

				$this_post_id = $this_post['post_id'];


				// --------------- Uploading Image File to destination folder ------------

				$image_name = $_FILES['menu_pic']['name'];

				// ------------ Getting file extention -------------
				$extention = substr(strrchr(basename($image_name),'.'),1);
				// ------------ Getting file extention -------------

				$menu_pic_name = $this_post_id . "." . $extention ;
				$target = "images/posts/" . $menu_pic_name; // Renaming the image with post_id

				move_uploaded_file($_FILES['menu_pic']['tmp_name'], $target);

				$post_pic_update_query = "UPDATE posts SET post_pic = '$menu_pic_name' WHERE post_id = '$this_post_id'";

				mysqli_query($connection, $post_pic_update_query);

			} else {

				$menu_insert_query = "INSERT INTO menues VALUES ('', '$menu_name', '$rating', '$this_restaurant_id', '', '')";

				mysqli_query($connection, $menu_insert_query);

				$menu_id_select_query = "SELECT * FROM menues WHERE menu_name = '$menu_name' AND restaurant_id = '$this_restaurant_id'";

				$this_menu = mysqli_query($connection, $menu_id_select_query);

				$menu_info = mysqli_fetch_assoc($this_menu);

				$this_menu_id = $menu_info['menu_id'];


				$post_insert_query = "INSERT INTO posts VALUES ('', '$user_id', '$this_restaurant_id', '$this_menu_id', '$date', '$rating', '$opinion', '', '', '')";

				mysqli_query($connection, $post_insert_query);

				$post_id_select_query = "SELECT * FROM posts WHERE (post_giver_id = '$user_id' AND restaurant_id = '$this_restaurant_id' AND menu_id = '$this_menu_id' AND date = '$date')";

				$selected_post = mysqli_query($connection, $post_id_select_query);

				$this_post = mysqli_fetch_assoc($selected_post);

				$this_post_id = $this_post['post_id'];


				// --------------- Uploading Image File to destination folder ------------

				$image_name = $_FILES['menu_pic']['name'];

				// ------------ Getting file extention -------------
				$extention = substr(strrchr(basename($image_name),'.'),1);
				// ------------ Getting file extention -------------

				$post_pic_name = $this_post_id . "." . $extention ;
				$menu_pic_name = $this_menu_id . "." . $extention ;
				$post_target = "images/posts/" . $post_pic_name; // Renaming the image with post_id

				move_uploaded_file($_FILES['menu_pic']['tmp_name'], $post_target);

				// ====== Copy post pic to menu pic ==========
				$post_pic = "images/posts/" . $post_pic_name;
				$menu_pic = "images/menues/" . $menu_pic_name;

				copy($post_pic, $menu_pic);


				$post_pic_update_query = "UPDATE posts SET post_pic = '$post_pic_name' WHERE post_id = '$this_post_id'";

				mysqli_query($connection, $post_pic_update_query);

				$menu_pic_update_query = "UPDATE menues SET menu_pic = '$menu_pic_name' WHERE menu_id = '$this_menu_id'";

				mysqli_query($connection, $menu_pic_update_query);
			}

		} else {

			$new_restaurant_insert_query = "INSERT INTO restaurants VALUES ('', '$restaurant_name', '$city', 'unknown.jpg')";

			mysqli_query($connection, $new_restaurant_insert_query);

			$select_new_restaurant_id_query = "SELECT * FROM restaurants WHERE restaurant_name = '$restaurant_name' AND city = '$city'";

			$selection_result = mysqli_query($connection, $select_new_restaurant_id_query);

			$restaurant_info = mysqli_fetch_assoc($selection_result);

			$this_restaurant_id = $restaurant_info['restaurant_id'];

			$menu_insert_query = "INSERT INTO menues VALUES ('', '$menu_name', '$rating', '$this_restaurant_id', '', '')";

			mysqli_query($connection, $menu_insert_query);


			$menu_id_select_query = "SELECT * FROM menues WHERE menu_name = '$menu_name' AND restaurant_id = '$this_restaurant_id'";

			$this_menu = mysqli_query($connection, $menu_id_select_query);

			$menu_info = mysqli_fetch_assoc($this_menu);

			$this_menu_id = $menu_info['menu_id'];


			$post_insert_query = "INSERT INTO posts VALUES ('', '$user_id', '$this_restaurant_id', '$this_menu_id', '$date', '$rating', '$opinion', '', '', '')";

			mysqli_query($connection, $post_insert_query);

			$post_id_select_query = "SELECT * FROM posts WHERE (post_giver_id = '$user_id' AND restaurant_id = '$this_restaurant_id' AND menu_id = '$this_menu_id' AND date = '$date')";

			$selected_post = mysqli_query($connection, $post_id_select_query);

			$this_post = mysqli_fetch_assoc($selected_post);

			$this_post_id = $this_post['post_id'];


			// --------------- Uploading Image File to destination folder ------------

			$image_name = $_FILES['menu_pic']['name'];

			// ------------ Getting file extention -------------
			$extention = substr(strrchr(basename($image_name),'.'),1);
			// ------------ Getting file extention -------------

			$post_pic_name = $this_post_id . "." . $extention ;
			$menu_pic_name = $this_menu_id . "." . $extention ;
			$post_target = "images/posts/" . $post_pic_name; // Renaming the image with post_id

			move_uploaded_file($_FILES['menu_pic']['tmp_name'], $post_target);

			// ====== Copy post pic to menu pic ==========
			$post_pic = "images/posts/" . $post_pic_name;
			$menu_pic = "images/menues/" . $menu_pic_name;

			copy($post_pic, $menu_pic);


			$post_pic_update_query = "UPDATE posts SET post_pic = '$post_pic_name' WHERE post_id = '$this_post_id'";

			mysqli_query($connection, $post_pic_update_query);

			$menu_pic_update_query = "UPDATE menues SET menu_pic = '$menu_pic_name' WHERE menu_id = '$this_menu_id'";

			mysqli_query($connection, $menu_pic_update_query);


		}

	}


	//=============== Review Posting ======================



	// ================= Changing Password ====================

	if (isset($_POST['change_password'])) {

		$new_password = $_POST['newPassword'];
		$new_password = md5($new_password);
		$new_password = sha1($new_password);

		$password_update_query = "UPDATE users SET password = '$new_password' WHERE user_id = '$user_id'";

		mysqli_query($connection, $password_update_query);
	}



	// ================= Changing info ====================

	if (isset($_POST['change_info'])) {

		$new_first_name = $_POST['f_name'];
		$new_last_name = $_POST['l_name'];
		$new_city = $_POST['city'];
		$new_birth_date = $_POST['birth_date'];

		$info_update_query = "UPDATE users SET first_name = '$new_first_name', last_name = '$new_last_name', city = '$new_city', birth_date = '$new_birth_date' WHERE user_id = '$user_id'";

		mysqli_query($connection, $info_update_query);

		header("location:index.php");
	}





?>














<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Foodstack - A world of food lovers </title>
	<link rel="shortcut icon" href="images/favicon.ico" type=image/x-icon>
	<link rel="stylesheet" href="css/material.min.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/web-fonts-with-css/css/fontawesome-all.min.css">

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>

<body id="index-body">

<!-- ####### Side Navbar Starts ######### -->
	<div id="side-nav-bar">
		
		<div id="logo-holder">

			<a href="index.php"> <img src="images/logo.png"> </a>
				
		</div>

		<div class="activity-holder" style="margin-top: 20px">

			<a href="index.php"> <i id="tales-of-foodies" class="far fa-edit"></i> </a>

			<div class="mdl-tooltip mdl-tooltip--right" data-mdl-for="tales-of-foodies">
			Tales of Foodies
			</div>
				
		</div>

		<div class="activity-holder">

			<a href="restaurant_list.php"> <i id="restaurants" class="fas fa-utensils"></i> </a>

			<div class="mdl-tooltip mdl-tooltip--right" data-mdl-for="restaurants">
			Restaurants
			</div>
				
		</div>

		<div class="activity-holder">

			<a href="menu_list.php"> <i id="menues" class="fas fa-list"></i> </a>

			<div class="mdl-tooltip mdl-tooltip--right" data-mdl-for="menues">
			Discover Awesome Foods
			</div>
				
		</div>

		<div class="activity-holder">

			<a href="profile_list.php"> <i id="find_friend" class="fas fa-search"></i> </a>

			<div class="mdl-tooltip mdl-tooltip--right" data-mdl-for="find_friend">
			Find Your Friends
			</div>
				
		</div>

		<div class="activity-holder">

			<a href="profile.php?profile_owner_id=<?php echo $user_id; ?>"> <i id="profile" class="fas fa-user-circle"></i> </a>

			<div class="mdl-tooltip mdl-tooltip--right" data-mdl-for="profile">
			Your Account
			</div>
				
		</div>

	</div>


<!-- ####### Side Navbar Ends ######### -->


<!-- ####### Top Nav Bar Starts ######### -->	
	<div id="top-nav-bar">
		
		<div class="row">
			
			<form action="top_search.php" method="post">
				<div class="input-field col l4 m4 s4" style="background-color: #494c62;">
				
					<input type="text" name="search" placeholder="Search here food, restaurants or people...." required id="autocomplete-input" class="autocomplete" autocomplete="off">

				</div>

				<div class="col l1 m1 s1" style="background-color: #494c62;">

					<button class="btn" type="submit" name="top_search"> <i class="fas fa-search"></i> 
					</button>
					
				</div>
			</form>

			<div class="col l4 m4 s4 offset-l3 offset-m3 offset-s3 middle-align">



<!-- ============= Friend Request Box Starts ============= -->

				<div id="friend-request-container-box">


					<button id="friend-request-btn" class="mdl-button mdl-js-button mdl-button--icon">
						<i class="fas fa-user-friends"></i>
					</button>
					
					
					
					<div id="friend-request-explorer" class="friend-request-box-holder">
						
						<div class="friend-request-box">

							<div style="width: 400px; height: 10px;">
								
							</div>

							<!-- ====== Php codes for friend request controling ======= -->
								<?php

									$friend_requests_select_query = "SELECT * FROM friend_requests WHERE getter_id = '$user_id'";

									$friend_requests_list = mysqli_query($connection, $friend_requests_select_query);

									if (mysqli_num_rows($friend_requests_list)) {

										while ($request = mysqli_fetch_assoc($friend_requests_list)) {

											$sender_id = $request['sender_id'];

											$sender_info_select_query = "SELECT * FROM users WHERE user_id = '$sender_id'";

											$sender_info_result = mysqli_query($connection, $sender_info_select_query);

											$sender_info = mysqli_fetch_assoc($sender_info_result);

											?>

											<div id="friend-request-<?php echo $sender_info['user_id']; ?>" class="friend-request">
								
												<div class="pic">

													<img id="id-pic" src="images/dp/<?php echo $sender_info['pro_pic']; ?>">
													
												</div>

												<div class="friend-request-text">
									
													<p id="friend-request-text-paragraph">

														<a href="profile.php?profile_owner_id= <?php echo $sender_info['user_id']; ?>">

															<b id="bolded-name">
																<?php echo $sender_info['first_name'] . " " . $sender_info['last_name']; ?>
															</b>

														</a> <br>
															
															<?php 

																if ($sender_info['city'] == "dha") {
																	
																	echo "Dhaka";
																}else if ($sender_info['city'] == "chi") {

																	echo "Chittagong";
																}else if ($sender_info['city'] == "syl") {

																	echo "Sylhet";
																}else if ($sender_info['city'] == "bar") {

																	echo "Barisal";
																}else if ($sender_info['city'] == "raj") {

																	echo "Rajshahi";
																}else if ($sender_info['city'] == "ran") {

																	echo "Rangpur";
																} else {

																	echo "Khulna";
																}


															?>
													</p>

												</div>

												<div class="action">
													
													<button id="accept-btn" class="waves-effect waves-light btn" onclick="acceptFriendRequest(<?php echo $sender_info['user_id']; ?>)">
														
														<img id="symbolic-icon" src="images/check.svg">

													</button>

													<button id="cancel-btn" class="waves-effect waves-light btn" onclick="deleteFriendRequest(<?php echo $sender_info['user_id']; ?>)">
														
														<img id="symbolic-icon" src="images/cancel.svg">

													</button>

												</div>

												<div class="divider-line">
													<hr id="line">

													<img id="badge" src="images/clock.svg">

													<p id="badge-text">
														<?php echo $request['date']; ?>
													</p>
												</div>

											</div>		
														

											<?php

										}
									} else {

										?>

										<div style="display: flex; height: inherit;">

											<div style="margin: auto;">
												
												You have no panding requests

											</div>
											
										</div>	

										<?php
									}

								?>

							</div>


						<div class="notification-footer">

							<button id="footer-btn" class="waves-effect waves-light btn" onclick="deleteAllFriendRequest()">Delete All</button>

						</div>

				</div>	
							
			</div>

<!-- ============= Friend Request Box Ends ============= -->


<!-- ============= Notification Box Starts ============= -->
				<div id="container-box">

					<button id="notification-btn" class="mdl-button mdl-js-button mdl-button--icon"><i class="fas fa-bell"></i></button>
					
					<div id="notification-explorer" class="notification-box-holder">
						
						<div class="notification-box">

							<div style="width: 400px; height: 10px; ">
								
							</div>


							<!-- ====== Php codes for Notification controling ======= -->
								<?php

									$notification_select_query = "SELECT * FROM notifications WHERE getter_id = '$user_id'";

									$notification_list = mysqli_query($connection, $notification_select_query);

									if (mysqli_num_rows($notification_list)) {

										while ($notification = mysqli_fetch_assoc($notification_list)) {

											$sender_id = $notification['sender_id'];

											$sender_info_select_query = "SELECT * FROM users WHERE user_id = '$sender_id'";

											$sender_info_result = mysqli_query($connection, $sender_info_select_query);

											$sender_info = mysqli_fetch_assoc($sender_info_result);

											if ($notification['type'] == "friend") {

												?>

												<a href="profile.php?profile_owner_id=<?php echo $sender_info['user_id']; ?>">

													<div class="notification">
									
														<div class="pic">

															<img id="id-pic" src="images/dp/<?php echo $sender_info['pro_pic']; ?>">
															
														</div>

														<div class="notification-text">
															
															<p id="notification-text-paragraph">
																<b id="bolded-name">
																	<?php echo $sender_info['first_name']. " " . $sender_info['last_name']; ?>
																	
																</b> <br> accepted your friend request
															</p>

														</div>

														<div class="symbol">
															
															<img id="symbolic-icon" src="images/follow.svg">

														</div>

														<div class="divider-line">
															<hr id="line">

															<img id="clock" src="images/clock.svg">

															<p id="time-text">
																<?php echo $notification['date']; ?>
															</p>
														</div>

													</div>

												</a>

												<?php
												
											} else if ($notification['type'] == "love") {

												?>

												<a href="post_detail.php?post_id=<?php echo $notification['post_id']; ?>">

													<div class="notification">
									
														<div class="pic">

															<img id="id-pic" src="images/dp/<?php echo $sender_info['pro_pic']; ?>">
															
														</div>

														<div class="notification-text">
															
															<p id="notification-text-paragraph">
																<b id="bolded-name">
																	<?php echo $sender_info['first_name']. " " . $sender_info['last_name']; ?>
																	
																</b> <br> loved your post
															</p>

														</div>

														<div class="symbol">
															
															<img id="symbolic-icon" src="images/love.svg">

														</div>

														<div class="divider-line">
															<hr id="line">

															<img id="clock" src="images/clock.svg">

															<p id="time-text">
																<?php echo $notification['date']; ?>
															</p>
														</div>

													</div>

												</a>
												
												<?php

											} 
										}
									} else {

										?>

										<div style="display: flex; height: inherit;">

											<div style="margin: auto;">
												
												You have no notification

											</div>
											
										</div>	

										<?php
									}

									?>

								</div>

							

						<div class="notification-footer">

							<button id="footer-btn" class="waves-effect waves-light btn" onclick="deleteAllNotifications()">Delete All</button>

						</div>

					</div>

				</div>


				<!-- ============= Pro-pic and Name Show ==================== -->
				<a href="profile.php?profile_owner_id=<?php echo $user_id; ?>"> <img id="pro-pic" src="images/dp/<?php echo $pro_pic; ?>"> </a>

				<a href="profile.php?profile_owner_id=<?php echo $user_id; ?>"><p id="id-name"><b> <?php echo $name; ?> </b></p></a>
				<!-- ============= Pro-pic and Name Show ==================== -->



				<button id="more-option-btn" class="mdl-button mdl-js-button mdl-button--icon">
					<i class="fas fa-angle-down"></i>
				</button>

				<ul id="more-option-list" class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
				    for="more-option-btn">
					<a href="#change-info" class="modal-trigger"><li class="mdl-menu__item"> <span> <i class="fas fa-cog"></i> </span> General Settings </li></a>
					<a href="#change-password" class="modal-trigger"><li class="mdl-menu__item"> <span> <i class="fas fa-lock"></i> </span> Security Settings </li></a>
					<a href="#"><li class="mdl-menu__item"> <span> <i class="fas fa-question"></i> </span> Foodstack Help </li></a>
					<a href="logout.php"><li class="mdl-menu__item"> <span> <i class="fas fa-power-off"></i> </span> Logout </li></a>
				</ul>
				
			</div>

			

		</div>

	</div>


<!-- ####### Top Nav Bar Ends ######### -->





<!-- ===== Change Password Modal Starts ========= -->
  <div id="change-password" class="modal">

    <form action="index.php" method="post">
    	
		<div class="modal-content">

	      <h4>Change Password</h4>
	      
		
			<div class="row" style="margin-top: 40px;"> 

				<div class="col l10 m10 s10 offset-l1 offset-m1">

					<div class="input-field">
						<i class="material-icons prefix">lock</i>
						<input id="current-password" type="password" required name="currentPassword" autocomplete="off">
	          			<label for="current-password">Current Password</label>
					</div>

					<div id="current-password-error" class="error error-hide">
						<i class="material-icons prefix">error</i>
						<span>Password must contain at least 8 characters, one upper case letter, one lower case letter, and one digit</span>
					</div>

					<div id="password-matching" class="error error-hide">
						<i class="material-icons prefix">error</i>
						<span id="password-matching-text"></span>
					</div>
					
				</div>

				<div class="col l10 m10 s10 offset-l1 offset-m1">

					<div class="input-field">
						<i class="material-icons prefix">lock</i>
						<input id="new-password" type="password" required name="newPassword" autocomplete="off">
	          			<label for="new-password">New Password</label>
					</div>

					<div id="new-password-error" class="error error-hide">
						<i class="material-icons prefix">error</i>
						<span>Password must contain at least 8 characters, one upper case letter, one lower case letter, and one digit</span>
					</div>
					
				</div>
				
			</div>

	    </div>

	    <div class="modal-footer">
	      <button id="change-password-btn" type="submit" name="change_password" class="waves-effect waves-orange btn-flat">Change</button>
	    </div>

    </form>

  </div>

<!-- ===== Change Password Modal Ends ========= -->


<!-- ===== Change Info Modal Starts ========= -->
  <div id="change-info" class="modal">

    <form action="index.php" method="post">
    	
		<div class="modal-content">

	      <h4>Change Info</h4>
	      
		

		<div class="row" style="margin-top: 5%;">

			<div class="col l5 m5 s5 offset-l1 offset-m1">

				<div class="input-field">
					<i class="material-icons prefix">create</i>
					<input type="text" id="f_name" required name="f_name" autocomplete="off" value="<?php echo $row['first_name']; ?>">
					<label for="f_name">First Name</label>
				</div>
				
			</div>

			<div class="col l5 m5 s5">

				<div class="input-field">
					<i class="material-icons prefix">create</i>
					<input type="text" id="l_name" required name="l_name" autocomplete="off" value="<?php echo $row['last_name']; ?>">
					<label for="l_name">Last Name</label>
				</div>
				
			</div>
			
		</div>

		<div class="row">

			<div class="col l5 m5 s5 offset-l1 offset-m1">

				<div class="input-field">
					<i class="material-icons prefix">edit_location</i>
					<input type="text" id="country" class="autocomplete" value="Bangladesh" required name="country" autocomplete="off" disabled="">
					<label for="country">Country</label>
				</div>
				
			</div>

			<div class="col l5 m5 s5">

				<div class="input-field col s12" style="padding: 0;">
					<i class="material-icons prefix">my_location</i>
					<select name="city" autocomplete="off">
						<option value="dha">Dhaka</option>
						<option value="chi">Chittagong</option>
						<option value="raj">Rajshahi</option>
						<option value="khu">Khulna</option>
						<option value="bar">Barisal</option>
						<option value="ran">Rangpur</option>
						<option value="syl">Sylhet</option>
					</select>
					<label style="left: 0px;">City</label>
				</div>
				
			</div>
			
		</div>

		<div class="row">

			<div class="col l10 m10 s10 offset-l1 offset-m1">

				<div class="input-field" id="only-date">
					<i class="material-icons prefix">insert_invitation</i>
					<input type="text" id="date" class="datepicker" required name="birth_date" autocomplete="off" value="<?php echo $row['birth_date']; ?>">
					<label for="date">Date of Birth</label>
				</div>
				
			</div>
			
		</div>
			

	    </div>

	    <div class="modal-footer">
	      <button id="change-info-btn" type="submit" name="change_info" class="waves-effect waves-orange btn-flat">Change</button>
	    </div>

    </form>

  </div>

<!-- ===== Change Info Modal Ends ========= -->



<?php

	if (isset($_GET['search_text'])) {

		$search_text = $_GET['search_text'];

		$profile_select_query = "SELECT * FROM users WHERE first_name LIKE '%$search_text%'";

		$selected_profile = mysqli_query($connection, $profile_select_query);
	} else {

		$profile_select_query = "SELECT * FROM users WHERE 1";

		$selected_profile = mysqli_query($connection, $profile_select_query);


	}


	
          ?>



<!-- ####### Main Section Starts ######### -->

	<div id="main-section-holder">		

		<?php 

			while ($profile = mysqli_fetch_assoc($selected_profile)) {
				
				?>

<div class="row" style="width: 85%; margin-top: 3%">
		<div class="col l4 m4">
				

						<div class="card">
						    <div class="card-image waves-effect waves-block waves-light">
						      <img class="activator" src="images/dp/<?php echo $profile['pro_pic']; ?>">
						    </div>
						    <div class="card-content">
						      <span class="card-title activator grey-text text-darken-4"><?php echo $profile['first_name']." ". $profile['last_name']; ?><i class="material-icons right">more_vert</i></span>
						      <p>
						      	
									<?php


										   if ($profile['city'] == "dha") {
												
												echo "Dhaka";
											}else if ($profile['city'] == "chi") {

												echo "Chittagong";
											}else if ($profile['city'] == "syl") {

												echo "Sylhet";
											}else if ($profile['city'] == "bar") {

												echo "Barisal";
											}else if ($profile['city'] == "raj") {

												echo "Rajshahi";
											}else if ($profile['city'] == "ran") {

												echo "Rangpur";
											} else {

												echo "Khulna";
											}


									 ?>


						      </p>
						    </div>
						    <div class="card-reveal">
						      <span class="card-title grey-text text-darken-4"><?php echo $profile['first_name']." ". $profile['last_name']; ?><i class="material-icons right">close</i></span> <br><br>


						          	<b style="font-size: 17px"> City: </b> 

						          	<?php 

						          		if ($profile['city'] == "dha") {
																	
												echo "Dhaka";
											}else if ($profile['city'] == "chi") {

												echo "Chittagong";
											}else if ($profile['city'] == "syl") {

												echo "Sylhet";
											}else if ($profile['city'] == "bar") {

												echo "Barisal";
											}else if ($profile['city'] == "raj") {

												echo "Rajshahi";
											}else if ($profile['city'] == "ran") {

												echo "Rangpur";
											} else {

												echo "Khulna";
											}


						          	?> <br><br>

						          	<?php

						      		$total_post = 0;

						      		$profile_owner_id = $profile['user_id'];

									$post_select_query = "SELECT * FROM posts WHERE post_giver_id = '$profile_owner_id'";

									$selected_post = mysqli_query($connection, $post_select_query);

									while ($row = mysqli_fetch_assoc($selected_post)) {
										
										$total_post++;
									}

								?>

						          	<b style="font-size: 17px"> Birth Date: </b> <?php echo $profile['birth_date']; ?> <br><br>

						          	<b style="font-size: 17px"> Total Post: </b> <?php echo $total_post; ?>

								
						    </div>
						  </div>


				
						</div>

			<?php

				if (!$profile = mysqli_fetch_assoc($selected_profile)) {
					
					break;
				}

			?>

					<div class="col l4 m4">
				

						<div class="card">
						    <div class="card-image waves-effect waves-block waves-light">
						      <img class="activator" src="images/dp/<?php echo $profile['pro_pic']; ?>">
						    </div>
						    <div class="card-content">
						      <span class="card-title activator grey-text text-darken-4"><?php echo $profile['first_name']." ". $profile['last_name']; ?><i class="material-icons right">more_vert</i></span>
						      <p>
						      	
									<?php


										   if ($profile['city'] == "dha") {
												
												echo "Dhaka";
											}else if ($profile['city'] == "chi") {

												echo "Chittagong";
											}else if ($profile['city'] == "syl") {

												echo "Sylhet";
											}else if ($profile['city'] == "bar") {

												echo "Barisal";
											}else if ($profile['city'] == "raj") {

												echo "Rajshahi";
											}else if ($profile['city'] == "ran") {

												echo "Rangpur";
											} else {

												echo "Khulna";
											}


									 ?>


						      </p>
						    </div>
						    <div class="card-reveal">
						      <span class="card-title grey-text text-darken-4"><?php echo $profile['first_name']." ". $profile['last_name']; ?><i class="material-icons right">close</i></span> <br><br>


						          	<b style="font-size: 17px"> City: </b> 

						          	<?php 

						          		if ($profile['city'] == "dha") {
																	
												echo "Dhaka";
											}else if ($profile['city'] == "chi") {

												echo "Chittagong";
											}else if ($profile['city'] == "syl") {

												echo "Sylhet";
											}else if ($profile['city'] == "bar") {

												echo "Barisal";
											}else if ($profile['city'] == "raj") {

												echo "Rajshahi";
											}else if ($profile['city'] == "ran") {

												echo "Rangpur";
											} else {

												echo "Khulna";
											}


						          	?> <br><br>

						          	<?php

						      		$total_post = 0;

						      		$profile_owner_id = $profile['user_id'];

									$post_select_query = "SELECT * FROM posts WHERE post_giver_id = '$profile_owner_id'";

									$selected_post = mysqli_query($connection, $post_select_query);

									while ($row = mysqli_fetch_assoc($selected_post)) {
										
										$total_post++;
									}

								?>

						          	<b style="font-size: 17px"> Birth Date: </b> <?php echo $profile['birth_date']; ?> <br><br>

						          	<b style="font-size: 17px"> Total Post: </b> <?php echo $total_post; ?>

								
						    </div>
						  </div>


				
						</div>



			<?php

				if (!$profile = mysqli_fetch_assoc($selected_profile)) {
					
					break;
				}

			?>


				<div class="col l4 m4">
				

						<div class="card">
						    <div class="card-image waves-effect waves-block waves-light">
						      <img class="activator" src="images/dp/<?php echo $profile['pro_pic']; ?>">
						    </div>
						    <div class="card-content">
						      <span class="card-title activator grey-text text-darken-4"><?php echo $profile['first_name']." ". $profile['last_name']; ?><i class="material-icons right">more_vert</i></span>
						      <p>
						      	
									<?php


										   if ($profile['city'] == "dha") {
												
												echo "Dhaka";
											}else if ($profile['city'] == "chi") {

												echo "Chittagong";
											}else if ($profile['city'] == "syl") {

												echo "Sylhet";
											}else if ($profile['city'] == "bar") {

												echo "Barisal";
											}else if ($profile['city'] == "raj") {

												echo "Rajshahi";
											}else if ($profile['city'] == "ran") {

												echo "Rangpur";
											} else {

												echo "Khulna";
											}


									 ?>


						      </p>
						    </div>
						    <div class="card-reveal">
						      <span class="card-title grey-text text-darken-4"><?php echo $profile['first_name']." ". $profile['last_name']; ?><i class="material-icons right">close</i></span> <br><br>


						          	<b style="font-size: 17px"> City: </b> 

						          	<?php 

						          		if ($profile['city'] == "dha") {
																	
												echo "Dhaka";
											}else if ($profile['city'] == "chi") {

												echo "Chittagong";
											}else if ($profile['city'] == "syl") {

												echo "Sylhet";
											}else if ($profile['city'] == "bar") {

												echo "Barisal";
											}else if ($profile['city'] == "raj") {

												echo "Rajshahi";
											}else if ($profile['city'] == "ran") {

												echo "Rangpur";
											} else {

												echo "Khulna";
											}


						          	?> <br><br>

						          	<?php

						      		$total_post = 0;

						      		$profile_owner_id = $profile['user_id'];

									$post_select_query = "SELECT * FROM posts WHERE post_giver_id = '$profile_owner_id'";

									$selected_post = mysqli_query($connection, $post_select_query);

									while ($row = mysqli_fetch_assoc($selected_post)) {
										
										$total_post++;
									}

								?>

						          	<b style="font-size: 17px"> Birth Date: </b> <?php echo $profile['birth_date']; ?> <br><br>

						          	<b style="font-size: 17px"> Total Post: </b> <?php echo $total_post; ?>

								
						    </div>
						  </div>


				
						</div>

				</div>


				<?php
			}


		?>

        
		

<!-- ============= Main Portion Ends ============= -->

	
	
<!-- jQuery is required by Materialize to function -->
<script type="text/javascript" src="js/bin/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="js/bin/materialize.min.js"></script>
<script src="js/material.min.js"></script>
<script type="text/javascript" src="js/notification-box-byShowrin.js"></script>
<script type="text/javascript" src="js/friend-request-box-byShowrin.js"></script>
<script type="text/javascript" src="js/sticky-kit.min.js"></script>

<script type="text/javascript">
	
	$(".sidebar").stick_in_parent({
	    offset_top: 70
	});

	$(document).ready(function(){
    $('.tooltipped').tooltip();
  });

	 $(document).ready(function(){
    $('.modal').modal();
  });

</script>

<script type="text/javascript">
	
	
	$('#opinion').val('');
	M.textareaAutoResize($('#opinion'));

	$(document).ready(function(){
	    $('select').formSelect();
	  });
        


</script>


<!-- =============== Ajax function for sending friend request ================== -->
<script>
		
	function sendFriendRequest(person_id) {
		
		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		} else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
				document.getElementById("add-btn-"+person_id).disabled = true;
			    document.getElementById("add-btn-"+person_id).innerHTML=this.responseText;		
			}
		}

		xmlhttp.open("GET","friend_request_function.php?q="+person_id,true);

		xmlhttp.send();
	}

</script>


<!-- =============== Ajax function for accepting friend request ================== -->
<script>
		
	function acceptFriendRequest(person_id) {
		
		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		} else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
				document.getElementById("friend-request-"+person_id).style.display = 'none';
			    document.getElementById("friend-request-"+person_id).innerHTML=this.responseText;		
			}
		}

		xmlhttp.open("GET","friend_request_accept_function.php?q="+person_id,true);

		xmlhttp.send();
	}

</script>


<!-- =============== Ajax function for deleting friend request ================== -->
<script>
		
	function deleteFriendRequest(person_id) {
		
		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		} else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {
				document.getElementById("friend-request-"+person_id).style.display = 'none';
			    document.getElementById("friend-request-"+person_id).innerHTML=this.responseText;		
			}
		}

		xmlhttp.open("GET","friend_request_delete_function.php?q="+person_id,true);

		xmlhttp.send();
	}

</script>


<!-- =============== Ajax function for deleting all friend request by one click ================== -->
<script>
		
	function deleteAllFriendRequest() {
		
		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		} else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {

				var requests = document.getElementsByClassName("friend-request");

				for(i=0; i<requests.length; i++) {
				    requests[i].style.display = 'none';
				}
			}
		}

		xmlhttp.open("GET","all_friend_request_delete_function.php?",true);

		xmlhttp.send();
	}

</script>


<!-- =============== Ajax function for deleting all friend request by one click ================== -->
<script>
		
	function deleteAllNotifications() {
		
		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		} else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {

				var notifications = document.getElementsByClassName("notification");

				for(i=0; i<notifications.length; i++) {
				    notifications[i].style.display = 'none';
				}
			}
		}

		xmlhttp.open("GET","all_notification_delete_function.php?",true);

		xmlhttp.send();
	}

</script>


<!-- ============== Code for autocomplete suggestion in search bar in top nav starts =================== -->
<?php 

	$people_search_suggestion_query = "SELECT * FROM users WHERE user_id!='$user_id'";

	$people_suggestion_result = mysqli_query($connection, $people_search_suggestion_query);

	$restaurant_search_suggestion_query = "SELECT * FROM restaurants WHERE 1";

	$restaurant_suggestion_result = mysqli_query($connection, $restaurant_search_suggestion_query);

	$menu_search_suggestion_query = "SELECT * FROM menues WHERE 1";

	$menu_suggestion_result = mysqli_query($connection, $menu_search_suggestion_query);

?>

<script type="text/javascript">

	$(document).ready(function(){
    $('input.autocomplete').autocomplete({

      limit: 8,
      data: {
        // "Apple": null,
        // "Microsoft": null,
        // "Google": 'https://placehold.it/250x250',
        // "Nafisa": 'images/dp/17.jpg'

        <?php

        	while ($menu = mysqli_fetch_assoc($menu_suggestion_result)) {

        		?>

        			"<?php echo $menu['menu_name']; ?>" : '<?php echo "images/menues/" . $menu['menu_pic']; ?>',

        		<?php
        	}

        ?>

        <?php

        	while ($people = mysqli_fetch_assoc($people_suggestion_result)) {

        		?>

        			"<?php echo $people['first_name']; ?>" : '<?php echo "images/dp/" . $people['pro_pic']; ?>',

        		<?php
        	}

        ?>

        <?php

        	while ($restaurant = mysqli_fetch_assoc($restaurant_suggestion_result)) {

        		?>

        			"<?php echo $restaurant['restaurant_name']; ?>" : '<?php echo "images/restaurants/" . $restaurant['restaurant_pic']; ?>',

        		<?php
        	}

        ?>
        
      },
    });
});

</script>
<!-- ============== Code for autocomplete suggestion in search bar in top nav ends =================== -->



<!-- ============== Code for Love react giving starts =================== -->
<script type="text/javascript">
	

	function loveFunction(post_id) {
		
		// $("#love"+post_id).attr('src', 'images/post-icons/loved.svg');

		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		} else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {

				if (this.responseText == "0") {

					document.getElementById("love"+post_id).src='images/post-icons/love.svg';
					document.getElementById("modal-love"+post_id).src='images/post-icons/love.svg';

					loveAmount(post_id);

				} else {

					document.getElementById("love"+post_id).src='images/post-icons/loved.svg';
					document.getElementById("modal-love"+post_id).src='images/post-icons/loved.svg';

					loveAmount(post_id);

				}
			}
		}

		xmlhttp.open("GET","love_counting_function.php?q="+post_id,true);

		xmlhttp.send();
	}


	function loveAmount(post_id) {

		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		} else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {

				document.getElementById("love-count"+post_id).innerHTML = this.responseText;
				document.getElementById("modal-love-count"+post_id).innerHTML = this.responseText;
			}
		}

		xmlhttp.open("GET","love_amount_fetch_function.php?q="+post_id,true);

		xmlhttp.send();

	}

</script>
<!-- ============== Code for Love react giving ends =================== -->


<!-- ============== Code for Reort giving starts =================== -->
<script type="text/javascript">
	

	function reportFunction(post_id) {
		
		// $("#love"+post_id).attr('src', 'images/post-icons/loved.svg');

		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		} else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {

				if (this.responseText == "0") {

					document.getElementById("report"+post_id).src='images/post-icons/report.svg';

					document.getElementById("modal-report"+post_id).src='images/post-icons/report.svg';

				} else {

					document.getElementById("report"+post_id).src='images/post-icons/reported.svg';
					document.getElementById("modal-report"+post_id).src='images/post-icons/reported.svg';


				}
			}
		}

		xmlhttp.open("GET","reporting_function.php?q="+post_id,true);

		xmlhttp.send();
	}

</script>
<!-- ============== Code for Report giving ends =================== -->


<!-- ============== Code for Saving starts =================== -->
<script type="text/javascript">
	

	function saveFunction(post_id) {
		
		// $("#love"+post_id).attr('src', 'images/post-icons/loved.svg');

		if (window.XMLHttpRequest) {
			xmlhttp=new XMLHttpRequest();
		} else {
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function() {
			if (this.readyState==4 && this.status==200) {

				if (this.responseText == "0") {

					document.getElementById("save"+post_id).src='images/post-icons/bookmark.svg';
					document.getElementById("modal-save"+post_id).src='images/post-icons/bookmark.svg';

				} else {

					document.getElementById("save"+post_id).src='images/post-icons/saved.svg';
					document.getElementById("modal-save"+post_id).src='images/post-icons/saved.svg';

				}
			}
		}

		xmlhttp.open("GET","saving_function.php?q="+post_id,true);

		xmlhttp.send();
	}

</script>
<!-- ============== Code for Saving ends =================== -->


<!-- ========== Change Password Regex Validation ======== -->
	<script type="text/javascript">
		
		$(function() {

			var regex = {
				currentPassword: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/,
				newPassword: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/,
			};

			var currentPasswordError = 0;
			var newPasswordError = 0;
			var passwordMatched = 1;


			$.each($('#change-password input:not([type="submit"])'), function() {

				$(this).on('keyup', function(){
					if(!regex[$(this).attr('name')].test($(this).val())){
						
						if ($(this).val() != "") {

							if ($(this).attr('name') == "currentPassword") {
								$('#current-password-error').removeClass('error-hide');
								$('#current-password-error').addClass('error-show');
								currentPasswordError = 1;

								$('#password-matching').addClass('error-hide');
								$('#password-matching').removeClass('error-show');
								passwordMatched = 1;

							} else if ($(this).attr('name') == "newPassword") {
								$('#new-password-error').removeClass('error-hide');
								$('#new-password-error').addClass('error-show');
								newPasswordError = 1;
							}

						
						} else {
							if ($(this).attr('name') == "currentPassword") {
								$('#current-password-error').addClass('error-hide');
								$('#current-password-error').removeClass('error-show');
								currentPasswordError = 0;
							} else if ($(this).attr('name') == "newPassword") {
								$('#new-password-error').addClass('error-hide');
								$('#new-password-error').removeClass('error-show');
								newPasswordError = 0;
							}

						}


// ------------------- Disabling Submit Button to avoid wrong submission ------------------

						if (currentPasswordError == 0 && newPasswordError == 0 && passwordMatched == 1) {
							$('#change-password-btn').removeAttr('disabled');
						} else {
							$('#change-password-btn').attr('disabled', 'disabled');
						}
// ------------------- Disabling Submit Button to avoid wrong submission ------------------



					} else {
						if ($(this).attr('name') == "currentPassword") {
							$('#current-password-error').addClass('error-hide');
							$('#current-password-error').removeClass('error-show');
							currentPasswordError = 0;



// =================== Email id availability checking ======================

							if (window.XMLHttpRequest) {
								xmlhttp = new XMLHttpRequest();
							} else {
								xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
							}

							xmlhttp.onreadystatechange=function() {
								if (this.readyState==4 && this.status==200) {
								  
									if (this.responseText == "") {

										$('#password-matching').addClass('error-hide');
										$('#password-matching').removeClass('error-show');
										passwordMatched = 1;

								    } else {

								    	$('#password-matching').removeClass('error-hide');
										$('#password-matching').addClass('error-show');
										passwordMatched = 0;

								  		document.getElementById("password-matching-text").innerHTML=this.responseText;
								    }	
								}


// ------------------- Disabling Submit Button to avoid wrong submission ------------------
							if (currentPasswordError == 0 && newPasswordError == 0 && passwordMatched == 1) {
								$('#change-password-btn').removeAttr('disabled');
							} else {
								$('#change-password-btn').attr('disabled', 'disabled');
							}
// ------------------- Disabling Submit Button to avoid wrong submission ------------------								

							}

							

							xmlhttp.open("GET","current_password_checker.php?q="+$(this).val(),true);

							xmlhttp.send();

							
						

						} else if ($(this).attr('name') == "newPassword") {
							$('#new-password-error').addClass('error-hide');
							$('#new-password-error').removeClass('error-show');
							newPasswordError = 0;


// ------------------- Disabling Submit Button to avoid wrong submission ------------------
							if (currentPasswordError == 0 && newPasswordError == 0 && passwordMatched == 1) {
								$('#change-password-btn').removeAttr('disabled');
							} else {
								$('#change-password-btn').attr('disabled', 'disabled');
							}
// ------------------- Disabling Submit Button to avoid wrong submission ------------------							

						}

					}

									
				});
				
			});
		
		});

	</script>


	<!-- jQuery for activating materialize.css plugins -->
	<script type="text/javascript">
		$(document).ready(function(){
		    $('select').formSelect();
		  });


		$(document).ready(function(){
		    $('.datepicker').datepicker({
		    	format: 'yyyy-mm-dd',
		    	yearRange: 100,
		    	showMonthAfterYear: true,
		    	showDaysInNextAndPreviousMonths: true
		    });
		  });
	</script>	


</body>
</html>