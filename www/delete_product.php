<?php
	
	session_start();
	include "./include/db.php";
	include "./include/function.php";

	if(isset($_GET['book_id'])){
		$bookId = $_GET['book_id'];
	}

	deleteProduct($conn, $bookId);
?>
