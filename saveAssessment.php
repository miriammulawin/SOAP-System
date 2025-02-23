<?php

$host = 'localhost'; // Your database host
$dbname = 'MedicalSystem'; // Your database name
$username = 'root'; // Your database username
$password = ""; // Your database password

// Create a new connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if the required parameters are received via POST
if (isset($_POST['diagnosis'], $_POST['prescription'], $_POST['appointmentID'])) {
    // Sanitize input to prevent SQL Injection
    $diagnosis = htmlspecialchars($_POST['diagnosis']);
    $prescription = htmlspecialchars($_POST['prescription']);
    $appointmentID = (int)$_POST['appointmentID']; // Cast appointmentID to integer for safety

    // Prepare SQL statement to insert data into the assessment table
    $query = "INSERT INTO assessment (appointmentID, diagnosis, prescription, assessmentDate) 
              VALUES (?, ?, ?, NOW())";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind parameters and execute the statement
        $stmt->bind_param("iss", $appointmentID, $diagnosis, $prescription);
        
        if ($stmt->execute()) {
            echo 'Assessment saved successfully';
        } else {
            // Capture and display the SQL error if there is one
            echo 'Error executing query: ' . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Capture and display the SQL error if preparation fails
        echo 'Error preparing the statement: ' . $conn->error;
    }
} else {
    echo 'Missing parameters: Please ensure diagnosis, prescription, and appointmentID are provided';
}

// Close the database connection
$conn->close();
?>
