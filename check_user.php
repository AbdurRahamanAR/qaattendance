<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$db_name = "attendance_system";

$conn = new mysqli($host, $username, $password, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check the HTTP request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod === 'POST') {
    // Read JSON input
    $data = json_decode(file_get_contents("php://input"), true);

    // Check if user_id is provided
    if (isset($data['user_id'])) {
        $user_Id = $conn->real_escape_string($data['user_id']);

        // Query to check if the user exists
        $sql = "SELECT user_id, user_name FROM users WHERE user_id = '$user_Id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Fetch user details
            $user = $result->fetch_assoc();
            echo json_encode($user);
        } else {
            // User doesn't exist
            echo json_encode(["error" => true, "message" => "User doesn’t exist"]);
        }
    } else {
        // Missing user_id
        echo json_encode(["error" => true, "message" => "Invalid input data"]);
    }
} else {
    // Method not allowed
    http_response_code(405);
    echo json_encode(["error" => true, "message" => "Method not allowed"]);
}

$conn->close();
?>
