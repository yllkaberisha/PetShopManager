<?php

include 'config.php';
session_start();

if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){

      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:home.php');

      }

   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/login.css">

</head>

<body>

   <div class="container">
      <input type="checkbox" id="flip">
      <div class="cover">
         <div class="front">
            <img src="images/login.jpg" alt="">
            <div class="text">
               <span class="text-1">Every new friend is a <br> new adventure</span>
               <span class="text-2">Let's get connected</span>
            </div>
         </div>
         <div class="back">
            <!--<img class="backImg" src="images/backImg.jpg" alt="">-->
            <div class="text">
               <span class="text-1">Complete miles of journey <br> with one step</span>
               <span class="text-2">Let's get started</span>
            </div>
         </div>
      </div>
      <div class="forms">
         <div class="form-content">
            <div class="login-form">
               <div class="title">Login</div>
               <form action="" method="post">
                  <div class="input-boxes">
                     <div class="input-box">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Enter your email" required>
                     </div>
                     <div class="input-box">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Enter your password" required>
                     </div>
                     <div class="button input-box">
                        <input type="submit" name="submit" value="Login now">
                     </div>

                     <?php
                     if (isset($message)) {
                        echo '
                              <h3 style="color: red;">' . $message . '</h3>
                              ';
                     }
                     ?>

                     <div class="text sign-up-text">Don't have an account? <a href="register.php">Register now</a></div>
                  </div>
               </form>
            </div>

         </div>
      </div>
   </div>

</body>

</html>