<?php
session_start();
$users = include ('data/user_data.php'); // Load user data

// Function to set session data
function setSessionData($user)
{
   $_SESSION['user_name'] = $user['name'];
   $_SESSION['user_email'] = $user['email'];
   $_SESSION['user_type'] = $user['user_type'];

   if ($user['user_type'] === 'admin') {
      $_SESSION['admin_id'] = $user['id'];
  } else {
      $_SESSION['user_id'] = $user['id'];
  }

}

if (isset($_POST['submit'])) {
   $email = $_POST['email'];
   $pass = md5($_POST['password']); 
   $authenticated = false;

   // Check user credentials
   foreach ($users as $user) {
   
      if ($user['email'] === $email && $user['password'] === $pass) {
         $authenticated = true;
         break; // Stop loop once user is found and authenticated
      }
   }

   if ($authenticated) {
      // Assign session variables based on user type and redirect
      setSessionData($user);
      $redirectPage = ($user['user_type'] === 'admin') ? 'admin_page.php' : 'home.php';
      header("Location: $redirectPage");
      exit();
   } else {
      $message = 'Incorrect email or password!';
   }
}

// Percjellja permes references
$subscribe_text = "Enter your email";
$input_placeholder=& $subscribe_text;
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

                         <!-- Kthimi permes references -->
                         <input type="email" name="email" placeholder="<?php echo $input_placeholder ?>" required>
                                

                     
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