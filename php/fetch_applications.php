<?php
// Include the connection script
include 'db_connect.php';

// Set header for JSON response
header('Content-Type: application/json');

// Query to fetch all job applications, ordered by most recent first
$sql = "SELECT * FROM job_applications ORDER BY created_at DESC";
$result = $conn->query($sql);

$applications = [];
$count = $result->num_rows;

if ($result->num_rows > 0) {
    // Store all applications in an array
    while($row = $result->fetch_assoc()) {
        $applications[] = [
            'id' => $row['app_id'],
            'job_title' => $row['job_title'],
            'applicant_name' => $row['applicant_name'],
            'applicant_email' => $row['applicant_email'],
            'application_pitch' => $row['application_pitch'],
            'created_at' => $row['created_at']
        ];
    }
}

$conn->close();

// Return JSON response with applications array
echo json_encode([
    'applications' => $applications,
    'count' => $count
]);
?>