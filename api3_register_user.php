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
        // Register a new user
        if (isset($data['user_id'], $data['user_name'], $data['user_password'])) {
            $user_Id = $conn->real_escape_string($data['user_id']);
            $user_Name = $conn->real_escape_string($data['user_name']);
            $user_password = $conn->real_escape_string($data['user_password']);
            
            // Check if the user_id already exists in the database
            $checkUserSql = "SELECT * FROM users WHERE user_id = '$user_Id'";
            $result = $conn->query($checkUserSql);
            
            if ($result && $result->num_rows > 0) {
                // If user already exists, return an error message
                echo json_encode([
                    "error" => true,
                    "message" => "User ID already exists. Please choose another one."
                ]);
            } else {
                // Insert the new user into the database
                $sql = "INSERT INTO users (user_id, user_name, user_password) VALUES ('$user_Id', '$user_Name', '$user_password')";
                
                if ($conn->query($sql) === TRUE) {
                    // If registration is successful, return user details
                    echo json_encode([
                        "user_id" => $user_Id,
                        "user_name" => $user_Name,
                        "message"=>"registration succcessfull"
                    ]);
                } else {
                    // If registration fails, return an error message
                    echo json_encode([
                        "error" => true,
                        "message" => "Failed to complete registration. Try again."
                    ]);
                }
            }
        } else {
            // Missing input data
            echo json_encode([
                "error" => true,
                "message" => "Missing user_id, user_name, or user_password"
            ]);
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
