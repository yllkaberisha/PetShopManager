<?php

session_start();

if (!isset($_SESSION['admin_id'])) {
    header('location:login.php');
    exit();
}

// Load data from files
$orders = include('data/orders.php');
$products = include('data/products.php');
$users = include('data/user_data.php');
$messages = include('data/messages.php');

// Calculate metrics
$total_pendings = array_sum(array_map(function($order) {
    return $order['payment_status'] == 'pending' ? $order['total_price'] : 0;
}, $orders));

$total_completed = array_sum(array_map(function($order) {
    return $order['payment_status'] == 'completed' ? $order['total_price'] : 0;
}, $orders));

$number_of_orders = count($orders);
$number_of_products = count($products);
$number_of_users = count(array_filter($users, function($user) { return $user['user_type'] == 'user'; }));
$number_of_admins = count(array_filter($users, function($user) { return $user['user_type'] == 'admin'; }));
$number_of_accounts = count($users);
$number_of_messages = count($messages);

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin panel</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

    <div class="box">
        <?php
        $total_pendings = array_sum(array_map(function ($order) {
            return $order['payment_status'] == 'pending' ? $order['total_price'] : 0;
        }, $orders));
        ?>
        <h3>$<?php echo $total_pendings; ?>/-</h3>
        <p>total pendings</p>
    </div>

    <div class="box">
        <?php
        $total_completed = array_sum(array_map(function ($order) {
            return $order['payment_status'] == 'completed' ? $order['total_price'] : 0;
        }, $orders));
        ?>
        <h3>$<?php echo $total_completed; ?>/-</h3>
        <p>completed payments</p>
    </div>

    <div class="box">
        <h3><?php echo count($orders); ?></h3>
        <p>order placed</p>
    </div>

    <div class="box">
        <h3><?php echo count($products); ?></h3>
        <p>products added</p>
    </div>

    <div class="box">
        <?php 
        $number_of_users = count(array_filter($users, function($user) { 
            return $user['user_type'] == 'user'; 
        }));
        ?>
        <h3><?php echo $number_of_users; ?></h3>
        <p>normal users</p>
    </div>

    <div class="box">
        <?php 
        $number_of_admins = count(array_filter($users, function($user) { 
            return $user['user_type'] == 'admin'; 
        }));
        ?>
        <h3><?php echo $number_of_admins; ?></h3>
        <p>admin users</p>
    </div>

    <div class="box">
        <h3><?php echo count($users); ?></h3>
        <p>total accounts</p>
    </div>

    <div class="box">
        <h3><?php echo count($messages); ?></h3>
        <p>new messages</p>
    </div>

</div>

</section>

<!-- admin dashboard section ends -->









<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>