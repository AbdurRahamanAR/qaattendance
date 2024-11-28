
<?php
include 'write_user.php';
include 'read_user.php';


$host = "localhost";
$username = "root";
$password = "";
$db_name = "attendance_system";

// Connect to the database
$conn = new mysqli($host, $username, $password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully!";



?>
