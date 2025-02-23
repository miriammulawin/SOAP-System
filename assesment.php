<?php
// Headers to allow JSON responses and CORS
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Database Connection
$host = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "MedicalSystem"; 

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Get the request method
$method = $_SERVER["REQUEST_METHOD"];

// Handle request types
switch ($method) {
    case "GET":
        if (isset($_GET["assessmentID"])) {
            getAssessmentByID($conn, $_GET["assessmentID"]);
        } else {
            getAllAssessments($conn);
        }
        break;
    case "POST":
        addAssessment($conn);
        break;
    case "PUT":
        updateAssessment($conn);
        break;
    case "DELETE":
        deleteAssessment($conn);
        break;
    default:
        echo json_encode(["error" => "Invalid request method"]);
}

// Function: Retrieve all assessments
function getAllAssessments($conn) {
    $sql = "SELECT a.assessmentID, a.appointmentID, p.firstName, p.lastName, a.diagnosis, a.prescription, a.assessmentDate 
            FROM assessment a
            JOIN appointment ap ON a.appointmentID = ap.appointmentID
            JOIN patientsRecord p ON ap.patientID = p.patientID
            ORDER BY a.assessmentDate DESC";
    $result = $conn->query($sql);

    $assessments = [];
    while ($row = $result->fetch_assoc()) {
        $assessments[] = $row;
    }
    echo json_encode($assessments);
}

// Function: Retrieve a specific assessment by ID
function getAssessmentByID($conn, $assessmentID) {
    $sql = "SELECT * FROM assessment WHERE assessmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $assessmentID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["message" => "No assessment found"]);
    }
}

// Function: Add a new assessment
function addAssessment($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["appointmentID"], $data["diagnosis"], $data["prescription"])) {
        $appointmentID = $data["appointmentID"];
        $diagnosis = $conn->real_escape_string($data["diagnosis"]);
        $prescription = $conn->real_escape_string($data["prescription"]);

        $sql = "INSERT INTO assessment (appointmentID, diagnosis, prescription) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $appointmentID, $diagnosis, $prescription);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Assessment added successfully"]);
        } else {
            echo json_encode(["error" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Missing required fields"]);
    }
}

// Function: Update an assessment
function updateAssessment($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data["assessmentID"], $data["diagnosis"], $data["prescription"])) {
        $assessmentID = $data["assessmentID"];
        $diagnosis = $conn->real_escape_string($data["diagnosis"]);
        $prescription = $conn->real_escape_string($data["prescription"]);

        $sql = "UPDATE assessment SET diagnosis=?, prescription=? WHERE assessmentID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $diagnosis, $prescription, $assessmentID);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Assessment updated successfully"]);
        } else {
            echo json_encode(["error" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Missing required fields"]);
    }
}

// Function: Delete an assessment
function deleteAssessment($conn) {
    parse_str(file_get_contents("php://input"), $data);

    if (isset($data["assessmentID"])) {
        $assessmentID = $data["assessmentID"];
        $sql = "DELETE FROM assessment WHERE assessmentID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $assessmentID);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Assessment deleted successfully"]);
        } else {
            echo json_encode(["error" => "Error: " . $conn->error]);
        }
    } else {
        echo json_encode(["error" => "Missing assessment ID"]);
    }
}

// Close database connection
$conn->close();
?>
