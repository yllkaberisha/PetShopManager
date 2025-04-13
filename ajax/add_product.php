<?php

include dirname(__DIR__) . '/config.php';

$response = array('status' => 'error', 'message' => 'Unknown error occurred.');

if(isset($_POST['name'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/'.$image; // Correct the folder path

    $select_product_name = mysqli_query($conn, "SELECT name FROM `products` WHERE name = '$name'") or die(json_encode(array('status' => 'error', 'message' => 'Query failed')));

    if(mysqli_num_rows($select_product_name) > 0){
        $response['message'] = 'Product name already added';
    } else {
        $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image) VALUES('$name', '$price', '$image')") or die(json_encode(array('status' => 'error', 'message' => 'Query failed')));

        if($add_product_query) {
            if($image_size > 2000000) {
                $response['message'] = 'Image size is too large';
            } else {
                if(move_uploaded_file($image_tmp_name, $image_folder)) {
                    $response = array('status' => 'success', 'message' => 'Product added successfully!');
                } else {
                    $response['message'] = 'Failed to upload image';
                }
            }
        } else {
            $response['message'] = 'Product could not be added!';
        }
    }
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>
