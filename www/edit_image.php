<?php 
	session_start();
	include "./include/db.php";
	include "./include/function.php";
	include "./include/dashboard_header.php";
	checkLogin();

	if(isset($_GET['img'])){
		$bookId = $_GET['img'];
	}

	$errors = [];
	define('MAX_FILE_SIZE', 2097152);
	$ext = ['image/jpeg', 'image/png', 'image/jpg'];

	if(array_key_exists('edit', $_POST)){

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

				$dest = $pix[1];
			}

			updateImage($conn, $bookId, $dest);
		}
	}
?>
<div class="wrapper">
	<h1 id="register-label">Edit Image</h1>
	<hr>
	<form id="register"  action ="" method ="POST" enctype="multipart/form-data">
		<div>
				<?php 
					$info = displayErrors($errors, 'pics');
					echo $info;
				?>
				<label>Image:</label>
				<input type="file" name="pics">
			</div>

			<input type="submit" name="edit" value="Edit">
		</form>

	</div>

<?php
	include "./include/footer.php";
?>
</body>
</html>