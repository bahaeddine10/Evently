<?php
// Set headers to allow CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evently";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log database connection error
    error_log("Database Connection Error: " . $conn->connect_error);
    // Send error response
    echo json_encode(array("success" => false, "error" => "Database Connection Error"));
    // Terminate script execution
    exit();
}

// Get email and password from POST request
$email = $_POST['email'] ?? ''; // Use isset or the null coalescing operator to handle undefined indexes
$password = $_POST['password'] ?? '';

// Log email and password
error_log("Email: $email");
error_log("Password: $password");

// Prepare SQL statement with prepared statements
$stmt = $conn->prepare("SELECT * FROM login WHERE email=?");
$stmt->bind_param("s", $email); // 's' indicates a string parameter
$stmt->execute();
$result = $stmt->get_result();

// Log SQL query
error_log("SQL: " . $stmt->error);

// Check if user exists
if ($result->num_rows > 0) {
    // User exists, fetch the stored password hash
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];

    // Log stored password hash
    error_log("Stored Password Hash: $stored_password");

    // Verify the provided password against the stored password hash
    if (password_verify($password, $stored_password)) {
        // Passwords match, send success response
        $response = array("success" => true);
    } else {
        // Passwords do not match, send failure response
        $response = array("success" => false, "error" => "Invalid email or password");
    }
} else {
    // User does not exist, send failure response
    $response = array("success" => false, "error" => "Invalid email or password");
}

// Send JSON response
echo json_encode($response);

// Close prepared statement and database connection
$stmt->close();
$conn->close();
?>
