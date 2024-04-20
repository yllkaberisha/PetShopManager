<?php

session_start();

// Check if the color preference cookie is set
if (isset($_COOKIE['background_color'])) {
    $background_color = $_COOKIE['background_color'];
} else {
    $background_color = ''; // Default color if the cookie is not set
}

// Check if the text color preference cookie is set
if (isset($_COOKIE['text_color'])) {
    $text_color = $_COOKIE['text_color'];
} else {
    $text_color = ''; // Default color if the cookie is not set
}

// Check if the image preference cookie is set
if (isset($_COOKIE['logo'])) {
    $logo = $_COOKIE['logo'];
} else {
    $logo = ''; // Default image if the cookie is not set
}

// Check if the font size preference cookie is set
if (isset($_COOKIE['font_size'])) {
    $font_size = $_COOKIE['font_size'];
} else {
    $font_size = ''; // Default font size if the cookie is not set
}

// Check if the font family preference cookie is set
if (isset($_COOKIE['font_family'])) {
    $font_family = $_COOKIE['font_family'];
} else {
    $font_family = ''; // Default font family if the cookie is not set
}

$user_id = $_SESSION['user_id'];

// Check if the form is submitted
if (isset($_POST['change_btn'])) {
    // Get the submitted preferences
    $color = $_POST['color'];
    $txtcolor = $_POST['txtcolor'];
    $image = $_POST['image'];
    $fontfamily = $_POST['fontfamily'];
    // Set the cookies for preferences
    setcookie('background_color', $color, time() + (86400 * 30), "/");
    setcookie('text_color', $txtcolor, time() + (86400 * 30), "/");
    setcookie('logo', $image, time() + (86400 * 30), "/");
    setcookie('font_family', $fontfamily, time() + (86400 * 30), "/");
    // Reload the page to reflect the changes
    header("Refresh:0");
    exit();
}

// Check if the "Clear cookies" button is clicked
if (isset($_POST['clear_btn'])) {
    // Clear all cookies
    setcookie('background_color', '', time() - 3600, "/");
    setcookie('text_color', '', time() - 3600, "/");
    setcookie('logo', '', time() - 3600, "/");
    setcookie('font_family', '', time() - 3600, "/");
    // Reload the page to reflect the changes
    header("Refresh:0");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>preferences</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            background-color:
                <?php echo $background_color; ?>
            ;
            color:
                <?php echo $text_color; ?>
            ;
            font-family:
                <?php echo $font_family; ?>
            ;
        }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="checkout">

        <form action="" method="post">
            <h3>Change your preferences </h3>
            <p>
                <?php
                eval ('?>' . $_SESSION['timesVisited']);
                func();
                ?>

            </p>

            <div class="flex">
                <div class="inputBox">
                    <span>Background color:</span>
                    <input type="text" name="color" placeholder="Enter your color"
                        value="<?php echo $background_color; ?>">
                </div>
                <div class="inputBox">
                    <span>Text color:</span>
                    <input type="text" name="txtcolor" placeholder="Enter your color"
                        value="<?php echo $text_color; ?>">
                </div>
                <div class="inputBox">
                    <span>Logo URL:</span>
                    <input type="text" name="image" placeholder="Enter image URL" value="<?php echo $logo; ?>">
                </div>

                <div class="inputBox">
                    <span>Font family:</span>
                    <input type="text" name="fontfamily" placeholder="Enter font family"
                        value="<?php echo $font_family; ?>">
                </div>
            </div>
            <input type="submit" value="Change now" class="btn" name="change_btn">
            <input type="submit" value="Clear cookies" class="btn" name="clear_btn">
        </form>

    </section>

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>