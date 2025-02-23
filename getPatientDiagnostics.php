<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patientID = $_POST['patientID'];

    // Database Connection
    $conn = new mysqli('localhost', 'root', 'ravanera1124', 'MedicalSystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get patient's diagnostic information from patientsRecord table
    $stmt = $conn->prepare("SELECT diagnosticTest, diagnosticResult FROM patientsRecord WHERE patientID = ?");
    $stmt->bind_param("i", $patientID);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Fetch the diagnostic data
        $patientData = $result->fetch_assoc();
        $diagnosticTest = $patientData['diagnosticTest'];
        $diagnosticResult = $patientData['diagnosticResult'] ? $patientData['diagnosticResult'] : 'Not Available'; // If NULL, show 'Not Available'
        
        // Return diagnosticTest and diagnosticResult as a JSON response
        echo json_encode(['diagnosticTest' => $diagnosticTest, 'diagnosticResult' => $diagnosticResult]);
    } else {
        echo json_encode(['error' => 'Patient not found']);
    }

    $stmt->close();
    $conn->close();
}
?>
