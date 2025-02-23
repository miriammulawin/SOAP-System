<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$database = "MedicalSystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch patient records
$query = "SELECT patientID, firstName, lastName, age, gender FROM patientsRecord";
$result = mysqli_query($conn, $query);

// Check if there are any records
$patients = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patients[] = $row;
    }
}



// Return the patients as JSON
echo json_encode($patients);

// Close the connection
mysqli_close($conn);


?>
