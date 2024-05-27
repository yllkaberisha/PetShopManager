<?php

include '../config.php';

$response = array('status' => 'error', 'message' => 'Unknown error occurred.');

if(isset($_POST['update_p_id'])){

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    $update_image = $_FILES['update_image']['name'];
    $update_old_image = $_POST['update_old_image'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_image_folder = '../uploaded_img/'.$update_image;

    if (!empty($update_image)) {
        if ($update_image_size > 2000000) {
            $response['message'] = 'Image file size is too large';
        } else {
            $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price', image = '$update_image' WHERE id = '$update_p_id'") or die(json_encode(array('status' => 'error', 'message' => 'Query failed')));
            if ($update_query) {
                if (move_uploaded_file($update_image_tmp_name, $update_image_folder)) {
                    unlink('../uploaded_img/'.$update_old_image);
                    $response = array('status' => 'success', 'message' => 'Product updated successfully!');
                } else {
                    $response['message'] = 'Failed to upload image';
                }
            } else {
                $response['message'] = 'Product could not be updated!';
            }
        }
    } else {
        $update_query = mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die(json_encode(array('status' => 'error', 'message' => 'Query failed')));
        if ($update_query) {
            $response = array('status' => 'success', 'message' => 'Product updated successfully!');
        } else {
            $response['message'] = 'Product could not be updated!';
        }
    }
} else {
    $response['message'] = 'Invalid request';
}

echo json_encode($response);
?>
