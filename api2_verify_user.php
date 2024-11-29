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

// Get the HTTP request method
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Read JSON input if applicable
$data = json_decode(file_get_contents("php://input"), true);

// Respond based on the HTTP method
switch ($requestMethod) {
    case 'POST':
        // Verify user credentials
        if (isset($data['user_id'], $data['user_password'])) {
            $user_Id = $conn->real_escape_string($data['user_id']);
            $user_password = $data['user_password'];
    
            $sql = "SELECT user_id, user_name, user_password FROM users WHERE user_id = '$user_Id'";
            $result = $conn->query($sql);
    
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
    
                // Debugging: Print fetched data (for testing only, remove in production)
                // var_dump($row);
    
                // Use plain text or hashed password comparison
                if ($user_password === $row['user_password']) { // Replace with password_verify() if hashed
                    echo json_encode([
                        "user_id" => $row['user_id'],
                        "user_name" => $row['user_name']
                    ]);
                } else {
                    echo json_encode([
                        "error" => true,
                        "message" => "Invalid user_id or password"
                    ]);
                }
            } else {
                echo json_encode([
                    "error" => true,
                    "message" => "Invalid user_id or password"
                ]);
            }
        } else {
            echo json_encode(["error" => true, "message" => "Missing user_id or user_password"]);
        }
        break;
    

    default:
        // Method not allowed
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}

$conn->close();
?>
