<?php
// Include the connection script
include 'db_connect.php';

// Set header for JSON response
header('Content-Type: application/json');

// Query to fetch all general inquiries, ordered by most recent first
$sql = "SELECT * FROM general_inquiries ORDER BY created_at DESC";
$result = $conn->query($sql);

$html = '';
$count = $result->num_rows;

if ($result->num_rows > 0) {
    // Output data for each row
    while($row = $result->fetch_assoc()) {
        $html .= '<div class="card">';
        $html .= '<div class="card-header">';
        $html .= '<div class="card-title">Inquiry #' . $row['inq_id'] . '</div>';
        $html .= '<div class="card-date">' . date('M d, Y h:i A', strtotime($row['created_at'])) . '</div>';
        $html .= '</div>';
        
        $html .= '<div class="card-info">';
        $html .= '<span class="card-label">Name:</span> ';
        $html .= '<span class="card-value">' . htmlspecialchars($row['sender_name']) . '</span>';
        $html .= '</div>';
        
        $html .= '<div class="card-info">';
        $html .= '<span class="card-label">Email:</span> ';
        $html .= '<span class="card-value">' . htmlspecialchars($row['sender_email']) . '</span>';
        $html .= '</div>';
        
        $html .= '<div class="card-message">';
        $html .= '<div class="card-message-label">Message:</div>';
        $html .= '<div class="card-message-text">' . nl2br(htmlspecialchars($row['inquiry_message'])) . '</div>';
        $html .= '</div>';
        
        // Add delete button
        $html .= '<button class="delete-btn" onclick="showDeleteModal(\'inquiry\', \'' . $row['inq_id'] . '\', \'' . htmlspecialchars($row['sender_name'], ENT_QUOTES) . '\')">Delete Inquiry</button>';
        
        $html .= '</div>';
    }
} else {
    $html .= '<div class="empty-state">';
    $html .= '<h3>No Inquiries Yet</h3>';
    $html .= '<p>There are no general inquiries to display at this time.</p>';
    $html .= '</div>';
}

$conn->close();

// Return JSON response
echo json_encode([
    'html' => $html,
    'count' => $count
]);
?>