<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$host = "localhost";  // Change this if your DB is hosted elsewhere
$dbname = "your_db_name"; // Change to your database name
$username = "your_user_name"; // Change to your DB username
$password = "your_password"; // Change to your DB password

// Create a MySQLi connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// else {
//     echo "Connected successfully";
// }
?>
