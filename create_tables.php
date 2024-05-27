<?php
// Funksioni që kontrollon nëse tabela ekziston
function tableExists($conn, $tableName) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result->num_rows > 0;
}

include 'config.php';

// Array containing all the table creation SQL statements
$tables = [
    'cart' => "CREATE TABLE `cart` (
        `id` int(11) NOT NULL,
        `user_id` int(100) NOT NULL,
        `name` varchar(100) NOT NULL,
        `price` int(100) NOT NULL,
        `quantity` int(100) NOT NULL,
        `image` varchar(100) NOT NULL,
        PRIMARY KEY (`id`)
    )",
    'message' => "CREATE TABLE `message` (
        `id` int(100) NOT NULL,
        `user_id` int(100) NOT NULL,
        `name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `number` varchar(12) NOT NULL,
        `message` varchar(500) NOT NULL,
        PRIMARY KEY (`id`)
    )",
    'orders' => "CREATE TABLE `orders` (
        `id` int(100) NOT NULL,
        `user_id` int(100) NOT NULL,
        `name` varchar(100) NOT NULL,
        `number` varchar(12) NOT NULL,
        `email` varchar(100) NOT NULL,
        `method` varchar(50) NOT NULL,
        `address` varchar(500) NOT NULL,
        `total_products` varchar(1000) NOT NULL,
        `total_price` int(100) NOT NULL,
        `placed_on` varchar(50) NOT NULL,
        `payment_status` varchar(20) NOT NULL DEFAULT 'pending',
        PRIMARY KEY (`id`)
    )",
    'products' => "CREATE TABLE `products` (
        `id` int(100) NOT NULL,
        `name` varchar(100) NOT NULL,
        `price` int(100) NOT NULL,
        `image` varchar(100) NOT NULL,
        PRIMARY KEY (`id`)
    )",
    'users' => "CREATE TABLE `users` (
        `id` int(100) NOT NULL,
        `name` varchar(100) NOT NULL,
        `email` varchar(100) NOT NULL,
        `password` varchar(100) NOT NULL,
        `user_type` varchar(20) NOT NULL DEFAULT 'user',
        PRIMARY KEY (`id`)
    )"
];

// Loop through the tables array and create each table if it doesn't exist
foreach ($tables as $tableName => $sql) {
    if (!tableExists($conn, $tableName)) {
        if ($conn->query($sql) === TRUE) {
            echo "Tabela '$tableName' u krijua me sukses!<br>";
        } else {
            echo "Gabim gjatë krijimit të tabeles '$tableName': " . $conn->error . "<br>";
        }
    }
}

// Mbyll lidhjen me bazën e të dhënave
$conn->close();
?>
