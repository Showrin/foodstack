<!-- ============== PHP ============== -->

<?php 

	session_start();

	if (isset($_POST['action'])) {
		
		$f_name = $_POST['f_name'];
		$l_name = $_POST['l_name'];
		$email = $_POST['email'];

		$password = $_POST['password'];
		$password = md5($password);
		$password = sha1($password);

		$country = $_POST['country'];
		$city = $_POST['city'];
		$birth_date = $_POST['birth_date'];

		$connection = mysqli_connect('localhost', 'root', '', 'foodstack');

		if ($connection) {

			$insert_query = "INSERT INTO users VALUES('', '$f_name', '$l_name', '$email', '$password', '$country', '$city', '$birth_date', '')";

			mysqli_query($connection, $insert_query);

			$id_search_query = "SELECT user_id FROM users WHERE email = '$email'";

			$result = mysqli_query($connection, $id_search_query);

			$row = mysqli_fetch_assoc($result);

			$user_id = $row['user_id'];


// --------------- Uploading Image File to destination folder ------------

			$image_name = $_FILES['pro_pic']['name'];

			// ------------ Getting file extention -------------
			$extention = substr(strrchr(basename($image_name),'.'),1);
			// ------------ Getting file extention -------------

			$pro_pic_name = $user_id . "." . $extention ;
			$target = "images/dp/" . $pro_pic_name; // Renaming the image with user_id

			move_uploaded_file($_FILES['pro_pic']['tmp_name'], $target);

			$update_pro_pic_name_query = "UPDATE users SET pro_pic = '$pro_pic_name' WHERE user_id = '$user_id'";

			mysqli_query($connection, $update_pro_pic_name_query);



			// ----------- Storing info in sesson variable ----------------
			$_SESSION['user_id'] = $user_id;


			// ------------- Redirecting to Profile ------------------
			header("Location:index.php");

		} else {

			echo "Database can't be reached";
		}
	}

	


?>






<!-- ============ HTML =============== -->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Foodstack - A world of food lovers </title>
	<link rel="shortcut icon" href="images/favicon.ico" type=image/x-icon>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/web-fonts-with-css/css/fontawesome-all.min.css">

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>
<body id="login-body">

	
	<header>

		<div class="row" id="logo-container">

			<div class="col l3 m4 s8 offset-l1 offset-m1 offset-s2">

				<a href="#"> <img src="images/logo_with_name.png"> </a>
				
			</div>
			
		</div>

	</header>


	<form id="signup" action="sign_up.php" method="post" enctype="multipart/form-data">

		<div class="row">

			<div class="col l4 m6 s12 offset-l4 offset-m3">

				<center>
					<a id="fb-btn" class="waves-effect waves-light btn"><i class="fab fa-facebook-f"></i>Facebook</a>
					<a id="google-btn" class="waves-effect waves-light btn"><i class="fab fa-google"></i>Google</a>
				</center>
				
			</div>
			
		</div>

		<div class="row" style="margin-top: 5%;">

			<div class="col l3 m4 s12 offset-l3 offset-m2">

				<div class="input-field">
					<i class="material-icons prefix">create</i>
					<input type="text" id="f_name" class="autocomplete" required name="f_name" autocomplete="off">
					<label for="f_name">First Name</label>
				</div>
				
			</div>

			<div class="col l3 m4 s12">

				<div class="input-field">
					<i class="material-icons prefix">create</i>
					<input type="text" id="l_name" class="autocomplete" required name="l_name" autocomplete="off">
					<label for="l_name">Last Name</label>
				</div>
				
			</div>
			
		</div>

		<div class="row">

			<div class="col l6 m8 s12 offset-l3 offset-m2">

				<div class="input-field">
					<i class="material-icons prefix">person</i>
					<input type="email" id="email" class="autocomplete" required name="email" autocomplete="off">
					<label for="email">Email</label>
				</div>

				<div id="email-error" class="error error-hide">
					<i class="material-icons prefix">error</i>
					<span>Invalid Email Address</span>
				</div>

				<div id="email-availability" class="error error-hide">
					<i class="material-icons prefix">error</i>
					<span id="email-availability-text"></span>
				</div>
				
			</div>
			
		</div>

		<div class="row"> 

			<div class="col l6 m8 s12 offset-l3 offset-m2">

				<div class="input-field">
					<i class="material-icons prefix">lock</i>
					<input id="password" type="password" required name="password" autocomplete="off">
          			<label for="password">Password</label>
				</div>

				<div id="password-error" class="error error-hide">
					<i class="material-icons prefix">error</i>
					<span>Password must contain at least 8 characters, one upper case letter, one lower case letter, and one digit</span>
				</div>
				
			</div>
			
		</div>

		<div class="row">

			<div class="col l3 m4 s12 offset-l3 offset-m2">

				<div class="input-field">
					<i class="material-icons prefix">edit_location</i>
					<input type="text" id="country" class="autocomplete" value="Bangladesh" required name="country" autocomplete="off">
					<label for="country">Country</label>
				</div>
				
			</div>

			<div class="col l3 m4 s12">

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

			<div class="col l6 m8 s12 offset-l3 offset-m2">

				<div class="input-field" id="only-date">
					<i class="material-icons prefix">insert_invitation</i>
					<input type="text" id="date" class="datepicker" required name="birth_date" autocomplete="off">
					<label for="date">Date of Birth</label>
				</div>
				
			</div>
			
		</div>

		<div class="row"> 

			<div class="col l6 m8 s12 offset-l3 offset-m2">

				<div class="file-field input-field">
					<div id="file-btn" class="btn">
						<span>Image</span>
						<input type="file" accept=".jpg, .jpeg, .gif, .png" required name="pro_pic" autocomplete="off">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text" placeholder="Upload your image" autocomplete="off">
					</div>
				</div>
				
			</div>
			
		</div>

		<div class="row">

			<div class="col l4 m6 s12 offset-l4 offset-m3">

				
				<button id="signup-btn" class="btn waves-effect waves-light" type="submit" name="action">Sign Up
					<i class="material-icons right">send</i>
				</button>
				    

				<p style="color:white;" class="center">
					Have an account? Please <a href="login.php"> Login </a>
				</p>
				
			</div>
			
		</div>

	</form>

	
<!-- jQuery is required by Materialize to function -->
	<script type="text/javascript" src="js/bin/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="js/bin/materialize.min.js"></script>

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

<!-- ========== Regex Validation ======== -->
	<script type="text/javascript">
		
		$(function() {

			var regex = {
				email: /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/,
				password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/,
			};

			var emailError = 0;
			var passwordError = 0;
			var emailValidity = 1;


			$.each($('form input:not([type="submit"])'), function() {

				$(this).on('keyup', function(){
					if(!regex[$(this).attr('name')].test($(this).val())){
						
						if ($(this).val() != "") {

							if ($(this).attr('name') == "password") {
								$('#password-error').removeClass('error-hide');
								$('#password-error').addClass('error-show');
								passwordError = 1;
							} else if ($(this).attr('name') == "email") {
								$('#email-error').removeClass('error-hide');
								$('#email-error').addClass('error-show');
								emailError = 1;
							}

						
						} else {
							if ($(this).attr('name') == "password") {
								$('#password-error').addClass('error-hide');
								$('#password-error').removeClass('error-show');
								passwordError = 0;
							} else if ($(this).attr('name') == "email") {
								$('#email-error').addClass('error-hide');
								$('#email-error').removeClass('error-show');
								emailError = 0;
							}

						}


// ------------------- Disabling Submit Button to avoid wrong submission ------------------

						if (emailError == 0 && passwordError == 0 && emailValidity == 1) {
							$('#signup-btn').removeAttr('disabled');
						} else {
							$('#signup-btn').attr('disabled', 'disabled');
						}
// ------------------- Disabling Submit Button to avoid wrong submission ------------------



					} else {
						if ($(this).attr('name') == "password") {
							$('#password-error').addClass('error-hide');
							$('#password-error').removeClass('error-show');
							passwordError = 0;


// ------------------- Disabling Submit Button to avoid wrong submission ------------------
							if (emailError == 0 && passwordError == 0 && emailValidity == 1) {
								$('#signup-btn').removeAttr('disabled');
							} else {
								$('#signup-btn').attr('disabled', 'disabled');
							}
// ------------------- Disabling Submit Button to avoid wrong submission ------------------							

						} else if ($(this).attr('name') == "email") {
							$('#email-error').addClass('error-hide');
							$('#email-error').removeClass('error-show');
							emailError = 0;




// =================== Email id availability checking ======================

							if (window.XMLHttpRequest) {
								xmlhttp = new XMLHttpRequest();
							} else {
								xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
							}

							xmlhttp.onreadystatechange=function() {
								if (this.readyState==4 && this.status==200) {
								  
									if (this.responseText == "") {

										$('#email-availability').addClass('error-hide');
										$('#email-availability').removeClass('error-show');
										emailValidity = 1;

								    } else {

								    	$('#email-availability').removeClass('error-hide');
										$('#email-availability').addClass('error-show');
										emailValidity = 0;

								  		document.getElementById("email-availability-text").innerHTML=this.responseText;
								    }	
								}

// ------------------- Disabling Submit Button to avoid wrong submission ------------------

								if (emailError == 0 && passwordError == 0 && emailValidity == 1) {
									$('#signup-btn').removeAttr('disabled');
								} else {
									$('#signup-btn').attr('disabled', 'disabled');
								}
// ------------------- Disabling Submit Button to avoid wrong submission ------------------								

							}

							

							xmlhttp.open("GET","email_availability_checker.php?q="+$(this).val(),true);

							xmlhttp.send();
						}

					}

									
				});
				
			});
		
		});

	</script>

</body>
</html>





