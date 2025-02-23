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

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Search functionality to retrieve patient's basic, physical examination, and assessment data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $searchQuery = sanitizeInput($_POST['searchQuery']);
    
    try {
        // Prepare the query to fetch patient's basic, physical examination, and assessment details
        $sql = "SELECT 
                p.patientID,
                p.firstName,
                p.lastName,
                p.age,
                p.gender,
                p.birthday,
                p.symptoms,
                p.medicalHistory,
                p.diagnosticTest,
                p.weight,
                p.height,
                p.temperature,
                p.bloodPressure,
                p.heartRate,
                a.appointmentID,
                a.appointmentDate,
                ass.assessmentID,
                ass.diagnosis,
                ass.prescription
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
            echo json_encode($patientData);
        } else {
            echo json_encode(["message" => "No patient found"]);
        }
        
    } catch (Exception $e) {
        echo json_encode(["error" => "Search error: " . $e->getMessage()]);
    }
    
    exit();
}

// Save functionality to store diagnosis and prescription
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    try {
        // Get and validate required fields
        $patientID = sanitizeInput($_POST["patientID"] ?? null);
        $diagnosis = sanitizeInput($_POST["diagnosis"] ?? null);
        $prescription = sanitizeInput($_POST["prescription"] ?? null);

        if (!$patientID || !$diagnosis || !$prescription) {
            throw new Exception("Patient ID, Diagnosis, and Prescription are required!");
        }

        // Start transaction
        $conn->begin_transaction();

        try {
            // Find the latest appointment for the patient
            $appointment_sql = "SELECT appointmentID FROM appointment 
                              WHERE patientID = ? 
                              ORDER BY appointmentDate DESC 
                              LIMIT 1";
            $stmt = $conn->prepare($appointment_sql);
            $stmt->bind_param("i", $patientID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                $appointmentID = $row["appointmentID"];
            } else {
                // If no appointment exists, create a new one
                $insert_appointment = "INSERT INTO appointment 
                    (patientID, diagnosticTest, appointmentDate, appointmentStatus) 
                    VALUES (?, 'Not Applicable', NOW(), 'Finished')";
                $stmt = $conn->prepare($insert_appointment);
                $stmt->bind_param("i", $patientID);
                $stmt->execute();
                $appointmentID = $conn->insert_id;
            }

            // Insert or update assessment
            $assessment_sql = "INSERT INTO assessment 
                (appointmentID, diagnosis, prescription, assessmentDate) 
                VALUES (?, ?, ?, NOW())
                ON DUPLICATE KEY UPDATE 
                diagnosis = VALUES(diagnosis), 
                prescription = VALUES(prescription)";

            $stmt = $conn->prepare($assessment_sql);
            $stmt->bind_param("iss", $appointmentID, $diagnosis, $prescription);

            if (!$stmt->execute()) {
                throw new Exception("Failed to save assessment: " . $stmt->error);
            }

            // Commit transaction
            $conn->commit();
            echo json_encode(["success" => "Diagnosis and Prescription saved successfully!"]);

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