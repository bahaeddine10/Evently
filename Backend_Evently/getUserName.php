<?php
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

require_once 'connect.php';

// Check if the token is provided in the request
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Fetch user name from the database based on token
    $sql = "SELECT firstname FROM user3 
            INNER JOIN session ON user3.id_u = session.id_u
            WHERE session.token = '$token'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstame = $row['firstname'];

        // Return user name as JSON response
        echo json_encode(array("firstname" => $firstname));
    } else {
        echo json_encode(array("error" => "User not found"));
    }
} else {
    echo json_encode(array("error" => "Token not provided"));
}


?>
