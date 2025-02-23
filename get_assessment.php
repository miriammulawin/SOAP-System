<?php
$conn = new mysqli("localhost", "root", "091203", "MedicalSystem");

if (isset($_GET['appointmentID'])) {
    $appointmentID = $_GET['appointmentID'];

    $stmt = $conn->prepare("SELECT diagnosis, prescription FROM assessment WHERE appointmentID = ?");
    $stmt->bind_param("i", $appointmentID);
    $stmt->execute();
    $result = $stmt->get_result();
    $assessment = $result->fetch_assoc();

    echo json_encode($assessment);
}
?>