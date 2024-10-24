<?php
$servername = "localhost";
$username = "Kong";
$password = "12321";
$dbname = "robopay_db";

// Create connection
$conn2 = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn2->connect_error) {
    die("Connection failed: " . $conn2->connect_error);
}
?>
