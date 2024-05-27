<?php

include '../config.php';

$response = array('status' => 'error', 'message' => 'Unknown error occurred.');

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$id'") or die(json_encode(array('status' => 'error', 'message' => 'Query failed')));
    if (mysqli_num_rows($select_product) > 0) {
        $fetch_product = mysqli_fetch_assoc($select_product);
        echo json_encode($fetch_product);
        exit;
    } else {
        $response['message'] = 'Product not found';
    }
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>
