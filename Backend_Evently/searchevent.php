<?php
header("Access-Control-Allow-Origin: *");
// Allow requests with the following methods
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// Allow requests with the following headers
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Check if it's an OPTIONS request (preflight request)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // Respond with a 200 status code
    http_response_code(200);
    exit;
}

// Your PHP script logic goes here
// Handle form submission or other operations

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Database credentials
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

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("SELECT * FROM events WHERE name LIKE ?");
    $stmt->bind_param("s", $search_query);

    // Set parameter and execute the statement
    $search_query = '%' . $_GET['query'] . '%'; // Adjust for wildcard search
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Output data of each row
        $events = array();
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        // Return the events data as JSON
        echo json_encode($events);
    } else {
        echo "0 results";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // If the request method is not GET, return an error
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("error" => "Method Not Allowed"));
}
?>
