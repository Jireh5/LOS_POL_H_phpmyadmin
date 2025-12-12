<?php
// Include database configuration
include '../config.php';

// Set header to JSON
header('Content-Type: application/json');

try {
    // Fetch all data from inquiry table with all columns
    $sql = "SELECT inqID, name, email, message FROM inquiry";
    $result = $conn->query($sql);

    // Check if query was successful
    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    // Initialize array to store results
    $data = array();

    // Fetch all rows and add to array
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Return JSON response
    echo json_encode([
        'success' => true,
        'count' => count($data),
        'data' => $data
    ]);

} catch (Exception $e) {
    // Return error response
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

$conn->close();
?>
