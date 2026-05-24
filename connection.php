<?php
$server = "localhost:3307";
$username = "root";
$password = "";
$dbname = "mar_wear_db";

// Object-Oriented Initialization
$conn = new mysqli($server, $username, $password, $dbname);

// Correct OOP method to check connection errors
if ($conn->connect_error) {
    die("Markhor Wears Database Core Offline: " . $conn->connect_error);
}
?>