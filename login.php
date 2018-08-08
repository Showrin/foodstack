<?php

	session_start();
			
	$error = 0;

	if (isset($_POST['action'])){
		
		$email = $_POST['email'];
		
		$password = $_POST['password'];
		$password = md5($password);
		$password = sha1($password);
		
		$connection = mysqli_connect('localhost', 'root', '', 'foodstack');
		
		$search_query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
		
		$result = mysqli_query($connection, $search_query);
		
		if (mysqli_num_rows($result)){
			
			$row = mysqli_fetch_assoc($result);
			
			$_SESSION['user_id'] = $row['user_id'];

			
			header("Location:index.php");
		}else{
			
			$error = 1;
		}
		
	}



?>









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


	<form id="signin" action="login.php" method="post">

		<div class="row">

			<div class="col l4 m6 s12 offset-l4 offset-m3">

				<center>
					<a id="fb-btn" class="waves-effect waves-light btn"><i class="fab fa-facebook-f"></i>Facebook</a>
					<a id="google-btn" class="waves-effect waves-light btn"><i class="fab fa-google"></i>Google</a>
				</center>
				
			</div>
			
		</div>

		<div class="row">

			<div class="col l4 m6 s12 offset-l4 offset-m3" style="margin-top: 2%;">


<!-- ----------- Printing error message -------------- -->

				<?php

					if ($error == 1) {

				?>

					<div class="login-error error-show">
						<div style="margin: auto; display: flex;">
							<i class="material-icons">error</i>
							<span>Invalid Email-id or password</span>
						</div>
					</div>

				<?php 

					}

				?>

<!-- ----------- Printing error message -------------- -->


				<div class="input-field">
					<i class="material-icons prefix">person</i>
					<input type="email" id="email" class="autocomplete" name="email" required>
					<label for="email">Email</label>
				</div>
				
			</div>
			
		</div>

		<div class="row"> 

			<div class="col l4 m6 s12 offset-l4 offset-m3">

				<div class="input-field">
					<i class="material-icons prefix">lock</i>
					<input id="password" type="password" name="password" required>
          			<label for="password">Password</label>
				</div>
				
			</div>
			
		</div>

		<div class="row">

			<div class="col l4 m6 s12 offset-l4 offset-m3">

				
				<button id="login-btn" class="btn waves-effect waves-light" type="submit" name="action">Login
					<i class="material-icons right">send</i>
				</button>
				    

				<p style="color:white;" class="center">
					Don't have an account? Please <a href="sign_up.php"> Register </a>
				</p>
				
			</div>
			
		</div>

	</form>

	
<!-- jQuery is required by Materialize to function -->
	<script type="text/javascript" src="js/bin/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="js/bin/materialize.min.js"></script>
</body>
</html>