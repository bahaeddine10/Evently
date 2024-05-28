<?php
header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evently";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM post ";
$result = $conn->query($sql);


$posts = array();

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
} else {
    
    $posts = [];
}

echo json_encode($posts);

$conn->close();
?>