<?php

// Allow requests from localhost:4200
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Retrieve JSON data from the request body
$data = json_decode(file_get_contents("php://input"), true);

// Check if the event name is provided in the JSON data
if(isset($data['eventName'])) {
    $eventName = $data['eventName'];

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

    // Prepare SQL statement to delete the event
    $sql = "DELETE FROM events WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $eventName);

    // Execute SQL statement
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Event deleted successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error deleting event."));
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If event name is not provided
    echo json_encode(array("status" => "error", "message" => "Event name not provided."));
}

?>
