<?php
if (isset($_GET['searchQuery'])) {
    $searchQuery = $_GET['searchQuery'];

    // Database connection
    $conn = new mysqli('localhost', 'root', 'ravanera1124', 'MedicalSystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL query to search for patients by first name or last name
    $stmt = $conn->prepare("SELECT * FROM patientsRecord WHERE firstName LIKE ? OR lastName LIKE ?");
    $searchTerm = "%" . $searchQuery . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the data
    $patients = [];
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row;
    }

    // Return results as JSON
    echo json_encode($patients);

    $stmt->close();
    $conn->close();
}
?>
