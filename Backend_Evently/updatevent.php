<?php
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

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

$id = $request->id_e; // Get the id from the request
$name = $conn->real_escape_string($request->name);
$description = $conn->real_escape_string($request->description);
$capacity = $conn->real_escape_string($request->capacity);
$details = $conn->real_escape_string($request->details);
$date = $conn->real_escape_string($request->date);

// Construct the SQL query to update the event
$sql = "UPDATE events SET 
		  name = '$name',
          description = '$description',
          capacity = '$capacity',
          details = '$details',
          date_e = '$date'
        WHERE id_e = $id";

if ($conn->query($sql) === TRUE) {
  echo json_encode(array("status" => "success"));
} else {
  echo json_encode(array("status" => "error", "message" => "Error updating event: " . $conn->error));
}

$conn->close();
?>
