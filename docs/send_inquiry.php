<?php
// load DB config and connection
require_once __DIR__ . '/config.php';
header('Content-Type: application/json; charset=utf-8');

// Ensure $conn exists
if (!isset($conn) || !($conn instanceof mysqli)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection not available (check config.php)']);
    exit();
}

// set charset
$conn->set_charset('utf8mb4');

// Allow only POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Only POST allowed']);
    exit();
}

// Read JSON body
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON']);
    exit();
}

// Validate required fields
if (empty($input['name']) || empty($input['email']) || empty($input['message'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}

$name = trim($input['name']);
$email = trim($input['email']);
$message = trim($input['message']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit();
}

// Insert using prepared statement
// prepare insert
$stmt = $conn->prepare("INSERT INTO inquiry (`name`, `email`, `message`) VALUES (?, ?, ?)");
if (!$stmt) {
    // log error for debugging
    error_log("send_inquiry.php prepare failed: " . $conn->error);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit();
}

$stmt->bind_param('sss', $name, $email, $message);
$exec = $stmt->execute();

if ($exec) {
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'Inquiry saved']);
} else {
    // log error for debugging
    error_log("send_inquiry.php insert failed: " . $stmt->error);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Insert failed: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
