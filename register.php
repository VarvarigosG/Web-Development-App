<?php include('functions.php'); 
include('DBconnect.php');?>

<!DOCTYPE html>
<html>

<head>
	<title>Register!</title>
	<link href="https://fonts.googleapis.com/css?family=Titillium+Web&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Ubuntu:700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="registerScreen1.css">
</head>

<body>


	<div class="header">
		<img src="leaf.jpg" alt="Avatar" class="avatar" allign="center">
		<h2>Registration Info</h2>
	</div>
	<div class="container">
		<form method="post" action="register.php">

			<?php echo display_error(); ?>
			<div class="group">
				<div class="input-group">
					<div class="bg"></div>
					<label>Username</label>
					<input type="text" name="username" placeholder="Enter Username" value="<?php echo $username; ?>">
					<br>

					<label>Email</label>
					<input type="email" name="email" placeholder="Enter email" value="<?php echo $email; ?>">
					<br>

					<label>Password</label>
					<input type="password" name="password_1" placeholder="Enter Password">
					<br>

					<label>Confirm password</label>
					<input type="password" name="password_2" placeholder="Confirm Password">
				</div>

			</div>
			<div class="btwrapper">
				<button type="submit" class="btn1" name="register_btn">Sign Up Now!</button>
			</div>
			<div class="login">
				Already a member? <a href="login.php">Sign in</a>
			</div>
	</div>
	</div>

	</form>
</body>

</html>