<?php
    $conn = new mysqli("localhost", "root", "12345", "MedicalSystem");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function deletePatientRecord($conn, $id) {
        // Prepare the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM patientsRecord WHERE patientID = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    if (isset($_POST['delete_id'])) {
        $id = (int)$_POST['delete_id']; 
        if (deletePatientRecord($conn, $id)) {
            echo json_encode(["status" => "success", "message" => "Patient record deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting record."]);
        }
    }
    $conn->close();
?>