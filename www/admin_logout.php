<?php
	session_start();
	include "./include/dashboard_header.php";
	include "./include/db.php";
	include "./include/function.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php

		logOut($conn);
		redirect('login.php');

		session_destroy();
	?>

	<?php

	include "./include/footer.php";

?>
</body>
</html>