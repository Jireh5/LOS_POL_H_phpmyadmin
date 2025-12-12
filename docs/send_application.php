<?php
include 'config.php';
header('Content-Type: application/json; charset=utf-8');

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate required fields
if (!isset($input['name']) || !isset($input['email']) || !isset($input['pitch'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}

// Get the job applied for (if available)
$job_applied = isset($input['job']) ? $input['job'] : '';

// Sanitize and prepare data
$name = $conn->real_escape_string(trim($input['name']));
$email = $conn->real_escape_string(trim($input['email']));
$pitch = $conn->real_escape_string(trim($input['pitch']));
$job_applied = $conn->real_escape_string(trim($job_applied));

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit();
}

// Get current date
$app_date = date('Y-m-d');

// Insert into database
$sql = "INSERT INTO applicant_forms (Name, email, job_applied, applicant_info, app_date) 
        VALUES ('$name', '$email', '$job_applied', '$pitch', '$app_date')";

if ($conn->query($sql) === TRUE) {
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Application submitted successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error submitting application: ' . $conn->error]);
}

$conn->close();
?>
