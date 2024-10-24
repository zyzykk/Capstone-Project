<?php
$servername = "localhost";
$username = "Kong";
$password = "12321";
$dbname = "employee_login_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
