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

// Prepare the SQL query using a JOIN between appointment and patientsRecord
$query = "SELECT a.appointmentID, p.firstName, p.lastName, a.diagnosticTest, a.diagnosticResult, a.appointmentDate, a.appointmentStatus
          FROM appointment a
          JOIN patientsRecord p ON a.patientID = p.patientID";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any results
if ($result->num_rows > 0) {
    echo "<style>
            table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }
            th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
            th { background-color: #4CAF50; color: white; }
            tr:nth-child(even) { background-color: #f2f2f2; }
          </style>";

    echo "<table>
            <tr>
                <th>Appointment ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Diagnostic Test</th>
                <th>Diagnostic Result</th>
                <th>Appointment Date</th>
                <th>Status</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['appointmentID']) . "</td>
                <td>" . htmlspecialchars($row['firstName']) . "</td>
                <td>" . htmlspecialchars($row['lastName']) . "</td>
                <td>" . htmlspecialchars($row['diagnosticTest']) . "</td>
                <td>" . (!empty($row['diagnosticResult']) ? htmlspecialchars($row['diagnosticResult']) : 'Pending') . "</td>
               <td>" . date('F d, Y', strtotime($row['appointmentDate'])) . "</td>

                <td>" . htmlspecialchars($row['appointmentStatus']) . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No appointments found.</p>";
}

// Close connection
$stmt->close();
$conn->close();
?>
