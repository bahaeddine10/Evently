<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $json_data = file_get_contents("php://input");
    $event_data = json_decode($json_data, true);
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "evently";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO events (name, description, capacity, details, date_e) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $name, $description, $capacity, $details, $date);
    $name = $event_data['name'];
    $description = $event_data['description'];
    $capacity = $event_data['capacity'];
    $details = $event_data['details'];
    $date = $event_data['date_e'];
    $stmt->execute();
    $stmt->close();
    $conn->close();
    $response = array("success" => true);
    echo json_encode($response);
} else {
    http_response_code(405);
    echo json_encode(array("error" => "Method Not Allowed"));
}
?>
