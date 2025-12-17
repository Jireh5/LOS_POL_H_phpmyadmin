<?php
session_start();
header('Content-Type: application/json');

// Include database connection
require_once 'db_connect.php';

// Get POST data
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validate input
if (empty($username) || empty($password)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please provide username and password'
    ]);
    exit;
}

// Prepare SQL statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id, username, password, email FROM admin_users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Verify password
    if (password_verify($password, $user['password'])) {
        // Password is correct, create session
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_username'] = $user['username'];
        $_SESSION['admin_email'] = $user['email'];
        
        echo json_encode([
            'success' => true,
            'message' => 'Login successful'
        ]);
    } else {
        // Invalid password
        echo json_encode([
            'success' => false,
            'message' => 'Invalid username or password'
        ]);
    }
} else {
    // User not found
    echo json_encode([
        'success' => false,
        'message' => 'Invalid username or password'
    ]);
}

$stmt->close();
$conn->close();
?>