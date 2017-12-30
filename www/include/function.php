<?php

	function uploadFiles($files, $name, $loc){
		$result = [];

		$rnd = rand(0000000000, 9999999999);
		$strip_name = str_replace(' ', '_', $files[$name]['name']);

		$filename = $rnd.$strip_name;
		$destination = $loc.$filename;

		if(move_uploaded_file($files[$name]['tmp_name'], $destination)){
			$result[] = true;
			$result[] = $destination;
		}else{
			$result[] = false;
		}

		return $result;
	}

	function displayErrors($err, $key){
		$result = "";

		if(isset($err[$key])){
			$result = '<span class="err">'.$err[$key].'</span>';
		}
		return $result;
	}

	function adminRegister($dbconn, $input){
	//	$result = [];
		$hash = password_hash($input['password'], PASSWORD_BCRYPT);

		$stmt = $dbconn->prepare("INSERT INTO admin(first_name, last_name, email, hash) 
									VALUES(:f, :l, :e, :h)");

		$data = [

					":f" => $input['fname'],
					 ":l" => $input['lname'],
					 ":e" => $input['email'],
					 ":h" => $hash  
				];

				$stmt->execute($data);
	}

	function doesEmailExists($dbconn, $email){
		$result = false;
		$stmt = $dbconn->prepare("SELECT email FROM admin WHERE email=:e");

		$stmt->bindParam(":e", $email);
		$stmt->execute();

		$count = $stmt->rowCount();

		if($count > 0){
			$result = true;
		}

		return $result;
	}

	function adminLogin($dbconn, $input){
		$result = [];
		$stmt = $dbconn->prepare("SELECT * FROM admin WHERE email=:e");

		$stmt->bindParam(":e", $input['email']);
		$stmt->execute();

		$count = $stmt->rowCount();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		//print_r($count); exit();

		if($count !== 1 || !password_verify($input['password'], $row['hash'])){
			$result[] = false;
		}else{
			$result[] = true;
			$result[] = $row;
		}
		return $result;
	}

	function redirect($loc, $msg){
		header("Location: ".$loc.$msg);
	}

	function addCategory($dbconn, $input){
		$stmt = $dbconn->prepare("INSERT INTO category(category_name) VALUES(:catName)");
		$stmt->bindParam(":catName", $input['cat_name']);

		$stmt->execute();


	}
	
	function checkLogin(){
		if(!isset($_SESSION["aid"])){
			redirect("login.php", "");
		}
	}

	function viewCategory($dbconn){
		$result = "";

		$stmt = $dbconn->prepare("SELECT * FROM category");
		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_BOTH)){
			$result .= '<tr><th>'.$row[0].'</th>';
			$result .= '<th>'.$row[1].'</th>';
			$result .= '<th><a href="edit_category.php?cat_id='.$row[0].'">edit</a></th>';
			$result .= '<th><a href="delete_category.php?cat_id='.$row[0]. '">delete</a></th></tr>';
		}
		return $result;
	}

	function getCategoryById($dbconn, $catId){
		$stmt = $dbconn->prepare("SELECT * FROM category WHERE category_id=:catId");
		$stmt->bindParam(":catId", $catId);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_BOTH);

		return $row;
	}

	function editCategory($dbconn, $input){
		$stmt = $dbconn->prepare("UPDATE category SET category_name=:cat_name WHERE category_id=:catId");
		$stmt->bindParam(":catId", $input['cat_id']);
		$stmt->bindParam(":cat_name", $input['cat_name']);
		$stmt->execute();

		$count = $stmt->rowCount();
		redirect("view_category.php", "");
	}

	function deleteCategory($dbconn, $input){
		$stmt = $dbconn->prepare("DELETE FROM category WHERE category_id=:catId");
		$stmt->bindParam(":catId", $input['cat_id']);
		$stmt->execute();

		$row = $stmt->rowCount();
		//$row = $stmt->fetch(PDO::FETCH_BOTH);
		//print_r($row);exit();

		//return $row;
		redirect("view_category.php", "");
	}

	function fetchCategory($dbconn){
		$result = "";
		$stmt = $dbconn->prepare("SELECT * FROM category");
		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_BOTH)){

			$result .= '<option value="'.$row[0].'">'.$row[1].'</option>';
		}

		return $result;
	}

	function addProduct($dbconn, $input){
		$stmt = $dbconn->prepare("INSERT INTO books(title, author, price, publication_date, category_id, flag, 														image_path) 
									VALUES(:t, :a, :p, :pub, :cat, :f, :im)");

		$data = [
				  ":t" => $input['title'],
				  ":a" => $input['author'],
				  ":p" => $input['price'],
				  ":pub" => $input['year'],
				  ":cat" => $input['cat_id'],
				  ":f" => $input['flag'],
				  ":im" => $input['dest']
				];

		$stmt->execute($data);

	}

	function curNave($page) {

		$curPage = basename($_SERVER['SCRIPT_FILENAME']);

		if($curPage == $page) {
			echo 'class="selected"';
		}
	}

		function viewProduct($dbconn){
		$result = "";

		$stmt = $dbconn->prepare("SELECT * FROM books");
		$stmt->execute();

		while($row = $stmt->fetch(PDO::FETCH_BOTH)){
			$result .= '<tr><th>'.$row[1].'</th>';
			$result .= '<th>'.$row[2].'</th>';
			$result .= '<th>'.$row[3].'</th>';
			$result .= '<th>'.$row[5].'</th>';
			$result .= '<td><img src="'.$row[7].'" height="50" width="50"></td>';			
			$result .= '<th><a href="edit_product.php?book_id='.$row[0].'">edit</a></th>';
			$result .= '<th><a href="delete_product.php?book_id='.$row[0]. '">delete</a></th></tr>';
		}
		return $result;
	}

	function getProductById($dbconn,$bookId){
		$stmt = $dbconn->prepare("SELECT * FROM books WHERE book_id=:bukId");
		$stmt->bindParam(":bukId", $bookId);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_BOTH);
		return $row;
	}

	function editProduct($dbconn, $input){
		$stmt = $dbconn->prepare("UPDATE books SET title= :t, author= :a, price= :p, publication_date= :pub, category_id= :catId WHERE book_id= :id");
		/*$data = [
					":t" => $input['title'],
					":a" => $input['author'],
					":p" => $input['price'],
					":pub" => $input['year'],					
					":catId" => $input['cat_id'],
					":id" => $input['prod_name']
				];*/

		$stmt->bindParam(":t", $input['title']);
		$stmt->bindParam(":a", $input['author']);
		$stmt->bindParam(":p", $input['price']);
		$stmt->bindParam(":pub", $input['year']);
	  	$stmt->bindParam(":catId", $input['cat_id']);
		$stmt->bindParam(":id", $input['book_id']);

		$stmt->execute();
	}

	function updateImage($dbconn, $bookId, $location) {

		$stmt = $dbconn->prepare("UPDATE books SET image_path = :img WHERE book_id = :bid");

		$data = [
			":img" => $location,
			":bid" => $bookId
		];

		$stmt->execute($data);
		redirect('view_product.php');
	}

	function deleteProduct($dbconn, $input){
		$stmt = $dbconn->prepare("DELETE  FROM books WHERE book_id=:bookid");
		$stmt->bindParam(":bookid", $input);
		$stmt->execute();
		
		redirect("view_product.php", "");
	}

	function logOut($dbconn){
		unset($email);
		unset($hash);
	}

//FRONT END USER FUNCTIONS STARTS HERE
	function showErrors($err, $key){
		$result = "";

		if(isset($err[$key])){
			$result = '<span class="form-error">'.$err[$key].'</span>';
		}
		return $result;
	}

	function checkEmailExists($dbconn, $email){
		$result = false;
		$stmt = $dbconn->prepare("SELECT email FROM user WHERE email=:e");

		$stmt->bindParam(":e", $email);
		$stmt->execute();

		$count = $stmt->rowCount();

		if($count > 0){
			$result = true;
		}

		return $result;
	}

	function userReg($dbconn, $input){

		$hash = password_hash($input['pword'], PASSWORD_BCRYPT);

		$stmt = $dbconn->prepare("INSERT INTO user(firstname, lastname, email, username, hash) 
									VALUES(:f, :l, :e, :u, :h)");

		$data = [
					":f" => $input['fname'],
					 ":l" => $input['lname'],
					 ":e" => $input['email'],
					 ":u" => $input['user'],
					 ":h" => $hash  
				];

				$stmt->execute($data);
	}

	function userLogin($dbconn, $input){
		$result = [];
		$stmt = $dbconn->prepare("SELECT * FROM user WHERE email=:e");

		$stmt->bindParam(":e", $input['email']);
		$stmt->execute();

		$count = $stmt->rowCount();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		//print_r($count); exit();

		if($count !== 1 || !password_verify($input['pword'], $row['hash'])){
			$result[] = false;
		}else{
			$result[] = true;
			$result[] = $row;
		}
		return $result;
	}

	function flag($dbconn, $flag){
		$stmt = $dbconn->prepare("SELECT * FROM books WHERE flag =:fl");
		$stmt->bindParam(":fl", $flag);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_BOTH);
		return $row;
		print_r($row);
	}

?>