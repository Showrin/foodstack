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




<!-- ####### Main Section Starts ######### -->

	<div id="main-section-holder">		
			
		<div class="row">

			<!-- ####### Left Sidebar Starts ######### -->

			<div class="col l3 m3 s3 sidebar">

				<div class="content-holder">
					
					<div id="weather-holder">

						<div class="row">
						    <div class="col s11 m11 l11 offset-s1 offset-m1 offset-l1">
						      
						      <!-- === Weather Card Starts === -->

						      <div id="weather" class="card">
						        <div class="card-image">
						          <img src="images/Rainy_night.png">

						          <span id="tempurature" class="card-title">
						          	30°
						          </span>

						          <span id="day-status" class="card-title">
						          	Sunny
						          </span>

						          <span id="food-carousel-headline" class="card-title">
						          	Food with your mood...
						          </span>

						          <span id="food-carousel-holder" class="card-title">
									
									<div class="slider">
										<div class="slide-track">
											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Khichuri"><img src="images/weather-based-food/khichuri.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Nuggets"><img src="images/weather-based-food/nuggets.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Soup"><img src="images/weather-based-food/soup.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Beef Khichuri"><img src="images/weather-based-food/beef-khichuri.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Pasta"><img src="images/weather-based-food/pasta.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Coffee"><img src="images/weather-based-food/coffee.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Khichuri"><img src="images/weather-based-food/khichuri.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Nuggets"><img src="images/weather-based-food/nuggets.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Soup"><img src="images/weather-based-food/soup.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Beef Khichuri"><img src="images/weather-based-food/beef-khichuri.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Pasta"><img src="images/weather-based-food/pasta.jpg"/></a>
											</div>

											<div class="slide">
												<a class="btn tooltipped" data-position="bottom" data-tooltip="Coffee"><img src="images/weather-based-food/coffee.jpg"/></a>
											</div>

										</div>
						          		
						          	</div>
						          	
						          </span>

						        </div>
						    </div>


						<!-- ==== Foods you can taste starts ==== -->
							
							<div class="card">

							  	<div id="collection-header">
							  		<span>Foods you can taste</span>
							  	</div>
							    
								
								<ul class="collection">

								<?php

				                  $connection = mysqli_connect('localhost', 'root', '', 'foodstack');

				                  $restaurant_select_query = "SELECT * FROM restaurants WHERE city='$city'";

				                  $selected_restaurant = mysqli_query($connection, $restaurant_select_query);

				                  $count = 1;

				                  // ===== This loop is forr making query to sort data rating wise ====== starts =======
				                  $query_OR_control = 1;

				                  $menu_select_query_partial = "SELECT * FROM menues WHERE ";

				                  while ($restaurant = mysqli_fetch_assoc($selected_restaurant)) {

				                  	if ($query_OR_control != 1) {
				                  		
				                  		$menu_select_query_partial = $menu_select_query_partial." OR ";
				                  	}


				                    $restaurant_id = $restaurant['restaurant_id'];

				                    $menu_select_query_partial = $menu_select_query_partial. "restaurant_id='$restaurant_id'";

				                    $query_OR_control++;

				                  }

				                    $menu_select_query = $menu_select_query_partial . " ORDER BY average_rating DESC";

				                    $selected_menu = mysqli_query($connection, $menu_select_query);

				                    // ===== This loop is forr making query to sort data rating wise ====== starts =======
				                    

				                    while ($menu = mysqli_fetch_assoc($selected_menu)) {

				                    	$restaurant_id = $menu['restaurant_id'];

				                    	$restaurant_select_query = "SELECT * FROM restaurants WHERE restaurant_id='$restaurant_id'";

				                  		$selected_restaurant = mysqli_query($connection, $restaurant_select_query);

				                  		$restaurant = mysqli_fetch_assoc($selected_restaurant);

				                      ?>
								<li class="collection-item avatar">
                          
		                          <!-- === Menu-pic showing -->
		                          <img src="images/menues/<?php echo $menu['menu_pic']; ?>" alt="" class="circle">
		                        
		                        <!-- === Menu and restaurant name showing with profilwe link ==== -->
		                          <a href="menu.php?menu_id= <?php echo $menu['menu_id']; ?>">
		                            
		                            <p style="color: #ff7c1a"> <?php echo $menu['menu_name']; ?> </p>
		                           </a>

		                           <a href="restaurant.php?restaurant_id= <?php echo $restaurant['restaurant_id']; ?>">

		                            <span class="title" style="color: #ff7c1a"> 
		                              <?php echo $restaurant['restaurant_name']; ?> 
		                          </span>

		                          </a>

								  <span class="secondary-content" style="color: #ff7c1a"><i class="material-icons" style="margin: .1vw">grade</i>

								  <div>
								  	<?php echo number_format($menu['average_rating'], 2) ; ?>
								  </div>
								  </span>
								</li>

								<?php

				                    $count++;

				                    //---------- For controling the number of people to show -------------
				                    if ($count>5) {
				                      break;
				                    }

				                    }

				                ?>

								</ul>
								        

							  </div>

							  <!-- ==== Foods you can taste ==== -->
            	



						    </div>
						  </div>
						
					</div>

				</div>
				
			</div>

			<!-- ####### Left Sidebar Ends ######### -->


			<!-- ####### Post Container Starts ######### -->

			<div class="col l6 m6 s6 post-container">
				

			<!-- -------------------- Post the review Starts ----------------------- -->
				<div id="main-paper">
					
					<div class="card status">
						<div id="status-header">
							<span>Share your status</span>
						</div>
						<div class="card-content">

							
							<form action="index.php" method="post" enctype="multipart/form-data">

								<div class="row">

									<div class="col l6 m6">

										<div class="input-field">
											<input type="text" id="restaurant" class="autocomplete" required name="restaurant" autocomplete="off">
											<label for="restaurant">Restaurant</label>
										</div>
										
									</div>


									<div class="col l6 m6">

										<div class="input-field">
											<input type="text" id="menu" class="autocomplete" required name="menu" autocomplete="off">
											<label for="menu">Menu</label>
										</div>
										
									</div>
									
								</div>

								<div class="row">

									<div class="col l6 m6">

										<div class="input-field col s12" style="padding: 0;">
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


									<div class="col l6 m6">
										
										<label for="rating">Rating</label>

										<p class="range-field">

									      <input type="range" id="rating" min="2" max="10"  style="background: transparent; outline: none; border: none; margin-top: 14%" name="rating">

									    </p>
										
									</div>
									
								</div>

								<div class="row">

									<div class="col l12 m12">

										<div class="file-field input-field">
											<div id="file-btn" class="btn">
												<span>Image</span>
												<input type="file" accept=".jpg, .jpeg, .gif, .png" required name="menu_pic" autocomplete="off">
											</div>
											<div class="file-path-wrapper">
												<input class="file-path validate" type="text" placeholder="Upload your image" autocomplete="off">
											</div>
										</div>
										
									</div>
									
								</div>
								
								<div class="input-field">
        							<textarea id="opinion" class="materialize-textarea" cols="40" rows="40" name="opinion"></textarea>
        							<label for="opinion">Share your opinion</label>
        						</div>

        						<button id="signup-btn" class="btn waves-effect waves-light" type="submit" name="post">Post
									<i class="material-icons right">send</i>
								</button>

							</form>

						</div>
					</div>  


				</div>

				<!-- -------------------- Post the review Ends ----------------------- -->


<?php

	$post_select_query = "SELECT * FROM posts WHERE 1 ORDER BY loves DESC";

	$selected_post = mysqli_query($connection, $post_select_query);

?>


				<div id="main-paper" style="margin-top: 70px">

<!-- ============= Review Post Starts ============= -->
				
				<?php

						while ($post = mysqli_fetch_assoc($selected_post)) {

							$post_id = $post['post_id'];

							$post_giver_id = $post['post_giver_id'];

							$post_giver_select_query = "SELECT * FROM users WHERE user_id = '$post_giver_id'";

							$selected_post_giver = mysqli_query($connection, $post_giver_select_query);

							$post_giver = mysqli_fetch_assoc($selected_post_giver);

							$post_restaurant_id = $post['restaurant_id'];

							$restaurant_select_query = "SELECT * FROM restaurants WHERE restaurant_id = '$post_restaurant_id'";

							$selected_post_restaurant = mysqli_query($connection, $restaurant_select_query);

							$post_restaurant = mysqli_fetch_assoc($selected_post_restaurant);

							$post_menu_id = $post['menu_id'];

							$menu_select_query = "SELECT * FROM menues WHERE menu_id = '$post_menu_id'";

							$selected_post_menu = mysqli_query($connection, $menu_select_query);

							$post_menu = mysqli_fetch_assoc($selected_post_menu);

							?>

							
						<div class="post-holder">

							<div class="post-header">

								<div class="name-holder">

									<img src="images/dp/<?php echo $post_giver['pro_pic']; ?>">

									<span class="name">
										<a style="color: white;" href="profile.php?profile_owner_id=<?php echo $post_giver['user_id']; ?>">
											<b><?php echo $post_giver['first_name'] . " " . $post_giver['last_name']; ?>
											
										</b> 
										</a><br> 
									
										<a style="color: white;" href="restaurant.php?restaurant_id=<?php echo $post['restaurant_id']; ?>">
											<?php echo $post_restaurant['restaurant_name']; ?>
										</a>

									</span>

								</div>

								<div class="rating-holder">
									<img src="images/post-icons/star.svg">

									<span class="rating"> 
										<b> <?php echo number_format($post['rating'], 2); ?> </b>
									</span>
								</div>
								
							</div>


							<a class="modal-trigger" href="#modal<?php echo $post['post_id']; ?>">
							<div class="post-pic" style="background: url(images/posts/<?php echo $post['post_pic']; ?>); background-position: center center; background-size: cover;">
								
								<svg id="post-upper-edge" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360.258 41.917">
									<path class="a" d="M-4046,424s-358.032,38.508-360.258,41.814c.195.232,360.258,0,360.258,0Z" transform="translate(4406.258 -424)"/>
								</svg>

							</div>
							</a>


							<div class="post-detail">

								<a style="color: #212121" class="modal-trigger" href="#modal<?php echo $post['post_id']; ?>">
								
								<div class="post-text-plus-react">

									<div class="post-text">

										<b>Menu: <?php echo $post_menu['menu_name']; ?></b>
										
									</div>

									<div class="post-react">
										
										<div class="love-icon"><img src="images/love.svg"></div>

										<div id="love-count<?php echo $post_id; ?>" class="love-count">
											<?php echo $post['loves']; ?>
										</div>
										

									</div>
									
								</div>

								</a>

								<?php

									$love_checking_query = "SELECT * from loves WHERE post_id = '$post_id' AND lover_id = '$user_id'";

									$love_checking_result = mysqli_query($connection, $love_checking_query);

									$report_checking_query = "SELECT * from reports WHERE post_id = '$post_id' AND reporter_id = '$user_id'";

									$report_checking_result = mysqli_query($connection, $report_checking_query);

									$save_checking_query = "SELECT * from saved_posts WHERE post_id = '$post_id' AND saver_id = '$user_id'";

									$save_checking_result = mysqli_query($connection, $save_checking_query);

								?>


								<div class="action-icons">
									
									<div class="icon">

										<?php

											if (mysqli_num_rows($love_checking_result)) {

												?>
										
													<img id="love<?php echo $post_id; ?>" src="images/post-icons/loved.svg" onclick="loveFunction(<?php echo $post_id; ?>)">

												<?php 
											
											} else {

												?>
										
													<img id="love<?php echo $post_id; ?>" src="images/post-icons/love.svg" onclick="loveFunction(<?php echo $post_id; ?>)">

												<?php 

											}

										?>

									</div>

									<div class="icon">

										<?php

											if (mysqli_num_rows($report_checking_result)) {

												?>
										
													<img id="report<?php echo $post_id; ?>" src="images/post-icons/reported.svg" onclick="reportFunction(<?php echo $post_id; ?>)">

												<?php 
											
											} else {

												?>
										
													<img id="report<?php echo $post_id; ?>" src="images/post-icons/report.svg" onclick="reportFunction(<?php echo $post_id; ?>)">

												<?php 

											}

										?>
										

									</div>

									<div class="icon">

										<?php

											if (mysqli_num_rows($save_checking_result)) {

												?>
										
													<img id="save<?php echo $post_id; ?>" class="bookmark" src="images/post-icons/saved.svg" onclick="saveFunction(<?php echo $post_id; ?>)">

												<?php 
											
											} else {

												?>
										
													<img id="save<?php echo $post_id; ?>" class="bookmark" src="images/post-icons/bookmark.svg" onclick="saveFunction(<?php echo $post_id; ?>)">

												<?php 

											}

										?>
										
										

									</div>

									<div class="icon-clock">
										<div id="clock">
											<img src="images/post-icons/clock.svg">
										</div>

										<div id="time">
											<?php echo $post['date']; ?>
										</div>
									</div>

									

								</div>
								
							</div>

						</div>

				
						<!-- ========== Modal for Post Starts ================ -->
						  <div id="modal<?php echo $post['post_id']; ?>" class="modal">
						   
						    	<div class="post-header">

									<div class="name-holder">

										<img src="images/dp/<?php echo $post_giver['pro_pic']; ?>">

										<span class="name">
											<a style="color: white;" href="profile.php?profile_owner_id=<?php echo $post_giver['user_id']; ?>">
												<b><?php echo $post_giver['first_name'] . " " . $post_giver['last_name']; ?>
												
											</b> 
											</a><br> 
										
											<a style="color: white;" href="restaurant.php?restaurant_id=<?php echo $post['restaurant_id']; ?>">
												<?php echo $post_restaurant['restaurant_name']; ?>
											</a>

										</span>

									</div>

									<div class="rating-holder">
										<img src="images/post-icons/star.svg">

										<span class="rating"> 
											<b> <?php echo number_format($post['rating'], 2); ?> </b>
										</span>
									</div>
									
								</div>

								<div class="post-pic" style="background: url(images/posts/<?php echo $post['post_pic']; ?>); background-position: center center; background-size: cover;">
									
									<svg id="post-upper-edge" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360.258 41.917">
										<path class="a" d="M-4046,424s-358.032,38.508-360.258,41.814c.195.232,360.258,0,360.258,0Z" transform="translate(4406.258 -424)"/>
									</svg>

								</div>

								<div class="post-detail">
								
								<div class="post-text-plus-react">

									<div class="post-text">

										<b>Menu: <?php echo $post_menu['menu_name']; ?></b> <br><br>
										<p style="font-size: 16px">
											<?php echo $post['opinion']; ?>
										</p>
										
									</div>

									<div class="post-react">
										
										<div class="love-icon"><img src="images/love.svg"></div>

										<div id="modal-love-count<?php echo $post_id; ?>" class="love-count">
											<?php echo $post['loves']; ?>
										</div>
										

									</div>
									
								</div>

								<?php

									$love_checking_query_modal = "SELECT * from loves WHERE post_id = '$post_id' AND lover_id = '$user_id'";

									$love_checking_result_modal = mysqli_query($connection, $love_checking_query_modal);

									$report_checking_query_modal = "SELECT * from reports WHERE post_id = '$post_id' AND reporter_id = '$user_id'";

									$report_checking_result_modal = mysqli_query($connection, $report_checking_query_modal);

									$save_checking_query_modal = "SELECT * from saved_posts WHERE post_id = '$post_id' AND saver_id = '$user_id'";

									$save_checking_result_modal = mysqli_query($connection, $save_checking_query_modal);

								?>


								<div class="action-icons">
									
									<div class="icon">

										<?php

											if (mysqli_num_rows($love_checking_result_modal)) {

												?>
										
													<img id="modal-love<?php echo $post_id; ?>" src="images/post-icons/loved.svg" onclick="loveFunction(<?php echo $post_id; ?>)">

												<?php 
											
											} else {

												?>
										
													<img id="modal-love<?php echo $post_id; ?>" src="images/post-icons/love.svg" onclick="loveFunction(<?php echo $post_id; ?>)">

												<?php 

											}

										?>

									</div>

									<div class="icon">

										<?php

											if (mysqli_num_rows($report_checking_result_modal)) {

												?>
										
													<img id="modal-report<?php echo $post_id; ?>" src="images/post-icons/reported.svg" onclick="reportFunction(<?php echo $post_id; ?>)">

												<?php 
											
											} else {

												?>
										
													<img id="modal-report<?php echo $post_id; ?>" src="images/post-icons/report.svg" onclick="reportFunction(<?php echo $post_id; ?>)">

												<?php 

											}

										?>
										

									</div>

									<div class="icon">

										<?php

											if (mysqli_num_rows($save_checking_result_modal)) {

												?>
										
													<img id="modal-save<?php echo $post_id; ?>" class="bookmark" src="images/post-icons/saved.svg" onclick="saveFunction(<?php echo $post_id; ?>)">

												<?php 
											
											} else {

												?>
										
													<img id="modal-save<?php echo $post_id; ?>" class="bookmark" src="images/post-icons/bookmark.svg" onclick="saveFunction(<?php echo $post_id; ?>)">

												<?php 

											}

										?>
										
										

									</div>

									<div class="icon-clock">
										<div id="clock">
											<img src="images/post-icons/clock.svg">
										</div>

										<div id="time">
											<?php echo $post['date']; ?>
										</div>
									</div>

									

								</div>
								
							</div>

						  </div>
						<!-- ========== Modal for Post Ends ================ -->



							<?php

						}

					?>
					
					

<!-- ============= Review Post Ends ============= -->

				</div>

			</div>

			<!-- ####### Post Container Ends ######### -->


			<!-- ####### Right Sidebar Starts ######### -->

			<div class="col l3 m3 s3 sidebar">

				<div class="content-holder">
					
					<div id="weather-holder">

						<div class="row">
						    <div class="col s11 m11 l11">


							<!-- === Greetings card starts === -->
						      <div id="weather" class="card">
						        <div class="card-image">
						          <img src="images/weatherbg.png">

						          <span id="tempurature" class="card-title">
						          	Hi
						          </span>

						          <span id="day-status" class="card-title">
						          	<?php echo $name; ?>
						          </span>

						          <span class="card-title" style="bottom: 7vw; left: 3.6vw;">
						          	<img src="images/dp/<?php echo $pro_pic; ?>" style="width: 65%; height: auto; border-radius: 50%;">
						          </span>

						          <span id="food-carousel-headline" class="card-title">
						          	Explore your favourite foods within seconds...
						          </span>

						        </div>
						      </div>

						     <!-- === Greetings card ends === -->

								
							<!-- ==== People you may know Starts ==== -->
							
							<div class="card">

							  	<div id="collection-header">
							  		<span>People you may know</span>
							  	</div>
							    
								
								<ul class="collection">

								<!-- ==== Back end codes for Showing People === -->
								<?php

									$connection = mysqli_connect('localhost', 'root', '', 'foodstack');

									$people_select_query = "SELECT * FROM users WHERE city='$city'";

									$selected_people = mysqli_query($connection, $people_select_query);

									$count = 1;

									while ($person = mysqli_fetch_assoc($selected_people)) {

										$person_id = $person['user_id'];

										$already_friend_checking_query = "SELECT * FROM friend_list 
											WHERE 
											(one_user_id = '$person_id' AND another_user_id = '$user_id') 
											OR (one_user_id = '$user_id' AND another_user_id = '$person_id')";

										$already_requested_checking_query = "SELECT * FROM friend_requests 
											WHERE 
											(getter_id = '$person_id' AND sender_id = '$user_id')";

										$checking_friend_result = mysqli_query($connection, $already_friend_checking_query);

										$checking_request_result = mysqli_query($connection, $already_requested_checking_query);

										if (!mysqli_num_rows($checking_friend_result) && !mysqli_num_rows($checking_request_result) && $person_id != $user_id) {

											?>

											<li class="collection-item avatar">
											  	
											  	<!-- === Pro-pic showing -->
											  	<img src="images/dp/<?php echo $person['pro_pic']; ?>" alt="" class="circle">
												
												<!-- === First and last name showing with profilwe link ==== -->
											  	<a href="profile.php?profile_owner_id= <?php echo $person['user_id']; ?>">
											  		
											  		<p style="color: #ff7c1a"> <?php echo $person['first_name']; ?> </p>

												  	<span class="title" style="color: #ff7c1a"> 
												  		<?php echo $person['last_name']; ?> 
													</span>

											  	</a>

												<!-- === Add Friend Button === -->
											  	<span class="secondary-content">
											  		<button id="add-btn-<?php echo $person_id; ?>" class="btn waves-effect waves-light add-btn" type="submit" onclick="sendFriendRequest(<?php echo $person_id; ?>)" >Add
													</button>
											  	</span>
											</li>

											<?php
										}

										$count++;

										//---------- For controling the number of people to show -------------
										if ($count>5) {
											break;
										}
									}

								?>
								
								</ul>
								        

							  </div>

							  <!-- ==== People you may know Ends ==== -->



						    </div>
						  </div>
						
					</div>

				</div>
				
			</div>

			<!-- ####### Right Sidebar Ends ######### -->
			
		</div>
		
	</div>

<!-- ============= Main Portion Ends ============= -->

	
	
<!-- jQuery is required by Materialize to function -->
<script type="text/javascript" src="js/bin/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="js/bin/materialize.min.js"></script>
<script src="js/material.min.js"></script>
<script type="text/javascript" src="js/notification-box-byShowrin.js"></script>
<script type="text/javascript" src="js/friend-request-box-byShowrin.js"></script>
<script type="text/javascript" src="js/sticky-kit.min.js"></script>]

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