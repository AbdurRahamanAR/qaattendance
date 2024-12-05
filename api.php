<?php
// Connect to the database
$host = "localhost";
$username = "root";
$password = "";
$db_name = "attendance_system";

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the HTTP request method (GET, POST, etc.)
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'GET') {
    // Get all users
    $result = $conn->query("SELECT * FROM users");
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
} elseif ($requestMethod === 'POST') {
    // Add a new user
    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data['name'];
    $email = $data['email'];
    $conn->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
    echo json_encode(["message" => "User added successfully"]);
}

$conn->close();
?>
