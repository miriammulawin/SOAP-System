<?php

function addPatientRecord($postData) {
    $conn = new mysqli("localhost", "root", "07242004", "MedicalSystem"); 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize input
    $firstName = $conn->real_escape_string($postData['firstName']);
    $lastName = $conn->real_escape_string($postData['lastName']);
    $age = (int)$postData['age'];
    $address = $conn->real_escape_string($postData['address']);
    $birthday = $postData['birthday'];
    $gender = $conn->real_escape_string($postData['gender']);
    $symptoms = $conn->real_escape_string($postData['symptoms']);
    $medicalHistory = $conn->real_escape_string($postData['medicalHistory']);
    
    // Handle optional fields like weight, height, temperature, etc.
    $weight = isset($postData['weight']) ? (float)$postData['weight'] : NULL;
    $height = isset($postData['height']) ? (float)$postData['height'] : NULL;
    $temperature = isset($postData['temperature']) ? $postData['temperature'] : NULL;
    $bloodPressure = isset($postData['bloodPressure']) ? $conn->real_escape_string($postData['bloodPressure']) : NULL;
    $heartRate = isset($postData['heartRate']) ? (int)$postData['heartRate'] : NULL;

    // Handle diagnosticTest field correctly
    // If no diagnostic test is selected, set it to 'Not Applicable'
    $diagnosticTest = isset($postData['diagnosticTest']) ? $postData['diagnosticTest'] : 'Not Applicable';

    // Ensure the diagnosticTest value is valid (ENUM values)
    $validTests = ['Radiology', 'Laboratory', 'Cardiovascular', 'Neurology', 'Not Applicable'];
    if (!in_array($diagnosticTest, $validTests)) {
        // If invalid value is provided, set a default valid value (e.g., 'Not Applicable')
        $diagnosticTest = 'Not Applicable';
    }

    // Insert data into patientsRecord
    $sql = "INSERT INTO patientsRecord 
            (firstName, lastName, age, address, birthday, gender, symptoms, medicalHistory, weight, height, temperature, bloodPressure, heartRate, diagnosticTest) 
            VALUES 
            ('$firstName', '$lastName', $age, '$address', '$birthday', '$gender', '$symptoms', '$medicalHistory', 
            " . ($weight !== NULL ? $weight : 'NULL') . ", 
            " . ($height !== NULL ? $height : 'NULL') . ", 
            " . ($temperature !== NULL ? "'$temperature'" : 'NULL') . ", 
            '$bloodPressure', $heartRate, '$diagnosticTest')";

    if ($conn->query($sql) === TRUE) {
        $patientID = $conn->insert_id; // Get the patient ID
        
        // Insert into corresponding test table if diagnosticTest is not 'Not Applicable'
        if ($diagnosticTest !== 'Not Applicable') {
            $testTable = [
                'Radiology' => 'Radiology',
                'Laboratory' => 'Laboratory',
                'Cardiovascular' => 'Cardiovascular', // Ensure correct table name
                'Neurology' => 'Neurological', // Map 'Neurology' to 'Neurological'
                'Not Applicable' => null // Don't insert into any table if 'Not Applicable'
            ][$diagnosticTest];

            if ($testTable) { // Only proceed if the table exists
                $testResult = "Pending"; // Set a default result or can be updated later
                $dateConducted = date("Y-m-d H:i:s");

                // Correct the query to insert into the corresponding test table
                $testSql = "INSERT INTO $testTable (patientID, testType, result, dateConducted) 
                            VALUES ($patientID, '$diagnosticTest', '$testResult', '$dateConducted')";
                $conn->query($testSql);
            }
        }

        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showPopup('Patient record added successfully.', 'success');
                });
              </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showPopup('Error: " . addslashes($conn->error) . "', 'error');
                });
              </script>";
    }

    $conn->close();
}

?>
