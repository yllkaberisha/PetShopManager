<?php

include '../config.php';

$sort_order = $_POST['sort_order'];
$order_query = '';

switch ($sort_order) {
    case 'az':
        $order_query = 'ORDER BY name ASC';
        break;
    case 'za':
        $order_query = 'ORDER BY name DESC';
        break;
    case 'high-low':
        $order_query = 'ORDER BY price DESC';
        break;
    case 'low-high':
        $order_query = 'ORDER BY price ASC';
        break;
    default:
        $order_query = 'ORDER BY name ASC';
        break;
}

$products = mysqli_query($conn, "SELECT * FROM `products` $order_query") or die('query failed');

while($product = mysqli_fetch_assoc($products)) {
    echo '<div class="box">';
    echo '<img src="uploaded_img/'.$product['image'].'" alt="">';
    echo '<div class="name">'.$product['name'].'</div>';
    echo '<div class="price">$'.$product['price'].'</div>';
    echo '<button class="option-btn" style="margin-right:5px" onclick="editProduct('.$product['id'].')">Update</button>';
    echo '<button class="delete-btn" onclick="deleteProduct('.$product['id'].')">Delete</button>';
    echo '</div>';
}
?>
