<?php

// Allow requests from localhost:4200
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// Connect to your database (replace with your database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evently";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Select all data from the events table
$sql = "SELECT * FROM events";
$result = $conn->query($sql);

// Initialize an array to store events data
$events = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
} else {
    // If no results are found, return an empty array
    $events = [];
}

// Return the events data as JSON
echo json_encode($events);

// Close the connection
$conn->close();

?>

