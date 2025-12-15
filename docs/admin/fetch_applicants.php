<?php
// Simple JSON endpoint to fetch applicants from the database.
// Usage: http://localhost/LOS_POL_H_PHP/docs/fetch_applicants.php

header('Content-Type: application/json; charset=utf-8');

// Include database configuration
include '../config.php';

// Ensure $conn is available
if (!isset($conn) || !($conn instanceof mysqli)) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection not available']);
    exit;
}

// Attempt to fetch rows from the applicant_forms table with specific columns
$table = 'applicant_forms';
$query = "SELECT a_formID, Name, email, job_applied, applicant_info, app_date FROM `" . $conn->real_escape_string($table) . "` ORDER BY a_formID DESC";

$result = $conn->query($query);
if ($result === false) {
    http_response_code(500);
    echo json_encode(['error' => 'Query failed', 'details' => $conn->error]);
    exit;
}

$rows = [];
while ($r = $result->fetch_assoc()) {
    $rows[] = $r; // return raw associative row; caller can map fields
}

echo json_encode(['data' => $rows], JSON_UNESCAPED_UNICODE);

$result->free();
$conn->close();

?>