<?php
$servername = "localhost";
$username = "root";
$password = "091203";
$database = "MedicalSystem";

// Create connection
$conn = new mysqli ($servername, $username, $password, $database);

// Check connection 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the status filter from the URL (default is 'Upcoming')
$statusFilter = isset($_GET['status']) ? $_GET['status'] : 'Upcoming';

// Prepare the SQL query using a JOIN between appointment and patientsRecord
$query = "SELECT a.appointmentID, p.firstName, p.lastName, a.diagnosticTest, a.diagnosticResult, a.appointmentDate, a.appointmentStatus
          FROM appointment a
          JOIN patientsRecord p ON a.patientID = p.patientID";

// Apply the filter based on the status
if ($statusFilter === 'Upcoming') {
    // Only show appointments with no status (i.e., appointments that are still "Upcoming")
    $query .= " WHERE a.appointmentStatus IS NULL OR a.appointmentStatus = ''";
} elseif ($statusFilter === 'Finished' || $statusFilter === 'Cancelled') {
    // For Finished or Cancelled, show those with the selected status
    $query .= " WHERE a.appointmentStatus = ?";
}

$stmt = $conn->prepare($query);

// Bind the status filter to the query if applicable
if ($statusFilter === 'Finished' || $statusFilter === 'Cancelled') {
    $stmt->bind_param("s", $statusFilter);
}

$stmt->execute();
$result = $stmt->get_result();

// Check if there are any results
if ($result->num_rows > 0) {
    echo "<style>

            table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; }
            th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
            th { background-color:rgb(39, 69, 133); color: white; }
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
                $appointmentID = htmlspecialchars($row['appointmentID']);
                $appointmentStatus = $row['appointmentStatus'];
            
                // Disable both buttons when the status is Finished or Cancelled
                $disableFinished = ($appointmentStatus == 'Finished' || $appointmentStatus == 'Cancelled') ? 'disabled' : '';
                $disableCancelled = ($appointmentStatus == 'Finished' || $appointmentStatus == 'Cancelled') ? 'disabled' : '';
            
                echo "<tr>
                        <td>" . $appointmentID . "</td>
                        <td>" . htmlspecialchars($row['firstName']) . "</td>
                        <td>" . htmlspecialchars($row['lastName']) . "</td>
                        <td>" . htmlspecialchars($row['diagnosticTest']) . "</td>
                        <td>" . (!empty($row['diagnosticResult']) ? htmlspecialchars($row['diagnosticResult']) : 'Pending') . "</td>
                        <td>" . date('F d, Y', strtotime($row['appointmentDate'])) . "</td>
                        <td>
                            <button onclick='updateStatus($appointmentID, \"Finished\")' $disableFinished>Finished</button>
                            <button onclick='updateStatus($appointmentID, \"Cancelled\")' $disableCancelled>Cancelled</button>
                        </td>
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