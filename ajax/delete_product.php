<?php

include dirname(__DIR__) . '/config.php';


$response = array('status' => 'error', 'message' => 'Unknown error occurred.');

if(isset($_POST['id'])){
    $delete_id = $_POST['id'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die(json_encode(array('status' => 'error', 'message' => 'Query failed')));
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    if (unlink('../uploaded_img/'.$fetch_delete_image['image'])) {
        $delete_product_query = mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die(json_encode(array('status' => 'error', 'message' => 'Query failed')));
        if ($delete_product_query) {
            $response = array('status' => 'success', 'message' => 'Product deleted successfully');
        } else {
            $response['message'] = 'Failed to delete product';
        }
    } else {
        $response['message'] = 'Failed to delete image';
    }
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>
