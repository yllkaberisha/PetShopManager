<?php

session_start();

if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$orders = include('data/orders.php'); // Load orders from the file

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>your orders</h3>
   <p> <a href="home.php">home</a> / orders </p>
</div>

<section class="placed-orders">
   <h1 class="title">placed orders</h1>
   <div class="box-container">
      <?php
         // Filter orders for the logged-in user
         $user_orders = array_filter($orders, function($order) use ($user_id) {
            return $order['user_id'] == $user_id;
         });

         if (!empty($user_orders)) {
            foreach ($user_orders as $order) {
      ?>
      <div class="box">
         <p> placed on : <span><?php echo $order['placed_on']; ?></span> </p>
         <p> name : <span><?php echo $order['name']; ?></span> </p>
         <p> number : <span><?php echo $order['number']; ?></span> </p>
         <p> email : <span><?php echo $order['email']; ?></span> </p>
         <p> address : <span><?php echo $order['address']; ?></span> </p>
         <p> payment method : <span><?php echo $order['method']; ?></span> </p>
         <p> your orders : <span><?php echo $order['total_products']; ?></span> </p>
         <p> total price : <span>$<?php echo $order['total_price']; ?>/-</span> </p>
         <p> payment status : <span style="color:<?php echo $order['payment_status'] == 'pending' ? 'red' : 'green'; ?>;"><?php echo $order['payment_status']; ?></span> </p>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">no orders placed yet!</p>';
         }
      ?>
   </div>
</section>

<?php include 'footer.php'; ?>
</body>
</html>
