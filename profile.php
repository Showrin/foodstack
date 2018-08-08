<?php

	if (isset($_GET['profile_owner_id'])) {
		
		$profile_owner_id = $_GET['profile_owner_id'];
	}

	session_start();

	$user_id = $_SESSION['user_id'];

	// echo $user_id;

	// echo $profile_owner_id;

	$connection = mysqli_connect('localhost', 'root', '', 'foodstack');
		
	$search_query = "SELECT * FROM users WHERE user_id = '$user_id'";
		
	$result = mysqli_query($connection, $search_query);

	$row = mysqli_fetch_assoc($result);


	$name = $row['first_name'] . " " . $row['last_name'];
	$pro_pic = $row['pro_pic'];
	$city = $row['city'];

		
	$profile_search_query = "SELECT * FROM users WHERE user_id = '$profile_owner_id'";
		
	$result = mysqli_query($connection, $profile_search_query);

	$profile = mysqli_fetch_assoc($result);


	$name = $row['first_name'] . " " . $row['last_name'];
	$pro_pic = $row['pro_pic'];
	$city = $row['city'];


	$profile_name = $profile['first_name'] . " " . $profile['last_name'];
	$profile_owner_pic = $profile['pro_pic'];
	$profile_owner_city = $profile['city'];
	$profile_owner_birthdate = $profile['birth_date'];

	

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

		<div class="row" style="margin-top: 3%; width: 86%; height: 450px; background-color: #fff; border-radius: 10px;">

			<div class="col l12" style=" height: 340px; margin: 0 auto; border-radius: 10px; border-bottom-left-radius: 0px; border-bottom-right-radius: 0px; background: url(images/profile_cover.jpg); background-size: cover; background-position: center center; background-repeat: no-repeat; position: relative;">

				<img class="circle" src="images/dp/<?php echo $profile_owner_pic; ?>" style="height: 50%; border: 5px solid #fff; position: absolute; top: 85%; left: 50%; transform: translate(-50%, -50%);">

				<div style="position: absolute; top: 115%; width: inherit; height: 80px; text-align: center; font-size: 32px; font-weight: 500; color: #252525">
					<b><?php echo $profile_name; ?><b>
				</div>
				
			</div>
			
		</div>	
			
		<div class="row" style="width: 86%">

			<!-- ####### Left Sidebar Starts ######### -->

			<div class="col l4 m4 s4 sidebar" style="padding-left: 0">

				<div class="content-holder">
					
					<div id="weather-holder">

						<div class="row">
						    
						    <div class="col s12 m12 l12">
						      


						      <?php

						      		$total_post = 0;

									$post_select_query = "SELECT * FROM posts WHERE post_giver_id = '$profile_owner_id'";

									$selected_post = mysqli_query($connection, $post_select_query);

									while ($row = mysqli_fetch_assoc($selected_post)) {
										
										$total_post++;
									}

								?>
						     

						<!-- ==== Profile info starts ==== -->
							
							 <div class="card blue-grey darken-1">
						        <div class="card-content white-text">
						          <span class="card-title"><?php echo $profile_name; ?></span>
						          <p> <br>

						          	<b style="font-size: 17px"> City: </b> 

						          	<?php 

						          		if ($profile_owner_city == "dha") {
																	
												echo "Dhaka";
											}else if ($profile_owner_city == "chi") {

												echo "Chittagong";
											}else if ($profile_owner_city == "syl") {

												echo "Sylhet";
											}else if ($profile_owner_city == "bar") {

												echo "Barisal";
											}else if ($profile_owner_city == "raj") {

												echo "Rajshahi";
											}else if ($profile_owner_city == "ran") {

												echo "Rangpur";
											} else {

												echo "Khulna";
											}


						          	?> <br>

						          	<b style="font-size: 17px"> Birth Date: </b> <?php echo $profile_owner_birthdate; ?> <br>

						          	<b style="font-size: 17px"> Total Post: </b> <?php echo $total_post; ?>



						          </p>
						        </div>
						      </div>

							  <!-- ==== Profile info ==== -->
            	



						    </div>
						  </div>
						
					</div>

				</div>
				
			</div>

			<!-- ####### Left Sidebar Ends ######### -->


			<!-- ####### Post Container Starts ######### -->

			<div class="col l8 m8 s8 post-container" style="padding-right: 0">
				

			<!-- -------------------- Post the review Starts ----------------------- -->
				<div id="main-paper" style="width: 94%; margin-right: 0; padding-right: 0">
					

					<?php 

						if (isset($profile_owner_id)) {
							
							if ($user_id == $profile_owner_id) {
								
								?>

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


					<?php
				}
			}

		?>


				</div>

				<!-- -------------------- Post the review Ends ----------------------- -->


<?php

	$post_select_query = "SELECT * FROM posts WHERE post_giver_id = '$profile_owner_id' ORDER BY post_id DESC";

	$selected_post = mysqli_query($connection, $post_select_query);

?>


				<div id="main-paper">

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