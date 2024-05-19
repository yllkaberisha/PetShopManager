<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
   exit();
}

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($check_cart_numbers) > 0){
      $message[] = 'already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
      $message[] = 'product added to cart!';
   }

}

// Fetch products from the database
$products = [];
$select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
if(mysqli_num_rows($select_products) > 0){
    while($fetch_products = mysqli_fetch_assoc($select_products)){
        $products[] = $fetch_products;
    }
}

// Sort products
$sortOrder = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'az';

switch ($sortOrder) {
    case 'az':
        usort($products, function($a, $b) {
            return strcmp($a['name'], $b['name']);
        });
        break;
    case 'za':
        usort($products, function($a, $b) {
            return strcmp($b['name'], $a['name']);
        });
        break;
    case 'high-low':
        usort($products, function($a, $b) {
            return $b['price'] <=> $a['price'];
        });
        break;
    case 'low-high':
        usort($products, function($a, $b) {
            return $a['price'] <=> $b['price'];
        });
        break;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>our shop</h3>
   <p> <a href="home.php">home</a> / shop </p>
</div>
   <!--Metoda per sortim -->
   <div class="sort-dropdown">
       <form action="" method="post">
           <label for="sort">Sort by:</label>
           <select id="sort" name="sort_order" onchange="this.form.submit()">
               <option value="az" <?php echo $sortOrder == 'az' ? 'selected' : ''; ?>>Name (A-Z)</option>
               <option value="za" <?php echo $sortOrder == 'za' ? 'selected' : ''; ?>>Name (Z-A)</option>
               <option value="high-low" <?php echo $sortOrder == 'high-low' ? 'selected' : ''; ?>>Price (High-Low)</option>
               <option value="low-high" <?php echo $sortOrder == 'low-high' ? 'selected' : ''; ?>>Price (Low-High)</option>
           </select>
       </form>
   </div>


<section class="products">

   <h1 class="title">latest products</h1>

   <div class="box-container">

      <?php  
         if(!empty($products)){
            foreach($products as $fetch_products){
      ?>
      <form action="" method="post" class="box">
         <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
         <div class="name"><?php echo $fetch_products['name']; ?></div>
         <div class="price">$<?php echo $fetch_products['price']; ?></div>
         <input type="number" min="1" name="product_quantity" value="1" class="qty">
         <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
         <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
         <input type="hidden" name="product_image" value="./uploaded_img/<?php echo $fetch_products['image']; ?>">
         <input type="submit" value="add to cart" name="add_to_cart" class="btn">
      </form>
      <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
      ?>
   </div>

</section>

<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
