<?php
if (isset($_GET['searchQuery'])) {
    $searchQuery = $_GET['searchQuery'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '091203', 'MedicalSystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


if (isset($_GET['query'])) {
    $query = $_GET['query'];
    
    // Sanitize input to prevent SQL injection
    $query = htmlspecialchars($query);
    
    // SQL query to search for patients
    $sql = "SELECT * FROM patients WHERE first_name LIKE ? OR last_name LIKE ?";
    
    // Prepare and execute the statement
    if ($stmt = $conn->prepare($sql)) {
        $searchTerm = "%$query%";
        $stmt->bind_param('ss', $searchTerm, $searchTerm);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $patients = [];
        
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row; // Add patient to results
        }
        
        // Return results as JSON
        echo json_encode($patients);
    } else {
        echo json_encode(['error' => 'Failed to prepare the SQL query']);
    }
}
?>