<?php
$users = include ('data/user_data.php');

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = md5($_POST['password']); // Consider using a stronger hash function in production
    $cpass = md5($_POST['cpassword']);
    $user_type = $_POST['user_type'];

    $email_exists = false;
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            $email_exists = true;
            break;
        }
    }

    if ($email_exists) {
        $message[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password not matched!';
        } else {
            $last_user = end($users);
            $next_id = $last_user['id'] + 1;

            $users[] = array(
                'id' => $next_id,
                'name' => $name,
                'email' => $email,
                'password' => $pass,
                'user_type' => $user_type
            );

            // Update the user data file
            file_put_contents('data/user_data.php', "<?php\nreturn " . var_export($users, true) . ";");

            $message[] = 'Registered successfully!';
            header('Location: login.php');
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

    //1 

    //percjellja permes references
    $r_titulli="regjistrohu";
    $subscribe_text = "Enter your name";
    $input_placeholder=& $subscribe_text;

    // kthimi perrmes references

    function change_r_titulli(&$r_titulli_ref){
        $r_titulli_ref="Signup";
    }

    change_r_titulli($r_titulli);

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
                         <!-- thirr permes references-->
                    <div class="title"><?php echo $r_titulli; ?></div>
                    
                    <form action="" method="post">
                        <div class="input-boxes">
                            <div class="input-box">
                                <i class="fas fa-user"></i>
                                <!-- 1 -->
                                <input type="text" name="name" placeholder="<?php echo $input_placeholder ?>" required>
                                <!-- 1 -->
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