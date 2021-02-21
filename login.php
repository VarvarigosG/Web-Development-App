<?php include('functions.php') ;
include('DBconnect.php');
?>

<!DOCTYPE html>
<html>

<head>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:700&display=swap" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="loginScreen1.css">
	<title>Login!</title>

</head>

<body>

	<div class="imgcontainer">
		<img src="leaf.jpg" alt="Avatar" class="avatar" allign="center">
		<h2 style="text-align:center">Login with Your Account</h2>
	</div>

	<form method="post" action="login.php">

		<?php echo display_error(); ?>

		<div class="container">
			<div class="input-group">
				<div class="bg"></div>
				<label>Username</label><br>

				<input type="text" placeholder="Username" style="text-align: center" name="username">
				<br><label>Password</label><br>
				<input type="password" placeholder="Password" style="text-align: center" name="password">


				<div class="wrapperbtn">
					<button type="submit" class="btn" name="login_btn">Login!</button>
				</div>
			</div>
		</div>
		<div class="signup">
			Not yet a member? <a href="register.php">Sign up Now!</a>
		</div>
	</form>

</body>

</html>