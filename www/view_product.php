<?php

	session_start();
	include "./include/dashboard_header.php";
	include "./include/db.php";
	include "./include/function.php";
	checkLogin();

?>
	<div class="wrapper">
		<div id="stream">
			<table id="tab">
				<thead>
					<tr>
						<th>title</th>
						<th>author</th>
						<th>price</th>
						<th>category</th>
						<th>image</th>
						<th>edit</th>
						<th>delete</th>
					</tr>
				</thead>
				<tbody>
					
					<?php

						$show = viewProduct($conn);
						echo $show;

					?>

          		</tbody>
			</table>
		</div>

		<div class="paginated">
			<a href="#">1</a>
			<a href="#">2</a>
			<span>3</span>
			<a href="#">2</a>
		</div>
	</div>
<?php

	include "./include/footer.php";

?>
	
</body>
</html>
