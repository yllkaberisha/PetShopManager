<?php

$isLocal = $_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1';

if ($isLocal) {
    // Local connection
    $servername = "localhost:3307";
    $username = "root";
    $password = "";
    $dbname = "shop_db";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
} else {
    // Cloud connection using env variables set in app.yaml
    $user = getenv('CLOUDSQL_USER');
    $pass = getenv('CLOUDSQL_PASSWORD');
    $inst = getenv('CLOUDSQL_DSN');
    $db   = getenv('CLOUDSQL_DB');

    $conn = mysqli_connect(null, $user, $pass, $db, null, $inst);
}

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>