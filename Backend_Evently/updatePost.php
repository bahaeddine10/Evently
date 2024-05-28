<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "evently";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

$textPost = $conn->real_escape_string($request->textPost);
$id_Post = $conn->real_escape_string($request->id_Post); // New field for id_Post

// Get token from request headers
$token = $_SERVER['HTTP_TOKEN'];

// Verify token
$stmt = $conn->prepare("SELECT id_u FROM session WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$stmt->bind_result($userId);
$stmt->fetch();
$stmt->close();

// Check if token is valid
if ($userId) {
  // Update post where token matches session token and user3 id_u matches post id_u
  $sql = "UPDATE post
          INNER JOIN user3 ON user3.id_u = post.id_u
          INNER JOIN session ON user3.id_u = session.id_u
          SET post.textPost = ?
          WHERE session.token = ? AND user3.id_u = post.id_u AND post.id_Post = ?";
  
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ssi", $textPost, $token, $id_Post); // Binding id_Post as parameter

  if ($stmt->execute()) {
    echo json_encode(array("status" => "success"));
  } else {
    echo json_encode(array("status" => "error", "message" => "Error updating event: " . $conn->error));
  }

  $stmt->close();
} else {
  echo json_encode(array("status" => "error", "message" => "Invalid token"));
}

$conn->close();
?>
