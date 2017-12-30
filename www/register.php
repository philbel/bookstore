<?php
	
	$page_title = "Register";
	include "./include/header.php";
	include "./include/db.php";
	include "./include/function.php";

?>

<?php

	$errors = [];

	if(array_key_exists('register', $_POST)){

		if(empty($_POST['fname'])){
			$errors['fname'] = "Please enter your firstname";
	
		}

		if(empty($_POST['lname'])){
			$errors['lname'] = "please enter your lastname";

		}

		if(empty($_POST['email'])){
			$errors['email'] = "Please enter your email address";
	
		}
		if(doesEmailExists($conn, $_POST['email'])){
			$errors['email'] = "Email already exists. Please enter another email";
		}

		if(empty($_POST['password'])){
			$errors['password'] = "Please enter your password";
		}

		if(empty($_POST['pword'])){
			$errors['pword'] = "Please confirm your password";
		}

		if($_POST['password'] !==$_POST['pword']){
			$errors['pword'] = "password do not match, please try again";
		}

		if(empty($errors)){
			//populate database;
			//echo "registration successful";
			$clean = array_map('trim', $_POST);

			adminRegister($conn, $clean);

			echo "You've been registered successfully";
		}

	}

?>
	
	<div class="wrapper">
		<h1 id="register-label">Register</h1>
		<hr>
		<form id="register"  action ="register.php" method ="POST">
			<div>
				<?php $info = displayErrors($errors, 'fname'); echo $info; ?>
				<label>first name:</label>
				<input type="text" name="fname" placeholder="first name">
			</div>
			<div>
				<?php $err = displayErrors($errors, 'lname'); echo $err; ?> 
				<label>last name:</label>	
				<input type="text" name="lname" placeholder="last name">
			</div>

			<div>
				<?php $info = displayErrors($errors, 'email'); echo $info; ?>
				<label>email:</label>
				<input type="text" name="email" placeholder="email">
			</div>
			<div>
				<?php $info = displayErrors($errors, 'password'); echo $info; ?>
				<label>password:</label>
				<input type="password" name="password" placeholder="password">
			</div>
 
			<div>
				<?php $info = displayErrors($errors, 'pword'); echo $info; ?>
				<label>confirm password:</label>	
				<input type="password" name="pword" placeholder="password">
			</div>

			<input type="submit" name="register" value="register">
		</form>

		<h4 class="jumpto">Have an account? <a href="login.php">login</a></h4>
	</div>

	<?php

		include "./include/footer.php";

	?>

