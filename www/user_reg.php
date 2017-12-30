 <?php 

    include "./include/function.php";
    include "./include/db.php"; 
    include "./include/user_dashboard.php";

 ?>

  <?php 
       
        $errors = [];
      if(array_key_exists("reg", $_POST)){

          if(empty($_POST['fname'])){
            $errors['fname'] = "Please enter your firstname";
          }
          if(empty($_POST['lname'])){
            $errors['lname'] = "Please enter your lastname";
          }
          if(empty($_POST['email'])){
            $errors['email'] = "Please enter your email";
          }
          if(checkEmailExists($conn, $_POST['email'])){
            $errors['email'] = "Email already exists. Please enter another email";
          }
          if(empty($_POST['user'])){
            $errors['user'] = "Please enter your username";
          }
          if(empty($_POST['pword'])){
            $errors['pword'] = "Please enter your password";
          }
          if(empty($_POST['cword'])){
            $errors['cword'] = "Please confirm your password";
          }
          if($_POST['pword'] !==$_POST['cword']){
            $errors['cword'] = "password do not match, please try again";
          }

          if(empty($errors)){
              $clean = array_map('trim', $_POST);
              userReg($conn, $clean);

              echo "Registration successfully";
          }
        }
  ?>
  <div class="main">
    <div class="registration-form">
      <form class="def-modal-form" action="user_reg.php" method="post">
        <div class="cancel-icon close-form"></div>
        <label for="registration-from" class="header"><h3>User Registration</h3></label>

        <?php $info = showErrors($errors, 'fname'); echo $info; ?>

        <input type="text" class="text-field first-name" placeholder="Firstname" name="fname">

        <?php $info = showErrors($errors, 'lname'); echo $info; ?>
        <input type="text" class="text-field last-name" placeholder="Lastname" name="lname">
                <?php $info = showErrors($errors, 'fname'); echo $info; ?>

        <?php $info = showErrors($errors, 'email'); echo $info; ?>
        <input type="email" class="text-field email" placeholder="Email" name="email">

         <?php $info = showErrors($errors, 'user'); echo $info; ?>
        <input type="text" class="text-field username" placeholder="Username" name="user">

        <?php $info = showErrors($errors, 'pword'); echo $info; ?>
        <input type="password" class="text-field password" placeholder="Password" name="pword">

        <?php $info = showErrors($errors, 'cword'); echo $info; ?>
        <input type="password" class="text-field confirm-password" placeholder="Confirm Password" name="cword">

        <input type="submit" class="def-button" value="Register" name="reg">

        <p class="login-option"><a href="user_login.php">Have an account already? Login</a></p>
      </form>
    </div>
  </div>
  <?php
      include "./include/user_footer.php";
    ?>
</body>
</html>