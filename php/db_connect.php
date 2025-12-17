<?php
// Configuration details
$servername = "localhost"; // Usually localhost
$username = "root";       
$password = "";           // <--- ENTER YOUR MYSQL ROOT PASSWORD HERE if you set one
$dbname = "lph-finals"; // <--- MATCHES THE DATABASE NAME CREATED ABOVE
$port = 3306;             // Use 3307 or your custom port if you changed it earlier

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    // For production, you would hide the error, but for debugging:
    die("Connection failed: " . $conn->connect_error);
}
// Connection is successful if the script reaches this point
?>