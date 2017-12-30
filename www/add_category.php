<?php
	
	session_start();
	include "./include/dashboard_header.php";
	include "./include/db.php";
	include "./include/function.php";

	checkLogin();

	$errors = [];

	if(array_key_exists("add", $_POST)){
		if(empty($_POST['cat_name'])){
			$errors['cat_name'] = "Please enter a category name";
		}

		if(empty($errors)){
			$clean = array_map("trim", $_POST);
			addCategory($conn, $clean);
		}
	}

?>
	<div class="wrapper">
		<div id="stream">

			<form id="register"  action ="add_category.php" method ="POST">
			<div>
				<?php $info = displayErrors($errors, 'cat_name'); echo $info; ?>
				<label>Add Category</label>
				<input type="text" name="cat_name" placeholder="Category Name">
			</div>

			<input type="submit" name="add" value="Add">
		</form>
			
		</div>
	</div>

<?php

	include "./include/footer.php";

?>

</body>
</html>
