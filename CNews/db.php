<?php
$host = 'localhost';        // usually localhost
$user = 'root';             // default user for XAMPP
$pass = '';                 // default password (empty)
$dbname = 'cnews';          // name of your database

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
