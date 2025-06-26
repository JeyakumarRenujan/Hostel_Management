<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hostel_management_system"; // My databse

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
