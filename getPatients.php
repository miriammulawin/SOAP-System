<?php
error_reporting(E_ALL); // Enable error reporting for debugging
ini_set('display_errors', 1); // Show errors

$servername = "localhost";
$username = "root";
$password = "ravanera1124";
$dbname = "MedicalSystem";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['testType'])) {
    $testType = $_GET['testType'];

    // Map the testType to actual table names
    $tableMapping = [
        'Radiology' => 'Radiology',
        'Laboratory' => 'Laboratory',
        'Cardiovascular' => 'Cardiovascular',
        'Neurology' => 'Neurological', // Map 'Neurology' to 'Neurological'
        'Not Applicable' => 'Not Applicable'
    ];

    // Check if the testType exists in the table mapping
    if (!array_key_exists($testType, $tableMapping)) {
        echo json_encode(["error" => "Invalid test type: $testType"]);
        exit;
    }

    $tableName = $tableMapping[$testType];
    
    if ($tableName == 'Not Applicable') {
        echo json_encode([]); // Return empty array if 'Not Applicable' is selected
        exit;
    }

    // Query to fetch patient records based on testType
    $sql = "SELECT pr.firstName, pr.lastName, pr.age, r.testType, r.result, r.dateConducted
            FROM patientsRecord pr
            INNER JOIN $tableName r ON pr.patientID = r.patientID";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $patients = [];
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
        echo json_encode($patients); // Return data as JSON
    } else {
        echo json_encode([]); // Return empty array if no records found
    }
} else {
    // If 'testType' is not specified, fetch all patient records
    $sql = "SELECT * FROM patients";  // Assuming the table storing patient data is named 'patients'
    $result = $conn->query($sql);

    $patients = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;  // Add each row (patient) to the array
        }
        echo json_encode($patients);  // Send the data as a JSON response
    } else {
        echo json_encode([]);  // Return empty array if no records found
    }
}

$conn->close();
?>
