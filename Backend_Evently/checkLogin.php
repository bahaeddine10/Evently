<?php
// Allow from a specific origin
$allowedOrigins = array(
    'http://localhost:4200',  // Update this with the actual origin of your Angular application
);

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    exit(0);
}
require "connect.php";

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the input data from the request body
    $data = json_decode(file_get_contents("php://input"));

    // Check if the required fields are present
    if (isset($data->email) && isset($data->password)) {
        $email = htmlspecialchars(strip_tags($data->email));
        $password = htmlspecialchars(strip_tags($data->password));

        // Prepare and execute the SQL query to check the user credentials
        $query = "SELECT * FROM user3 WHERE email = :email";
        $stmt = $connexion->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify the password
        if ($user && $password === $user['password']) {
            $token = bin2hex(random_bytes(32)); // Example: Generates a 64-character hexadecimal token
            
            // Save the token in the database or session
            $query = "INSERT INTO session (id_u, token) VALUES (:id_u, :token)";
            $stmt = $connexion->prepare($query);
            $stmt->bindParam(":id_u", $user['id_u']); // Assuming id_u is the column name
            $stmt->bindParam(":token", $token);
            $stmt->execute();

            // Return the token to the client
            http_response_code(200);
            echo json_encode(array("token" => $token, "message" => "Login successful"));
        } else {
            // Invalid credentials
            http_response_code(401);
            echo json_encode(array("message" => "Invalid email or password"));
        }
    } else {
        // Missing email or password
        http_response_code(400);
        echo json_encode(array("message" => "Email and password are required"));
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode(array("message" => "Method Not Allowed"));
}
?>


