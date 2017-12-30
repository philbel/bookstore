<?php
	
	session_start();
	include "./include/dashboard_header.php";
	include "./include/db.php";
	include "./include/function.php";

	checkLogin();

	$errors = [];

	if(isset($_GET['book_id'])){
		$bookId = $_GET['book_id'];
	}

	$res = getProductById($conn, $bookId);

	//print_r($res); exit;

	if(array_key_exists("edit", $_POST)){
		
		if(empty($_POST['title'])){
			$errors['title'] = "Please enter book title";
		}

		if(empty($_POST['author'])){
			$errors['author'] = "Please enter author's name";
		}

		if(empty($_POST['price'])){
			$errors['price'] = "Please enter book price ";
		}

		if(empty($_POST['year'])){
			$errors['year'] = "Please enter date of publication ";
		}

		if(empty($_POST['cat_id'])){
			$errors['cat_id'] = "Please select category";
	
		}

		if(empty($errors)){
			$clean = array_map("trim", $_POST);
			$clean['book_id'] = $bookId;

			editProduct($conn, $clean);
			redirect('view_product.php');
			//updateImage($conn, $clean, './uploads');
			
		}
	}

?>
	<div class="wrapper">
		<div id="stream">

			<form id="register"  action ="" method ="POST">
			<div>
				<?php $info = displayErrors($errors, 'title'); echo $info; ?>
				<label>Edit Title</label>
				<input type="text" name="title" value="<?php echo $res[1]; ?>" >
			</div>

			<div>
				<?php $info = displayErrors($errors, 'author'); echo $info; ?>
				<label>Edit Author</label>
				<input type="text" name="author" value="<?php echo $res[2]; ?>" >
			</div>

			<div>
				<?php $info = displayErrors($errors, 'price'); echo $info; ?>
				<label>Edit Price</label>
				<input type="text" name="price" value="<?php echo $res[3]; ?>" >
			</div>

			<div>
				<?php $info = displayErrors($errors, 'year'); echo $info; ?>
				<label>Edit Year</label>
				<input type="text" name="year" value="<?php echo $res[4]; ?>" >
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

			<input type="submit" name="edit" value="Edit">
		</form>
			
		</div>
	</div>
<h4 class="wrapper">To edit Product Image <a href="edit_image.php?img=<?php echo $bookId ?>">Click here</a></h4>

<?php

	include "./include/footer.php";

?>

</body>
</html>
