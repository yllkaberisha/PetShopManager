<?php

// Declare a global variable
global $pageName;
$pageName = '   Kitty   ';

$name = strtoupper($pageName);
$name = trim($name);
$name = substr($name, 2);

// var_dump($pageName);


$catNames = array("Whiskers", "Mittens", "Felix", "Luna", "Simba");
$catNames[] = "Tiger";

// echo "List of cat names:<br>";
foreach ($catNames as $name) {
   //  echo $name . "<br>";
}

$catInfo = array(
   "Whiskers" => "Gray",
   "Mittens" => "White",
   "Felix" => "Black",
   "Luna" => "Calico",
   "Simba" => "Orange"
);


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

if( isset( $_SESSION['counter'] ) )
{

$_SESSION['counter'] += 1;
}
else
{
$_SESSION['counter'] = 1;
}

$_SESSION['timesVisited'] = '
<?php
function func(){
   echo "You visited this page <span>" . $_SESSION["counter"] . "</span> times";

;}
?>';


$logo = isset($_COOKIE['logo']) ? $_COOKIE['logo'] : './images/logo.png'; 
$background_color = isset($_COOKIE['background_color']) ? $_COOKIE['background_color'] : '';

// Fetch text color preference from cookie or set default
$text_color = isset($_COOKIE['text_color']) ? $_COOKIE['text_color'] : '';

// Fetch logo preference from cookie or set default
$logo = isset($_COOKIE['logo']) ? $_COOKIE['logo'] : './images/logo.png';

// Fetch font family preference from cookie or set default
$font_family = isset($_COOKIE['font_family']) ? $_COOKIE['font_family'] : 'Rubik, sans-serif';
?>

<style>
       body {
           background-color: <?php echo $background_color; ?>;
           color: <?php echo $text_color; ?>;
           font-family: <?php echo $font_family; ?>; 
       }
   </style>
   
<header class="header">



   <div class="header-2">
      <div class="flex">
         
         <a href="home.php" class="logo"> <img src="<?php echo $logo; ?>" alt="paw" class='logo-img'> Kitty.</a>

         <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="shop.php">shop</a>
            <a href="contact.php">contact</a>
            <a href="orders.php">orders</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i>  </a>
         </div>

         <div class="user-box">  
            <a href="preferences.php" class="settings-font"><i class="fas fa-cog"> Preferences</i></a>   
            <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
            <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">logout</a>
            
         </div>


      </div>
   </div>

</header>