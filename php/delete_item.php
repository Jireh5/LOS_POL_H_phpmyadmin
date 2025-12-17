<?php
// Include the connection script
include 'db_connect.php';

// Set header for JSON response
header('Content-Type: application/json');

// Check if required parameters are present
if (!isset($_POST['type']) || !isset($_POST['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit;
}

$type = $_POST['type'];
$id = $_POST['id'];

// Determine which table to delete from
if ($type === 'application') {
    $table = 'job_applications';
    $idColumn = 'id';
} elseif ($type === 'inquiry') {
    $table = 'general_inquiries';
    $idColumn = 'inq_id';
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid type specified'
    ]);
    exit;
}

// Prepare and execute delete statement
$stmt = $conn->prepare("DELETE FROM $table WHERE $idColumn = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Item deleted successfully'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Item not found'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $conn->error
    ]);
}

$stmt->close();
$conn->close();
?>