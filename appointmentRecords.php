<?php
$servername = "localhost"; 
$username = "root"; 
$password = "091203";
$database = "MedicalSystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch appointment records
$query = "SELECT appointmentID, patientID, diagnosticTest, diagnosticResult, appointmentDate, appointmentStatus FROM appointment"; 
$result = mysqli_query($conn, $query); // Execute the query

// Check if there are any results
if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
            <tr>
                <th>Appointment ID</th>
                <th>Patient ID</th>
                <th>Diagnostic Test</th>
                <th>Diagnostic Result</th>
                <th>Appointment Date</th>
                <th>Status</th>
            </tr>";

    // Loop through the appointments and display each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . $row['appointmentID'] . "</td>
                <td>" . $row['patientID'] . "</td>
                <td>" . $row['diagnosticTest'] . "</td>
                <td>" . $row['diagnosticResult'] . "</td>
                <td>" . $row['appointmentDate'] . "</td>
                <td>" . $row['appointmentStatus'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No appointments found.";
}

// Close the database connection
mysqli_close($conn);
?>
