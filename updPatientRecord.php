<?php
    function updatePatientRecord($postData) {
        $conn = new mysqli("localhost", "root", "12345", "MedicalSystem"); // Use integer for port
        if ($conn->connect_error) {
            die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
        }

        // Validate and sanitize inputs
        if (!isset($postData['patientID']) || !filter_var($postData['patientID'], FILTER_VALIDATE_INT)) {
            die(json_encode(["status" => "error", "message" => "Invalid patient ID."]));
        }

        $patientID = (int) $postData['patientID'];
        $firstName = trim($postData['firstName']);
        $lastName = trim($postData['lastName']);
        $age = (int) $postData['age'];
        $address = trim($postData['address']);
        $birthday = trim($postData['birthday']);
        $gender = trim($postData['gender']);
        $symptoms = trim($postData['symptoms']);
        $medicalHistory = trim($postData['medicalHistory']);
        $weight = (float) $postData['weight'];
        $height = (float) $postData['height'];
        $temperature = isset($postData['temperature']) ? (float) $postData['temperature'] : NULL;
        $bloodPressure = isset($postData['bloodPressure']) ? trim($postData['bloodPressure']) : NULL;
        $heartRate = isset($postData['heartRate']) ? (int) $postData['heartRate'] : NULL;
        $diagnosticTest = isset($postData['diagnosticTest']) ? trim($postData['diagnosticTest']) : 'Not Applicable';

        // Use prepared statement
        $sql = "UPDATE patientsRecord SET 
                    firstName=?, lastName=?, age=?, address=?, birthday=?, gender=?, 
                    symptoms=?, medicalHistory=?, weight=?, height=?, temperature=?, 
                    bloodPressure=?, heartRate=?, diagnosticTest=? 
                WHERE patientID=?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssissssssddsisi", 
            $firstName, $lastName, $age, $address, $birthday, $gender,
            $symptoms, $medicalHistory, $weight, $height, $temperature, 
            $bloodPressure, $heartRate, $diagnosticTest, $patientID
        );

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Patient record updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
    }

    // Ensure the request is a POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        updatePatientRecord($_POST);
    }
?>
