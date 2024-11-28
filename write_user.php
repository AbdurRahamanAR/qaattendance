<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$db_name = "attendance_system";

$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST request
$data = json_decode(file_get_contents("php://input"), true);

$user_Id=$data['user_id'];
$user_Name = $data['user_name'] ;
$user_Email = $data['user_email'] ;
$user_Fingerprint=$data['user_fingerprint'];

if ($user_Id && $user_Name && $user_Email && $user_Fingerprint) {
    $sql = "INSERT INTO users (user_id,user_name,user_email,user_fingerprint) VALUES ('$user_Id', '$user_Name','$user_Email','$user_Fingerprint')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User added successfully!"]);
    } else {
        echo json_encode(["error" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["error" => "Invalid input data"]);
}

$conn->close();
?>
