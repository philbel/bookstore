<?php
	
	session_start();
	$page_title = "Login";
	include "./include/header.php";
	include "./include/db.php";
	include "./include/function.php";

	$errors = [];

	if(array_key_exists("login", $_POST)){

		if(empty($_POST['email'])){
			$errors['email'] = "Please enter your registered email address";
		}

		if(empty($_POST['password'])){
			$errors['password'] = "Please provide your password";
		}

		if(empty($errors)){
			$clean = array_map('trim', $_POST);
			$data = adminLogin($conn, $clean);

			if($data[0]){

				$details = $data[1];
				$_SESSION['name'] = $details['first_name']." ".$details['last_name'];
				$_SESSION['aid'] = $details['admin_id'];
				redirect("add_category.php", "");
			}
		}
	}

?>



	<div class="wrapper">
		<h1 id="register-label">Admin Login</h1>
		<hr>
		<form id="register"  action ="login.php" method ="POST">
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

			<input type="submit" name="login" value="login">
		</form>

		<h4 class="jumpto">Don't have an account? <a href="register.php">register</a></h4>
	</div>
	
<?php
	
	include "./include/footer.php";

?>