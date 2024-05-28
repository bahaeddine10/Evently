<?php
// Allow requests from localhost:4200
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Retrieve JSON data from the request body
$data = json_decode(file_get_contents("php://input"), true);

// Check if the id_Post and token are provided in the JSON data
if(isset($data['id_Post']) && isset($data['token'])) {
    $id_Post = $data['id_Post'];
    $token = $data['token'];

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

    // Verify token and retrieve user id_u associated with the token
    $stmt = $conn->prepare("SELECT id_u FROM session WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    // If user id_u is retrieved, proceed with deletion
    if ($user_id) {
        // Delete post where token matches session token and session id_u matches user3 id_u and user3 id_u matches post id_u and id_Post matches provided id_Post
        $sql = "DELETE post
                FROM post
                INNER JOIN user3 ON user3.id_u = post.id_u
                INNER JOIN session ON user3.id_u = session.id_u
                WHERE session.token = ? AND user3.id_u = ? AND post.id_Post = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $token, $user_id, $id_Post);

        if ($stmt->execute()) {
            echo json_encode(array("status" => "success", "message" => "Post deleted successfully."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Error deleting post: " . $conn->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("status" => "error", "message" => "Invalid token"));
    }

    // Close connection
    $conn->close();
} else {
    // If id_Post or token is not provided
    echo json_encode(array("status" => "error", "message" => "id_Post or token not provided."));
}
?>
