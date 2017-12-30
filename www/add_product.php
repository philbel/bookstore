<?php
	
	session_start();
	$page_title = "add_product";
	include "./include/dashboard_header.php";
	include "./include/db.php";
	include "./include/function.php";
	checkLogin();

?>

<?php

			$errors = [];

	$flag = ["Top-Selling", "Trending", "Recently-Viewed"];

	define('MAX_FILE_SIZE', 2097152);

	$ext = ['image/jpeg', 'image/jpg', 'image/png'];


	if(array_key_exists('add', $_POST)){

		if(empty($_POST['title'])){
			$errors['title'] = "Please enter the book title";
	
		}

		if(empty($_POST['author'])){
			$errors['author'] = "please enter Author's name";

		}

		if(empty($_POST['price'])){
			$errors['price'] = "Please type in a price";
	
		}

		if(empty($_POST['year'])){
			$errors['year'] = "Please select publication year";
	
		}

		if(empty($_POST['cat_id'])){
			$errors['cat_id'] = "Please select category";
	
		}


		if(empty($_POST['flag'])) {
			$errors['flag'] = "Please select a flag";
		}

		if(empty($_FILES['pics']['name'])) {
			$errors['pics'] = "Please select a book image";
		}

		if($_FILES['pics']['size'] > MAX_FILE_SIZE) {
			$errors['pics'] = "Image size too large.";
		}

		if(!in_array($_FILES['pics']['type'], $ext)) {
			$errors['pics'] = "Image type not supported";
		}

		if(empty($errors)){
			
			$pix = uploadFiles($_FILES, 'pics', 'uploads/');

			if($pix[0]) {

				$location = $pix[1];
			}

			$clean = array_map('trim', $_POST);
			$clean['dest'] = $location;
			addProduct($conn, $clean);
			redirect('view_product.php');

			echo "You've successfully added a product";
		}

	}

?>
	
	<div class="wrapper">
		<h1 id="register-label">Add Product</h1>
		<hr>
		<form id="register"  action ="add_product.php" method ="POST" enctype="multipart/form-data">
			<div>
				<?php $info = displayErrors($errors, 'title'); echo $info; ?>
				<label>title:</label>
				<input type="text" name="title" placeholder="title">
			</div>
			<div>
				<?php $info = displayErrors($errors, 'author'); echo $info; ?> 
				<label>author:</label>	
				<input type="text" name="author" placeholder="author">
			</div>

			<div>
				<?php $info = displayErrors($errors, 'price'); echo $info; ?>
				<label>price:</label>
				<input type="text" name="price" placeholder="price">
			</div>

			<div>
				<?php $info = displayErrors($errors, 'year'); echo $info; ?>
				<label>publication year:</label>
				<input type="text" name="year" placeholder="publication year">
			</div>
 
			<div>
				<?php 
					$info = displayErrors($errors, 'cat_id');
					echo $info;
				?>
				<label>category id:</label>	
				<select name="cat_id">
					<option value="">Categories</option>
				<?php
					$data = fetchCategory($conn); echo $data;
				?>
				</select>
			</div>

			<div>
				<?php 
					$info = displayErrors($errors, 'flag');
					echo $info;
				?>
				<select name="flag">
					
					<option value="">Flag</option>
					<?php foreach($flag as $fl){ ?>

					<option value="<?php echo $fl; ?>"><?php echo $fl; ?></option>
					<?php } ?>

				</select>
			</div>

			<div>
				<?php 
					$info = displayErrors($errors, 'pics');
					echo $info;
				?>
				<label>Image:</label>
				<input type="file" name="pics">
			</div>

			<input type="submit" name="add" value="Add">
		</form>

	</div>

	<?php

		include "./include/footer.php";

	?>

