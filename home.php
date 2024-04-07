<?php

session_start();

if(!isset($_SESSION['user_id'])){
   header('location:login.php');
   exit();
}

// Initialize cart if it doesn't exist
if(!isset($_SESSION['cart'])){
   $_SESSION['cart'] = array();
}

$products = include('data/products.php');

if(isset($_POST['add_to_cart'])){
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   // Check if product is already in cart
   $found_in_cart = false;
   foreach($_SESSION['cart'] as $item){
      if($item['name'] === $product_name){
         $found_in_cart = true;
         $message[] = 'Product already added to cart!';
         break;
      }
   }

   if(!$found_in_cart){
      $_SESSION['cart'][] = ['name' => $product_name, 'price' => $product_price, 'quantity' => $product_quantity, 'image' => $product_image];
      $message[] = 'Product added to cart!';
   }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">

   <div class="content">
      <h3>Hand Picked Book to your door.</h3>
      <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quod? Reiciendis ut porro iste totam.</p>
      <a href="about.php" class="white-btn">discover more</a>
   </div>

</section>

<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">
   <?php foreach($products as $product): ?>
   <form action="" method="post" class="box">
      <img class="image" src="uploaded_img/<?php echo $product['image']; ?>" alt="">
      <div class="name"><?php echo $product['name']; ?></div>
      <div class="price">$<?php echo $product['price']; ?>/-</div>
      <input type="number" min="1" name="product_quantity" value="1" class="qty">
      <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
      <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
      <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
      <input type="submit" value="add to cart" name="add_to_cart" class="btn">
   </form>
   <?php endforeach; ?>
</div>


   <div class="load-more" style="margin-top: 2rem; text-align:center">
      <a href="shop.php" class="option-btn">load more</a>
   </div>

</section>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/about-img.jpg" alt="">
      </div>

      <div class="content">
         <h3>about us</h3>
         <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Impedit quos enim minima ipsa dicta officia corporis ratione saepe sed adipisci?</p>
         <a href="about.php" class="btn">read more</a>
      </div>

   </div>

</section>

<section class="home-contact">

   <div class="content">
      <h3>have any questions?</h3>
      <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Atque cumque exercitationem repellendus, amet ullam voluptatibus?</p>
      <a href="contact.php" class="white-btn">contact us</a>
   </div>

</section>





<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>