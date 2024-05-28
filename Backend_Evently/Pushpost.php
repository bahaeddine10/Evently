<?php
require "connect.php";
header("Access-Control-Allow-Origin: http://localhost:4200"); // Update with your frontend URL
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$method = $_SERVER["REQUEST_METHOD"];

if ($method === 'POST') {
    $data = file_get_contents("php://input");
    $inputs = json_decode($data, true);

    if (isset($inputs["Date_Publish"]) && isset($inputs["textPost"]) && isset($inputs["token"])) {
        $dp = $inputs["Date_Publish"];
        $tp = $inputs["textPost"];
        $token = $inputs["token"];

        global $connexion;

        // First, fetch the user ID associated with the provided token
        $getUserStmt = $connexion->prepare("SELECT id_u FROM session WHERE token = :token");
        $getUserStmt->bindParam(":token", $token);
        $getUserStmt->execute();
        $userRow = $getUserStmt->fetch(PDO::FETCH_ASSOC);
        $userId = $userRow['id_u'];

        // Next, insert the post into the post table, associating it with the user
        $insertPostStmt = $connexion->prepare("INSERT INTO post (Date_Publish, textPost, id_u) SELECT :dp, :tp, id_u FROM user3 WHERE id_u = :userId");
        $insertPostStmt->bindParam(":dp", $dp);
        $insertPostStmt->bindParam(":tp", $tp);
        $insertPostStmt->bindParam(":userId", $userId);
        
        $response = [];

        try {
            $result = $insertPostStmt->execute();     
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