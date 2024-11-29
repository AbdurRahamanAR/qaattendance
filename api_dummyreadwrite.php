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
    case 'GET':
        // Get all users
        $result = $conn->query("SELECT * FROM users");
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode($users);
        break;

    case 'POST':
        // Add a new user
        if (isset($data['user_id'], $data['user_name'], $data['user_email'], $data['user_password'])) {
            $user_Id = $data['user_id'];
            $user_Name = $data['user_name'];
            $user_Email = $data['user_email'];
            $user_Fingerprint = $data['user_password'];

            $sql = "INSERT INTO users (user_id, user_name, user_email, user_password) VALUES ('$user_Id', '$user_Name', '$user_Email', '$user_Fingerprint')";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "User added successfully!"]);
            } else {
                echo json_encode(["error" => "Error: " . $conn->error]);
            }
        } else {
            echo json_encode(["error" => "Invalid input data"]);
        }
        break;

    case 'PUT':
    case 'PATCH':
        // Update a user (assumes user_id is the key)
        if (isset($data['user_id'])) {
            $user_Id = $data['user_id'];
            $fields = [];

            if (isset($data['user_name'])) {
                $fields[] = "user_name = '{$data['user_name']}'";
            }
            if (isset($data['user_email'])) {
                $fields[] = "user_email = '{$data['user_email']}'";
            }
            if (isset($data['user_password'])) {
                $fields[] = "user_password = '{$data['user_password']}'";
            }

            if (!empty($fields)) {
                $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE user_id = '$user_Id'";
                if ($conn->query($sql) === TRUE) {
                    echo json_encode(["message" => "User updated successfully!"]);
                } else {
                    echo json_encode(["error" => "Error: " . $conn->error]);
                }
            } else {
                echo json_encode(["error" => "No fields to update"]);
            }
        } else {
            echo json_encode(["error" => "Invalid input data"]);
        }
        break;

    case 'DELETE':
        // Delete a user
        if (isset($data['user_id'])) {
            $user_Id = $data['user_id'];
            $sql = "DELETE FROM users WHERE user_id = '$user_Id'";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(["message" => "User deleted successfully!"]);
            } else {
                echo json_encode(["error" => "Error: " . $conn->error]);
            }
        } else {
            echo json_encode(["error" => "Invalid input data"]);
        }
        break;

    case 'HEAD':
        // Respond with headers only (no body)
        header("Content-Type: application/json");
        http_response_code(200);
        break;

    case 'OPTIONS':
        // Respond with allowed methods
        header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");
        header("Access-Control-Allow-Origin: *");
        break;

    default:
        // Method not allowed
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;
}

$conn->close();
?>
