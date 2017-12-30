<?php
  session_start();
 // $page_title = "Login";  
  include "./include/user_dashboard.php";
  include "./include/db.php";
  include "./include/function.php";
?>
	
	<div class="main">
    <div class="book-display">
      <div class="display-book"></div>
      <div class="info">
        <h2 class="book-title">Eloquent Javascript</h2>
        <h3 class="book-author">by Marijn Haverbeke</h3>
        <h3 class="book-price">$200</h3>

        <?php

        	$errors = [];
        	if(array_key_exists('cart', $_POST)){

        		if(empty($_POST['amat']) && $_POST['amat'] != 0){
        			$errors['amat'] = "Please add amount to cart";
        		}
        		if(empty($errors)){
        			//redirect('bookpreview.php');
        		}
        	}

		?>
       
        <form action="" method="post">
          <label for="book-amout">Amount</label>
          <input type="number" class="book-amount text-field" name="amat">
          <input class="def-button add-to-cart" type="submit" name="cart" value="Add to cart">
        </form>
      </div>
    </div>

 	<?php
      include "./include/user_footer.php";
    ?>
</body>
</html>