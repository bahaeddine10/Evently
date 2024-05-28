<?php
require "connect.php";

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

$method = $_SERVER["REQUEST_METHOD"];

if ($method === 'POST') {
    $data = file_get_contents("php://input");
    $inputs = json_decode($data, true);
    

    if (
        isset($inputs["firstname"]) &&
        isset($inputs["lastname"]) &&
        isset($inputs["email"]) &&
        isset($inputs["password"]) &&
        isset($inputs["telephone"])
    ) {
        $firstname = htmlspecialchars(strip_tags($inputs["firstname"]));
        $lastname = htmlspecialchars(strip_tags($inputs["lastname"]));
        $email = htmlspecialchars(strip_tags($inputs["email"]));
        $password = htmlspecialchars(strip_tags($inputs["password"]));
        $telephone = htmlspecialchars(strip_tags($inputs["telephone"]));
        
        $prepared = $connexion->prepare("INSERT INTO user3 (firstname, lastname, email, password, telephone) VALUES (:firstname, :lastname, :email, :password, :telephone)");

        $prepared->bindParam(":firstname", $firstname);
        $prepared->bindParam(":lastname", $lastname);
        $prepared->bindParam(":email", $email);
        $prepared->bindParam(":password", $password);
        $prepared->bindParam(":telephone", $telephone);

        $response = [];

        try {
            $result = $prepared->execute();
            if ($result) {
                $response["msg"] = "success insertion";
            } else {
                $response["msg"] = "failed insertion";
            }
        } catch (PDOException $e) {
            $response["msg"] = "SQL error: " . $e->getMessage();
        }
    } else {
        $response["msg"] = "Missing required input data";
    }

    echo json_encode($response);
} else {
    echo json_encode(["msg" => "Invalid request method"]);
}
?>
                