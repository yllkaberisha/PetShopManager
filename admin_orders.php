<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

$orders_file = 'data/orders.php';
$orders = file_exists($orders_file) ? include($orders_file) : [];

function saveOrdersToFile($orders, $orders_file) {
    file_put_contents($orders_file, "<?php\nreturn " . var_export($orders, true) . ";\n");
}

if (isset($_POST['update_order'])) {
    $order_update_index = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];

    if (isset($orders[$order_update_index])) {
      $orders[$order_update_index]['payment_status'] = $update_payment;
      saveOrdersToFile($orders, $orders_file);
      $message[] = 'Payment status has been updated!';
  }
}

if (isset($_GET['delete'])) {
   $delete_index = $_GET['delete']; // Get the index of the order to delete
   // Remove the order by its index
   if (isset($orders[$delete_index])) {
       unset($orders[$delete_index]);
       // Re-index the array to maintain consistent indexing
       $orders = array_values($orders);
       saveOrdersToFile($orders, $orders_file);
       header('location:admin_orders.php');
       exit();
   }
}

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

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="orders">
   <h1 class="title">Placed orders</h1>
   <div class="box-container">
      <?php
      // Assuming $orders is already loaded from 'data/orders.php'
      if(!empty($orders)){
         foreach($orders as $index => $order){
      ?>
      <div class="box">
         <p> user id : <span><?php echo $order['user_id']; ?></span> </p>
         <p> placed on : <span><?php echo $order['placed_on']; ?></span> </p>
         <p> name : <span><?php echo $order['name']; ?></span> </p>
         <p> number : <span><?php echo $order['number']; ?></span> </p>
         <p> email : <span><?php echo $order['email']; ?></span> </p>
         <p> address : <span><?php echo $order['address']; ?></span> </p>
         <p> total products : <span><?php echo $order['total_products']; ?></span> </p>
         <p> total price : <span>$<?php echo $order['total_price']; ?></span> </p>
         <p> payment method : <span><?php echo $order['method']; ?></span> </p>
         <form action="" method="post">
            <input type="hidden" name="order_id" value="<?php echo $index; ?>">
            <select name="update_payment">
               <option value="" selected disabled><?php echo $order['payment_status']; ?></option>
               <option value="pending">pending</option>
               <option value="completed">completed</option>
            </select>
            <input type="submit" value="update" name="update_order" class="option-btn">
            <a href="admin_orders.php?delete=<?php echo $index; ?>" onclick="return confirm('delete this order?');" class="delete-btn">delete</a>
         </form>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">No orders placed yet!</p>';
      }
      ?>
   </div>
</section>











<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>