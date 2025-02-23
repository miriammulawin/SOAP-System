<?php
// fetch_patient_records.php

// Database connection
$conn = new mysqli("localhost", "root", "12345", "MedicalSystem");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch patient records
$sql = "SELECT patientID, CONCAT(firstName, ' ', lastName) AS fullName, age, birthday, symptoms FROM patientsRecord";
$result = $conn->query($sql);

// Store the result in an array
$patients = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }
}

// Close the connection
$conn->close();

// Return the patient records as JSON
echo json_encode($patients);
?>
