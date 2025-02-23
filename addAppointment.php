<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientID = $_POST['patientID'];
    $appointmentDate = $_POST['appointmentDate'];

    // Database Connection
    $conn = new mysqli('localhost', 'root', 'ravanera1124', 'MedicalSystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch diagnosticTest from patientsRecord
    $stmt = $conn->prepare("SELECT diagnosticTest FROM patientsRecord WHERE patientID = ?");
    $stmt->bind_param("i", $patientID);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
    $diagnosticTest = $patient ? $patient['diagnosticTest'] : 'Not Applicable';

    // Insert Appointment
    $stmt = $conn->prepare("INSERT INTO appointment (patientID, diagnosticTest, appointmentDate) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $patientID, $diagnosticTest, $appointmentDate);

    if ($stmt->execute()) {
        // Fetch the last inserted appointment to return it
        $appointmentID = $stmt->insert_id;
        $stmt = $conn->prepare("SELECT a.appointmentID, a.patientID, a.diagnosticTest, a.diagnosticResult, a.appointmentDate, a.appointmentStatus, p.firstName, p.lastName FROM appointment a JOIN patientsRecord p ON a.patientID = p.patientID WHERE a.appointmentID = ?");
        $stmt->bind_param("i", $appointmentID);
        $stmt->execute();
        $result = $stmt->get_result();
        $appointment = $result->fetch_assoc();

        echo json_encode($appointment);
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
