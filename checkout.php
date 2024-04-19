<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
}

$name_pattern = "/^[a-zA-Z ]+$/"; // Only letters and spaces
$number_pattern ="/^\d{3}-\d{3}-\d{3}$/"; // xxx-xxx-xxx pattern
$email_pattern = "/^\S+@\S+\.\S+$/"; // Email pattern
$pin_code_pattern = "/^\d{6}$/"; // 6-digit pin code
$state_pattern = "/^[a-zA-Z]+$/"; // Only letters



$user_id = $_SESSION['user_id'];
$cart_file_path = 'data/carts.php';
$carts = file_exists($cart_file_path) ? include ($cart_file_path) : [];
$products = include ('data/products.php');
$orders_file_path = 'data/orders.php';
$orders = file_exists($orders_file_path) ? include ($orders_file_path) : [];


$message = []; 
if (isset($_POST['order_btn'])) {
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $pin_code = $_POST['pin_code'];
    $state = $_POST['state'];
    $address = 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
    $placed_on = date('d-M-Y');
    $cart_total = 0;
    $cart_products = [];
    $payment_status = 'pending';

    global $valid;
$valid = true;

    if (isset($carts[$user_id]) && !empty($carts[$user_id])) {
        foreach ($carts[$user_id] as $item) {
            $product = $products[$item['id'] - 1]; // Assuming product IDs are sequential
            $cart_products[] = $product['name'] . ' (' . $item['quantity'] . ') ';
            $sub_total = ($product['price'] * $item['quantity']);
            $cart_total += $sub_total;
        }
    }

    
    if ($cart_total > 0) {
        $total_products = implode(', ', $cart_products);
        if($valid) {
        $orders[] = [
            'user_id' => $user_id,
            'name' => $name,
            'number' => $number,
            'email' => $email,
            'method' => $method,
            'address' => $address,
            'total_products' => $total_products,
            'total_price' => $cart_total,
            'placed_on' => $placed_on,
            'payment_status' => $payment_status
        ];
    }
        file_put_contents($orders_file_path, "<?php\nreturn " . var_export($orders, true) . ";\n");
        $message[] = 'Order placed successfully!';
        unset($carts[$user_id]);
        file_put_contents($cart_file_path, "<?php\nreturn " . var_export($carts, true) . ";\n");
    } else {
        $message[] = 'Your cart is empty';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>checkout</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>checkout</h3>
        <p> <a href="home.php">home</a> / checkout </p>
    </div>

    <section class="display-order">
        <h1 class="title">Products added</h1>
        <?php
        $grand_total = 0;
        if (isset($carts[$user_id]) && !empty($carts[$user_id])) {
            foreach ($carts[$user_id] as $cart_item) {
                // Assuming $products is an array of all products and $cart_item['id'] directly relates to $products['id']
                foreach ($products as $product) {
                    if ($product['id'] == $cart_item['id']) {
                        $total_price = ($product['price'] * $cart_item['quantity']);
                        $grand_total += $total_price;
                        echo "<p> {$product['name']} <span>($" . $product['price'] . "/- x " . $cart_item['quantity'] . ")</span> </p>";
                        break; // Found the product, no need to continue the loop
                    }
                }
            }
        } else {
            echo '<p class="empty">Your cart is empty</p>';
        }
        ?>
        <div class="grand-total">Grand total: <span>$<?php echo $grand_total; ?>/-</span></div>
    </section>

    <section class="checkout">

        <form action="" method="post">
            <h3>place your order</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>your name :</span>
                    <input type="text" name="name" required placeholder="enter your name">
                    <?php if (isset($_POST['name']) && !preg_match($name_pattern, $name)) {
                        echo "<p style='color:red'>Invalid name format. Please enter letters and spaces only.</p>";
                        $valid = false;
                    } ?>
                </div>
                <div class="inputBox">
                    <span>your number :</span>
                    <input type="text" name="number" required placeholder="enter your number">
                    <?php // Validate number
                    if (isset($_POST['number']) && !preg_match($number_pattern, $number)) {
                        echo "<p style='color:red'>Invalid number format. Please enter a 9-digit number in this format: xxx-xxx-xxx</p>";
                        $valid = false;
                    } ?>
                </div>
                <div class="inputBox">
                    <span>your email :</span>
                    <input type="email" name="email" required placeholder="enter your email">
                    <?php if (isset($_POST['email']) && !preg_match($email_pattern, $email)) {
                        echo "<p style='color:red'>Invalid email format. Please enter a valid email address.</p>";
                        $valid = false;
                    } ?>
                </div>
                <div class="inputBox">
                    <span>payment method :</span>
                    <select name="method">
                        <option value="cash on delivery">cash on delivery</option>
                        <option value="credit card">credit card</option>
                        <option value="paypal">paypal</option>
                        <option value="paytm">paytm</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>address line 01 :</span>
                    <input type="number" min="0" name="flat" required placeholder="e.g. flat no.">
                </div>
                <div class="inputBox">
                    <span>address line 01 :</span>
                    <input type="text" name="street" required placeholder="e.g. street name">
                </div>
                <div class="inputBox">
                    <span>city :</span>
                    <input type="text" name="city" required placeholder="e.g. mumbai">
                </div>
                <div class="inputBox">
                    <span>state :</span>
                    <input type="text" name="state" required placeholder="e.g. maharashtra">
                    <?php if (isset($_POST['state']) && !preg_match($state_pattern, $state)) {
                        echo "<p style='color:red'>Invalid state format. Please enter letters only.</p>";
                        $valid = false;
                    } ?>
                </div>
                <div class="inputBox">
                    <span>country :</span>
                    <input type="text" name="country" required placeholder="e.g. india">
                </div>
                <div class="inputBox">
                    <span>pin code :</span>
                    <input type="number" min="0" name="pin_code" required placeholder="e.g. 123456">
                    <?php // Validate pin code
                    if (isset($_POST['pin_code']) && !preg_match($pin_code_pattern, $pin_code)) {
                        echo "<p style='color:red'>Invalid pin code format. Please enter a 6-digit number.</p>";
                        $valid = false;
                    } ?>
                </div>
            </div>
            <input type="submit" value="order now" class="btn" name="order_btn">
        </form>

    </section>









    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>