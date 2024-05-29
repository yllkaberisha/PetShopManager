<?php
// Funksioni për trajtimin e gabimeve
function error_handler($errno, $errstr, $errfile, $errline, $errcontext) {
    echo "<b>Gabim:</b> [$errno] $errstr - Në skedarin '$errfile' në rreshtin $errline<br />";
    echo "Konteksti: " . json_encode($errcontext) . "<br />";
    echo "Mënyra e shkëputjes: Die()<br />";
    die();
}
// Vendosim funksionin e trajtimit të gabimeve
set_error_handler("error_handler");

include 'config.php';

// Funksioni që kontrollon nëse tabela ekziston
function tableExists($conn, $tableName) {
    $result = $conn->query("SHOW TABLES LIKE '$tableName'");
    return $result->num_rows > 0;
}

// Krijo tabelat nëse ato nuk ekzistojnë
try {
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
            throw new Exception("Gabim gjatë krijimit të tabeles 'cart': " . $conn->error);
        }
    }

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
            throw new Exception("Gabim gjatë krijimit të tabeles 'message': " . $conn->error);
        }
    }
} catch (Exception $e) {
    echo 'Gabim: ' . $e->getMessage();
}

// Mbyll lidhjen me bazën e të dhënave
$conn->close();
?>
