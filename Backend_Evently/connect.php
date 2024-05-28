<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
$servername = "localhost";
$database = "evently";
$username = "root";
$password = "";

try {
    $connexion = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // Set PDO to throw exceptions on error
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>