<?php
  session_start();
 // $page_title = "Login";  
  include "./include/user_dashboard.php";
  include "./include/db.php";
  include "./include/function.php";
?>

<?php 
       
        $errors = [];
      if(array_key_exists("submit", $_POST)){

          if(empty($_POST['email'])){
            $errors['email'] = "Please enter your email";
          }

          if(empty($_POST['pword'])){
             $errors['pword'] = "Please provide your password";
          }
         
          if(empty($errors)){
              $clean = array_map('trim', $_POST);
              $data = userLogin($conn, $clean);

              if($data[0]){

                  $details = $data[1];
                  $_SESSION['name'] = $details['first_name']." ".$details['last_name']." ".$details['username'];
                  $_SESSION['user'] = $details['user_id'];
                  redirect("home.php", "");
              }

          }

      }

?>

  <div class="main">
    <div class="login-form">
      <form class="def-modal-form" action="user_login.php" method="post">
        <div class="cancel-icon close-form"></div>

        <label for="login-form" class="header"><h3>Login</h3></label>

        <input type="text" class="text-field email" placeholder="Email" name="email">
                <?php $info = showErrors($errors, 'email'); echo $info; ?>
<!--         <p class="form-error">invalid email</p>
 -->
        <input type="password" class="text-field password" placeholder="Password" name="pword">
                <?php $info = showErrors($errors, 'pword'); echo $info; ?>

        <!--clear the error and use it later just to show you how it works -->
<!--         <p class="form-error">wrong password</p>
 -->        <input type="submit" class="def-button login" value="Login" name="submit">
      </form>
    </div>
  </div>
    <?php
      include "./include/user_footer.php";
    ?>
</body>
</html>
