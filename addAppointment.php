<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientID = $_POST['patientID'];
    $appointmentDate = $_POST['appointmentDate'];

    // Database Connection
    $conn = new mysqli('localhost', 'root', '091203', 'MedicalSystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert Appointment
    $stmt = $conn->prepare("INSERT INTO appointment (patientID,  appointmentDate) VALUES (?, ?)");
    $stmt->bind_param("is", $patientID, $appointmentDate);

    if ($stmt->execute()) {
        echo "Appointment added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
