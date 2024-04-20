<?php



session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

$products_file = 'data/products.php';
$products = file_exists($products_file) ? include($products_file) : [];

// Define a function to save products back to the file
function saveProductsToFile($products, $products_file) {
    file_put_contents($products_file, "<?php\nreturn " . var_export($products, true) . ";\n");
}


if (isset($_POST['add_product'])) {
   $name = $_POST['name'];
   $price = $_POST['price'];
   $image_name = $_FILES['image']['name'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_img/' . $image_name;

   // Assign a new ID (increment last ID)
   $new_id = !empty($products) ? max(array_column($products, 'id')) + 1 : 1;

   // Add product to array
   $products[] = [
       'id' => $new_id,
       'name' => $name,
       'price' => $price,
       'image' => $image_name,
   ];

   move_uploaded_file($image_tmp_name, $image_folder);
   saveProductsToFile($products, $products_file);
   $message[] = 'Product added successfully!';
}


if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   foreach ($products as $index => $product) {
       if ($product['id'] == $delete_id) {
           array_splice($products, $index, 1);
           unlink('uploaded_img/' . $product['image']);
           saveProductsToFile($products, $products_file);
           header('location:admin_products.php');
           exit();
       }
   }
}

// Sortimi i produkteve nga emri dhe cmimi

$sortOrder = isset($_POST['sort_order']) ? $_POST['sort_order'] : 'az';
$sortBy = isset($_POST['sort_by']) ? $_POST['sort_by'] : 'name';

switch ($sortBy) {
    case 'name':
        if ($sortOrder == 'az') {
            sort($products);
        } else {
            rsort($products);
        }
        break;
    case  'price':
        if ($sortOrder == 'az') {
            uasort($products, function($a, $b) {
                return $a['price'] <=> $b['price'];
            });
        } else {
            uasort($products, function($a, $b) {
                return $b['price'] <=> $a['price'];
            });
        }
        break;
}


if (isset($_POST['update_product'])) {
   $update_p_id = $_POST['update_p_id'];
   $update_name = $_POST['update_name'];
   $update_price = $_POST['update_price'];
   $update_old_image = $_POST['update_old_image'];

   $update_image = $_FILES['update_image']['name'];
   $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
   $image_folder = 'uploaded_img/'.$update_image;

   foreach ($products as &$product) {
       if ($product['id'] == $update_p_id) {
           $product['name'] = $update_name;
           $product['price'] = $update_price;

           if (!empty($update_image)) {
               if (file_exists('uploaded_img/'.$update_old_image)) {
                   unlink('uploaded_img/'.$update_old_image); // Delete old image
               }
               move_uploaded_file($update_image_tmp_name, $image_folder);
               $product['image'] = $update_image; // Update to new image name
           }

           break;
       }
   }

   saveProductsToFile($products, $products_file);
   header('location:admin_products.php');
   exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<!-- product CRUD section starts  -->


<section class="add-products">

   <h1 class="title">shop products</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <h3>add product</h3>
      <input type="text" name="name" class="box" placeholder="enter product name" required>
      <input type="number" min="0" name="price" class="box" placeholder="enter product price" required>
      <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>

</section>


<!-- product CRUD section ends -->

<!-- Sortimi -->
<div class="sort-dropdown">
       <form action="" method="post">
           <label for="sort_by">Sort by:</label>
           <select id="sort_by" name="sort_by" onchange="this.form.submit()">
               <option value="name" <?php echo $sortBy == 'name' ? 'selected' : ''; ?>>Name</option>
               <option value="price" <?php echo $sortBy == 'price' ? 'selected' : ''; ?>>Price</option>
           </select>
           <select id="sort_order" name="sort_order" onchange="this.form.submit()">
           <option value="za" <?php echo $sortOrder == 'za' ? 'selected' : ''; ?>>A-Z or High-Low</option>
               <option value="az" <?php echo $sortOrder == 'az' ? 'selected' : ''; ?>>Z-A or Low-High</option>
               
           </select>
       </form>
   </div>


<!-- show products  -->

<section class="show-products">
    <div class="box-container">
        


        <?php 
        
        foreach ($products as $product): ?>
        <div class="box">
            <img src="uploaded_img/<?php echo $product['image']; ?>" alt="">
            <div class="name"><?php echo $product['name']; ?></div>
            <div class="price">$<?php echo $product['price']; ?></div>
            <a href="admin_products.php?update=<?php echo $product['id']; ?>" class="option-btn">update</a>
            <a href="admin_products.php?delete=<?php echo $product['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
        </div>
        <?php endforeach; ?>
        <?php if (empty($products)): ?>
            <p class="empty">No products added yet!</p>
        <?php endif; ?>
    </div>
</section>

<section class="edit-product-form">
   <!-- Update Product Form - Make sure to handle the display logic for this form when an update action is triggered -->
   <?php
   if(isset($_GET['update'])){
       $update_id = $_GET['update'];
       foreach ($products as $product) {
           if ($product['id'] == $update_id) {
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $product['id']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $product['image']; ?>">
      <img src="uploaded_img/<?php echo $product['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $product['name']; ?>" class="box" required>
      <input type="number" name="update_price" value="<?php echo $product['price']; ?>" min="0" class="box" required>
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="btn">
   </form>
   <?php
         }
      }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>
</section>






<!-- custom admin js file link  -->
<script src="js/admin_script.js"></script>

</body>
</html>