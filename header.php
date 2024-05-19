<?php
include 'config.php';

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

if (isset($_COOKIE['logo'])) {
   $logo = $_COOKIE['logo'];
} else {
   $logo = './images/logo.png'; 
}


?>

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
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
            ?>
            <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
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