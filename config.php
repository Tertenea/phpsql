<?php
$servername = "localhost";
$username = "issi";
$password = "new_password";
$database = "muusikapood";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Ühenduse viga: " . $conn->connect_error);
}
?>