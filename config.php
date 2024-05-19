<?php

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "shop_db";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// echo "Connected successfully";


// Funksioni që kontrollon nëse tabela ekziston
function tableExists($conn, $tableName) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result->num_rows > 0;
}

// Krijo tabelat nëse ato nuk ekzistojnë
if (!tableExists($conn, 'cart')) {
    $sql = "CREATE TABLE `cart` (
      `id` int(11) NOT NULL,
      `user_id` int(100) NOT NULL,
      `name` varchar(100) NOT NULL,
      `price` int(100) NOT NULL,
      `quantity` int(100) NOT NULL,
      `image` varchar(100) NOT NULL,
      PRIMARY KEY (`id`)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Tabela 'cart' u krijua me sukses!";
    } else {
        echo "Gabim gjatë krijimit të tabeles 'cart': " . $conn->error;
    }
}
// Krijo tabelën 'message' nëse nuk ekziston
if (!tableExists($conn, 'message')) {
    $sql = "CREATE TABLE `message` (
      `id` int(100) NOT NULL,
      `user_id` int(100) NOT NULL,
      `name` varchar(100) NOT NULL,
      `email` varchar(100) NOT NULL,
      `number` varchar(12) NOT NULL,
      `message` varchar(500) NOT NULL,
      PRIMARY KEY (`id`)
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Tabela 'message' u krijua me sukses!";
    } else {
        echo "Gabim gjatë krijimit të tabeles 'message': " . $conn->error;
    }
}

// Mbyll lidhjen me bazën e të dhënave
$conn->close();

?>
