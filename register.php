<?php

include 'config.php';
function logUserRegistration($name, $email) {
    $file = fopen("user_registrations.txt", "a"); // Hap skedarin për shkrim (mode "a" për të shtuar në fund të skedarit)
    fwrite($file, "User registration - Name: $name, Email: $email\n"); // Shkruan mesazhin në skedar dhe shton një rresht të ri
    fclose($file); // Mbyll skedarin
}

// Funksioni për të shkruar mesazhet në një skedar log për admin
function logAdminRegistration($name, $email) {
    $file = fopen("admin_registrations.txt", "a"); // Hap skedarin për shkrim (mode "a" për të shtuar në fund të skedarit)
    fwrite($file, "Admin registration - Name: $name, Email: $email\n"); // Shkruan mesazhin në skedar dhe shton një rresht të ri
    fclose($file); // Mbyll skedarin
}

if(isset($_POST['submit'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
   $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
   $user_type = $_POST['user_type'];

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

   if(mysqli_num_rows($select_users) > 0){
      $message[] = 'user already exist!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{
         mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
         $message[] = 'registered successfully!';
         if($user_type == 'user'){
            logUserRegistration($name,$email);
         }else if($user_type =='admin'){
            logAdminRegistration($name,$email);
         }
         header('location:login.php');
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">

</head>

<body>



    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }
    ?>

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

                <div class="signup-form">
                    <div class="title">Signup</div>
                    <form action="" method="post">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <input type="text" name="name" placeholder="Enter your name" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-envelope"></i>
                                <input type="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="password" placeholder="Enter your password" required>
                            </div>
                            <div class="input-box">
                                <i class="fas fa-lock"></i>
                                <input type="password" name="cpassword" placeholder="Confirm your password" required>
                            </div>
                            <div class="input-box">
                                <h3 for="user_type">Choose role: </h3>
                                <select name="user_type" class="box">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="button input-box">
                                <input type="submit" name="submit" value="register now">
                            </div>
                            <div class="text sign-up-text">Already have an account? <a href="login.php">Login now</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>