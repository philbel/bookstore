<?php
	
	session_start();
	include "./include/dashboard_header.php";
	include "./include/db.php";
	include "./include/function.php";

	checkLogin();

	$errors = [];

	if(isset($_GET['cat_id'])){
		$catId = $_GET['cat_id'];
	}

	$data = getCategoryById($conn, $catId);

	//print_r($data); exit;

	if(array_key_exists("edit", $_POST)){
		if(empty($_POST['cat_name'])){
			$errors['cat_name'] = "Please enter a category name";
		}

		if(empty($errors)){
			$clean = array_map("trim", $_POST);
			$clean['cat_id'] = $catId;

			editCategory($conn, $clean);
			
		}
	}

?>
	<div class="wrapper">
		<div id="stream">

			<form id="register"  action ="" method ="POST">
			<div>
				<?php $info = displayErrors($errors, 'cat_name'); echo $info; ?>
				<label>Edit Category</label>
				<input type="text" name="cat_name" value="<?php echo $data[1]; ?>" >
			</div>

			<input type="submit" name="edit" value="Edit">
		</form>
			
		</div>
	</div>

<?php

	include "./include/footer.php";

?>

</body>
</html>
