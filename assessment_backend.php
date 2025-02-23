<?php
// Database Connection
$host = "localhost";
$username = "root";
$password = "";
$database = "MedicalSystem";
$conn = new mysqli($host, $username, $password, $database);


if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Search functionality
// Search functionality
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $searchQuery = $_POST['searchQuery'];
    
    try {
        // Prepare the base query
        $sql = "SELECT 
                p.*, 
                a.appointmentID, 
                a.appointmentDate, 
                a.appointmentStatus,
                ass.assessmentID, 
                ass.diagnosis, 
                ass.prescription, 
                ass.assessmentDate
            FROM patientsRecord p
            LEFT JOIN appointment a ON p.patientID = a.patientID
            LEFT JOIN assessment ass ON a.appointmentID = ass.appointmentID
            WHERE p.firstName LIKE ? OR p.lastName LIKE ? OR p.patientID = ?
            ORDER BY a.appointmentDate DESC
            LIMIT 1";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Prepare search parameters
        $searchParam = "%$searchQuery%";
        $searchQueryInt = is_numeric($searchQuery) ? (int)$searchQuery : 0;
        
        $stmt->bind_param("ssi", $searchParam, $searchParam, $searchQueryInt);
        
        if (!$stmt->execute()) {
            throw new Exception("Execute failed: " . $stmt->error);
        }

        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $patientData = $result->fetch_assoc();
            
            // Fetch diagnostic test results if available
            if ($patientData['diagnosticTest'] != 'Not Applicable') {
                $testTable = $patientData['diagnosticTest'];
                if (in_array($testTable, ['Neurological', 'Radiology', 'Laboratory', 'Cardiovascular'])) {
                    $testQuery = "SELECT * FROM $testTable WHERE patientID = ? ORDER BY dateConducted DESC LIMIT 1";
                    $testStmt = $conn->prepare($testQuery);
                    $testStmt->bind_param("i", $patientData['patientID']);
                    $testStmt->execute();
                    $testResult = $testStmt->get_result()->fetch_assoc();
                    
                    if ($testResult) {
                        $patientData[$testTable . 'Tests'] = $testResult['testType'] . ': ' . $testResult['result'];
                        $patientData['testResult'] = $testResult['result'];
                    }
                }
            }
            
            echo json_encode($patientData);
        } else {
            echo json_encode(["message" => "No patient found"]);
        }
        
    } catch (Exception $e) {
        echo json_encode(["error" => "Search error: " . $e->getMessage()]);
    }
    
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    try {
        // Get and validate required fields
        $patientID = $_POST["patientID"] ?? null;
        $assessmentID = $_POST["assessmentID"] ?? null;

        if (!$patientID) {
            throw new Exception("Patient ID is required!");
        }

        // Start transaction
        $conn->begin_transaction();

        try {
            // Update patient record
            $update_patient_sql = "UPDATE patientsRecord SET 
                age = ?,
                gender = ?,
                birthday = ?,
                symptoms = ?,
                medicalHistory = ?,
                height = ?,
                weight = ?,
                temperature = ?,
                heartRate = ?,
                bloodPressure = ?,
                diagnosticTest = ?
                WHERE patientID = ?";

            $stmt = $conn->prepare($update_patient_sql);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            $stmt->bind_param(
                "issssdddsssi",
                $_POST["age"],
                $_POST["gender"],
                $_POST["birthDate"],
                $_POST["symptoms"],
                $_POST["medicalHistory"],
                $_POST["height"],
                $_POST["weight"],
                $_POST["temperature"],
                $_POST["heartRate"],
                $_POST["bloodPressure"],
                $_POST["diagnosticTest"],
                $patientID
            );

            if (!$stmt->execute()) {
                throw new Exception("Failed to update patient record: " . $stmt->error);
            }

            // Find or create appointment
            $appointment_sql = "SELECT appointmentID FROM appointment 
                              WHERE patientID = ? 
                              ORDER BY appointmentDate DESC LIMIT 1";
            $stmt = $conn->prepare($appointment_sql);
            $stmt->bind_param("i", $patientID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $appointmentID = $row["appointmentID"];
            } else {
                // Create new appointment
                $insert_appointment = "INSERT INTO appointment 
                    (patientID, diagnosticTest, appointmentDate, appointmentStatus) 
                    VALUES (?, ?, NOW(), 'Finished')";
                $stmt = $conn->prepare($insert_appointment);
                $stmt->bind_param("is", $patientID, $_POST["diagnosticTest"]);
                $stmt->execute();
                $appointmentID = $conn->insert_id;
            }

            // Update or insert assessment
            if ($assessmentID) {
                $assessment_sql = "UPDATE assessment SET 
                    diagnosis = ?,
                    prescription = ?,
                    assessmentDate = NOW()
                    WHERE assessmentID = ?";
                $stmt = $conn->prepare($assessment_sql);
                $stmt->bind_param("ssi", $_POST["diagnosis"], $_POST["prescription"], $assessmentID);
            } else {
                $assessment_sql = "INSERT INTO assessment 
                    (appointmentID, diagnosis, prescription, assessmentDate) 
                    VALUES (?, ?, ?, NOW())";
                $stmt = $conn->prepare($assessment_sql);
                $stmt->bind_param("iss", $appointmentID, $_POST["diagnosis"], $_POST["prescription"]);
            }

            if (!$stmt->execute()) {
                throw new Exception("Failed to save assessment: " . $stmt->error);
            }

            // Commit transaction
            $conn->commit();
            echo json_encode(["success" => "Assessment saved successfully!"]);

        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            throw $e;
        }

    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
    exit();
}

$conn->close();
?>
