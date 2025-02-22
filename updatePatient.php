<?php
$conn = new mysqli("localhost", "root", "091203", "MedicalSystem");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$patientID = $_POST['patientID'];
$fullName = $_POST['fullName'];
$age = $_POST['age'];
$birthday = $_POST['birthday'];
$symptoms = $_POST['symptoms'];
$medicalHistory = $_POST['medicalHistory'];

// Handle fullName (split into first and last names)
list($firstName, $lastName) = explode(" ", $fullName, 2);

// Update query
$sql = "UPDATE patientsRecord 
        SET firstName='$firstName', lastName='$lastName', age='$age', birthday='$birthday', symptoms='$symptoms', medicalHistory='$medicalHistory'
        WHERE patientID=$patientID";

if ($conn->query($sql) === TRUE) {
    echo "Patient record updated successfully.";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
