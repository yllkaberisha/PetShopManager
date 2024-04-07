<?php

$users = include('data/user_data.php');

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $email = $_POST['email'];
   $pass = md5($_POST['password']); // Using md5 for consistency with your approach
   $cpass = md5($_POST['cpassword']);
   $user_type = $_POST['user_type'];

   // Simulating the check if user exists
   $email_exists = false;
   foreach ($users as $user) {
      if ($user['email'] === $email) {
         $email_exists = true;
         break;
      }
   }

   if($email_exists){
      $message[] = 'user already exists!';
   }else{
      if($pass != $cpass){
         $message[] = 'confirm password not matched!';
      }else{

         $last_user = end($users);
         $next_id = $last_user['id'] + 1;

         $users[] = array(
            'email' => $email,
            'password' => $pass,
            'user_type' => $user_type,
            'name' => $name,
            'id' => $next_id,
        );
       
         file_put_contents('data/user_data.php', "<?php\n// Users data storage\nreturn " . var_export($users, true) . ";");
         $message[] = 'registered successfully!';
         header('location:login.php');
         exit();
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

</head>
<body>



<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
   
<div class="form-container">

   <form action="" method="post">
      <h3>register now</h3>
      <input type="text" name="name" placeholder="enter your name" required class="box">
      <input type="email" name="email" placeholder="enter your email" required class="box">
      <input type="password" name="password" placeholder="enter your password" required class="box">
      <input type="password" name="cpassword" placeholder="confirm your password" required class="box">
      <select name="user_type" class="box">
         <option value="user">user</option>
         <option value="admin">admin</option>
      </select>
      <input type="submit" name="submit" value="register now" class="btn">
      <p>already have an account? <a href="login.php">login now</a></p>
   </form>

</div>

</body>
</html>