<?php
// Include the connection script
include 'db_connect.php';

// Check if data was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Get and sanitize form data
    // The fields map to the names used in your script.js formData object
    $jobTitle = htmlspecialchars(trim($_POST['job_title']));
    $name = htmlspecialchars(trim($_POST['from_name']));
    $email = htmlspecialchars(trim($_POST['reply_to']));
    $pitch = htmlspecialchars(trim($_POST['message']));

    // 2. Prepare the SQL statement (Prevents SQL Injection!)
    $sql = "INSERT INTO job_applications (job_title, applicant_name, applicant_email, application_pitch) VALUES (?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        
        // 3. Bind parameters (s = string)
        $stmt->bind_param("ssss", $jobTitle, $name, $email, $pitch);
        
        // 4. Execute and check for success
        if ($stmt->execute()) {
            // Send a success response back (optional, but good practice)
            echo "Success: Application saved to database.";
        } else {
            http_response_code(500); // Internal Server Error
            echo "Error: Could not save application. " . $stmt->error;
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