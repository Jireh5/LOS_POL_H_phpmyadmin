<?php
// Include the connection script
include 'db_connect.php';

// Check if data was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Get and sanitize form data
    // The fields map to the names used in your script.js templateParams object
    $name = htmlspecialchars(trim($_POST['from_name']));
    $email = htmlspecialchars(trim($_POST['reply_to']));
    $message = htmlspecialchars(trim($_POST['message']));

    // 2. Prepare the SQL statement
    $sql = "INSERT INTO general_inquiries (sender_name, sender_email, inquiry_message) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        
        // 3. Bind parameters (s = string)
        $stmt->bind_param("sss", $name, $email, $message);
        
        // 4. Execute and check for success
        if ($stmt->execute()) {
            echo "Success: Inquiry saved to database.";
        } else {
            http_response_code(500); 
            echo "Error: Could not save inquiry. " . $stmt->error;
        }
        
        // 5. Close statement
        $stmt->close();
    } else {
        http_response_code(500);
        echo "Error: Database preparation failed. " . $conn->error;
    }
    
    // Close connection
    $conn->close();

} else {
    // If accessed directly, send a bad request response
    http_response_code(400); 
    echo "Error: Invalid request method.";
}
?>