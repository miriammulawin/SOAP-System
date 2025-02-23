<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$database = "MedicalSystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from POST request
$appointmentID = $_POST['appointmentID'];
$status = $_POST['status'];

// Prepare the SQL query to update the status
$stmt = $conn->prepare("UPDATE appointment SET appointmentStatus = ? WHERE appointmentID = ?");
$stmt->bind_param("si", $status, $appointmentID);

// Execute the query
if ($stmt->execute()) {
    echo "Status updated successfully.";
} else {
    echo "Error updating status: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>
