<?php


session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

$cart_file_path = 'data/carts.php';
$carts = file_exists($cart_file_path) ? include($cart_file_path) : [];


if(isset($_POST['add_to_cart'])){

   $product_id = $_POST['product_id'];
   $product_quantity = $_POST['product_quantity'];

   if (!isset($carts[$user_id])) {
      $carts[$user_id] = [];
  }

  $found = false;
    foreach ($carts[$user_id] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity'] += $product_quantity;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $carts[$user_id][] = ['id' => $product_id, 'quantity' => $product_quantity];
    }

    file_put_contents($cart_file_path, "<?php\nreturn " . var_export($carts, true) . ";\n");

    $message[] = 'Product added to cart!';


}
$products = include('data/products.php');




// Renditja e produkteve sipas zgjedhjes së përdoruesit
// Renditja e produkteve sipas zgjedhjes së përdoruesit
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
</div>
<!-- -->


<section class="products">

   <h1 class="title">All products</h1>

   <div class="box-container">
      <?php if (!empty($products)): ?>
         <?php foreach ($products as $product): ?>
            <form action="" method="post" class="box">
               <img class="image" src="uploaded_img/<?php echo $product['image']; ?>" alt="">
               <div class="name"><?php echo $product['name']; ?></div>
               <div class="price">$<?php echo $product['price']; ?></div>
               <input type="number" min="1" name="product_quantity" value="1" class="qty">
               <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
               <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
            </form>
         <?php endforeach; ?>
      <?php else: ?>
         <p class="empty">No products added yet!</p>
      <?php endif; ?>
   </div>

</section>








<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
