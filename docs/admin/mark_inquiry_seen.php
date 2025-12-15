<?php
// Include database configuration
include '../config.php';

// Set header to JSON
header('Content-Type: application/json');

// Check for POST request and inqID
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid request or missing ID.']);
    exit;
}

$inqID = $_POST['id'];

try {
    // Prepare the UPDATE statement
    // We use prepared statements to prevent SQL Injection
    $stmt = $conn->prepare("UPDATE inquiry SET seen = 1 WHERE inqID = ?");
    
    // Bind the inquiry ID as an integer
    $stmt->bind_param("i", $inqID);
    
    // Execute the statement
    if (!$stmt->execute()) {
        throw new Exception("Update failed: " . $stmt->error);
    }

    // Check if any rows were affected
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Inquiry marked as seen.']);
    } else {
        // This might mean the ID was not found or was already seen (seen=1)
        echo json_encode(['success' => true, 'message' => 'Inquiry status unchanged (already seen or ID not found).']);
    }

    $stmt->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}

$conn->close();
?>