<?php
    $servername = "localhost";
    $username = "root";
    $password = "12345";
    $dbname = "MedicalSystem"; 


    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
    }

    // Get the patient ID from the query string
    $patientID = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    $sql = "SELECT * FROM patientsRecord WHERE patientID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $patientID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        echo json_encode($patient);
    } else {
        echo json_encode(['error' => 'No patient found']);
    }

    $stmt->close();
    $conn->close();
?>