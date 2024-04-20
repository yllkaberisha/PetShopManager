<?php

session_start();

$products = include('data/products.php');

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$cart_file_path = 'data/carts.php';
$carts = file_exists($cart_file_path) ? include($cart_file_path) : [];

// Update cart item quantity
if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];

    if (isset($carts[$user_id][$cart_id])) {
        $carts[$user_id][$cart_id]['quantity'] = $cart_quantity;
        file_put_contents($cart_file_path, "<?php\nreturn " . var_export($carts, true) . ";\n");
        $message[] = 'Cart quantity updated!';
    }
}

// Delete a specific cart item
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    if (isset($carts[$user_id][$delete_id])) {
        unset($carts[$user_id][$delete_id]);
        file_put_contents($cart_file_path, "<?php\nreturn " . var_export($carts, true) . ";\n");
    }
    header('location:cart.php');
}

// Clear the cart
if (isset($_GET['delete_all'])) {
    $carts[$user_id] = [];
    file_put_contents($cart_file_path, "<?php\nreturn " . var_export($carts, true) . ";\n");
    header('location:cart.php');
}

// Load the user's cart for display
$user_cart = isset($carts[$user_id]) ? $carts[$user_id] : [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>shopping cart</h3>
   <p> <a href="home.php">home</a> / cart </p>
</div>

<section class="shopping-cart">
   <h1 class="title">products added</h1>
   <div class="box-container">
      <?php
         $grand_total = 0;
         if (!empty($user_cart)) {
            foreach ($user_cart as $index => $item) {
               // Assuming you have a function or method to fetch product details by ID
               $product = $products[$item['id'] - 1]; // Adjust based on your product ID logic
               $sub_total = $item['quantity'] * $product['price'];
               $grand_total += $sub_total;
      ?>
      <div class="box">
         <a href="cart.php?delete=<?php echo $index; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
         <img src="uploaded_img/<?php echo $product['image']; ?>" alt="">
         <div class="name"><?php echo $product['name']; ?></div>
         <div class="price">$<?php echo $product['price']; ?></div>
         <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?php echo $index; ?>">
            <input type="number" min="1" name="cart_quantity" value="<?php echo $item['quantity']; ?>" class="qty">
            <input type="submit" name="update_cart" value="update" class="option-btn">
         </form>
         <div class="sub-total"> sub total : <span>$<?php echo $sub_total; ?></span> </div>
      </div>
      <?php
            }
         } else {
            echo '<p class="empty">your cart is empty</p>';
         }
      ?>
   </div>

   <div style="margin-top: 2rem; text-align:center;">
      <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all</a>
   </div>

   <div class="cart-total">
      <p>grand total : <span>$<?php echo $grand_total; ?></span></p>
      <div class="flex">
         <a href="shop.php" class="option-btn">continue shopping</a>
         <a href="checkout.php" class="btn <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">proceed to checkout</a>
      </div>
   </div>
</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>