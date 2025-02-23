<?php
    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    function connectDB() {
        $servername = "localhost";
        $username = "root";
        $password = "12345";
        $dbname = "MedicalSystem";
        
        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch(PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
            return null;
        }
    }

    $conn = connectDB();
    if (!$conn) {
        die("Database connection failed");
    }

    $userId = $_SESSION['user_id'];
    $sql = "SELECT FirstName, LastName FROM AuthorizeUser WHERE AuthorizeUserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $userId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($result) > 0) {
        $user = $result[0];
        $fullName = $user['FirstName'];
        
        if (!empty($user['LastName'])) {
            $fullName .= " " . $user['LastName'];
        }
    } 
    else {
        $fullName = "User";
    }
    
    if (isset($_GET['action']) && $_GET['action'] == 'logout' && isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        $_SESSION = array();
        
        session_destroy();
        
        header("Location: login.php");
        exit();
    }
    

    function searchPatient($searchTerm) {
        $conn = connectDB();
        if (!$conn) return false;
        
        try {
            $query = "SELECT 
                p.*,
                a.appointmentID,
                a.appointmentDate,
                a.diagnosticTest,
                a.diagnosticResult,
                a.appointmentStatus,
                ass.diagnosis,
                ass.prescription,
                ass.assessmentDate,
                p.weight,
                p.height,
                p.temperature,
                p.bloodPressure,
                p.heartRate
            FROM patientsRecord p 
            LEFT JOIN appointment a ON p.patientID = a.patientID 
            LEFT JOIN assessment ass ON a.appointmentID = ass.appointmentID
            WHERE p.patientID LIKE :search 
            OR p.firstName LIKE :search 
            OR p.lastName LIKE :search 
            OR CONCAT(p.firstName, ' ', p.lastName) LIKE :search
            ORDER BY a.appointmentDate DESC";
            
            $stmt = $conn->prepare($query);
            $searchTerm = "%$searchTerm%";
            $stmt->bindParam(':search', $searchTerm);
            $stmt->execute();
            
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($results)) {
                error_log("No results found for search term: " . $searchTerm);
            }
            
            return $results;
        } 
        catch(PDOException $e) {
            error_log("Search error: " . $e->getMessage());
            return false;
        }
    }

    function saveAssessment($appointmentID, $diagnosis, $prescription) {
        $conn = connectDB();
        if (!$conn) return false;
        
        try {
            $conn->beginTransaction();
            
            $checkQuery = "SELECT assessmentID FROM assessment WHERE appointmentID = :appointmentID";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bindParam(':appointmentID', $appointmentID);
            $checkStmt->execute();
            
            if ($checkStmt->rowCount() > 0) {
                $query = "UPDATE assessment 
                        SET diagnosis = :diagnosis, 
                            prescription = :prescription,
                            assessmentDate = CURRENT_TIMESTAMP 
                        WHERE appointmentID = :appointmentID";
            } 
            else {
                $query = "INSERT INTO assessment (appointmentID, diagnosis, prescription) 
                        VALUES (:appointmentID, :diagnosis, :prescription)";
            }
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':appointmentID', $appointmentID);
            $stmt->bindParam(':diagnosis', $diagnosis);
            $stmt->bindParam(':prescription', $prescription);
            $stmt->execute();
            
            $updateQuery = "UPDATE appointment 
                        SET appointmentStatus = 'Finished' 
                        WHERE appointmentID = :appointmentID";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bindParam(':appointmentID', $appointmentID);
            $updateStmt->execute();
            
            $conn->commit();
            return true;
        } 
        catch(PDOException $e) {
            $conn->rollBack();
            error_log("Save assessment error: " . $e->getMessage());
            return false;
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        header('Content-Type: application/json');
        
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'search':
                    if (!isset($_POST['search_term'])) {
                        echo json_encode(['error' => 'Search term is required']);
                        exit;
                    }
                    $searchResults = searchPatient($_POST['search_term']);
                    echo json_encode($searchResults);
                    break;
                    
                case 'save':
                    if (!isset($_POST['appointmentID']) || !isset($_POST['diagnosis']) || !isset($_POST['prescription'])) {
                        echo json_encode(['error' => 'Missing required fields']);
                        exit;
                    }
                    $result = saveAssessment(
                        $_POST['appointmentID'],
                        $_POST['diagnosis'],
                        $_POST['prescription']
                    );
                    echo json_encode(['success' => $result]);
                    break;

                case 'delete':
                    if (!isset($_POST['appointmentID'])) {
                        echo json_encode(['error' => 'Appointment ID is required']);
                        exit;
                    }
                    
                    $conn = connectDB();
                    if (!$conn) {
                        echo json_encode(['error' => 'Database connection failed']);
                        exit;
                    }
                    
                    try {
                        $conn->beginTransaction();
                        
                        $deleteAssessment = "DELETE FROM assessment WHERE appointmentID = :appointmentID";
                        $stmt = $conn->prepare($deleteAssessment);
                        $stmt->bindParam(':appointmentID', $_POST['appointmentID']);
                        $stmt->execute();
                        
                        $updateAppointment = "UPDATE appointment SET appointmentStatus = 'Pending' 
                                            WHERE appointmentID = :appointmentID";
                        $stmt = $conn->prepare($updateAppointment);
                        $stmt->bindParam(':appointmentID', $_POST['appointmentID']);
                        $stmt->execute();
                        
                        $conn->commit();
                        echo json_encode(['success' => true]);
                    }
                    catch(PDOException $e) {
                        $conn->rollBack();
                        error_log("Delete assessment error: " . $e->getMessage());
                        echo json_encode(['error' => 'Failed to delete assessment']);
                    }
                    break;
                
                default:
                    echo json_encode(['error' => 'Invalid action']);
                    break;
            }
            exit;
        }
    }
?>

<!DOCTYPE html> 
<html lang="en">
<<<<<<< HEAD
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
            <title>Dashboard</title>

            <style>
                    body {
                        background-color: #97CADB;
                        margin: 0;
                        padding: 0;
                        font-family: "M PLUS Rounded 1c", serif;
                        overflow-x: hidden;
                    }

                    h2 {
                        font-family: "M PLUS Rounded 1c", serif;
                        font-weight: 900;
                        font-style: normal;
                        letter-spacing: 10px;
                        color: white;
                        position: absolute;
                        left: 20px;
                        top: 10%;
                        transform: translateY(-50%);
                    }

                    header {
                        padding: 0;
                        margin: 0;
                        background-color: #018ABE;
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        z-index: 1000;
                        height: 50px;
                    }

                    aside {
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 200px;
                        height: 100vh;
                        background-color: white;
                        padding-top: 60px;
                        color: #333333;
                        font-size: 18px;
                        padding-left: 10px;
                        padding-right: 10px;
                    }

                    .profile {
                        height: 12%;
                        width: 88%;
                        padding: 10px;
                        padding-top: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: flex-start;
                        border: 2px solid #E6EAEF;
                    }

                    .profile i {
                        font-size: 50px;
                        margin-left: -5px;
                    }

                    .profile .fa-pen-to-square {
                        position: absolute;
                        top: 1px;
                        right: 2px;
                        font-size: 20px;
                        color: #02457A;
                        cursor: pointer;
                    }

                    .profile p {
                        margin-left: 8px;
                        font-size: 12px;
                    }

                    aside ul {
                        list-style-type: none;
                        padding: 0;
                        margin: 0;
                    }

                    aside ul a {
                        border: 2px solid #E6EAEF;
                        display: flex;
                        align-items: center;
                        padding: 10px 20px;
                        text-decoration: none;
                        color:rgb(0, 31, 62);
                        margin: 10px 0;
                        font-size: 15px;
                        font-weight: bold;
                        border-radius: 5px;
                        transition: background-color 0.3s ease;
                    }

                    aside ul a:hover {
                        background-color: #1D70A0;
                        color:white;
                    }
                    aside ul a i {
                        margin-right: 10px;
                    }

                    main {
                        margin-top: 60px;
                        margin-left: 240px;
                        background-color: white;
                        width: 166vh;
                        height: auto;
                        padding: 20px;
                        box-sizing: border-box;
                    }
                    
                    .panel {
                        border-radius: 10px;
                        position: relative;
                        top: 0;
                        width: 98%;
                        padding: 16px;
                        background-color: #cad0d5;
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        margin-top: -8px;
                        margin-left: -1vh;
                    }

                    .panel .left-section button {
                        padding: 10px 15px;
                        background-color: #02457A;
                        color: white;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                    }

                    .panel .left-section i {
                        padding: 10px 15px;
                        background-color: #02457A;
                        color: white;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                    }

                    .panel .left-section button:hover {
                        background-color: #45a049;
                    }

                    .panel .right-section {
                        display: flex;
                        align-items: center;
                        justify-content: flex-end;
                        width: auto;
                    }

                    .panel .right-section input[type="text"] {
                        padding: 8px;
                        font-size: 14px;
                        border-radius: 5px;
                        border: 1px solid #02457A;
                        margin-right: 10px;
                        color: #02457A;
                    }

                    .panel .right-section i {
                        font-size: 20px;
                        margin-left: 10px;
                        cursor: pointer;
                        color: #02457A;
                    }

                    .panel .right-section i:hover {
                        color: white;
                    }

                    .test-options {
                        display: flex;
                        justify-content: space-between;
                        margin-top: 5px;
                        width: 100%;
                        padding: 10px;
                        margin-left: -1.4vh;
                    }

                    .test-options button {
                        padding: 10px 20px;
                        background-color: transparent;
                        color: #02457A;
                        border: 2px solid #02457A;
                        border-radius: 5px;
                        cursor: pointer;
                        font-weight: bold;
                        width: 22%;
                    }

                    .test-options button:hover {
                        background-color: #02457A;
                        color:white;
                    }

                    .bg {
                        width: 161vh;
                        height: 80vh;
                    }

                    .assessment-content {
                        display: grid;
                        grid-template-columns: 1fr;
                        gap: 20px;
                        padding: 20px;
                        background: linear-gradient(115deg, rgba(107, 199, 218, 0.78) 0%, rgba(151, 202, 219, 0.78) 45%, rgba(1, 138, 190, 0.78) 91%);
                        border-radius: 10px;
                        margin-top: 20px;
                        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    }
                    
                    .patient-info, .physical-exam, .diagnostic {
                        display: flex;
                        flex-direction: column;
                    }

                    .input-group {
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 20px;
                        margin-bottom: 15px;
                    }

                    .input-group input,
                    .input-group textarea {
                        padding: 10px;
                        border-radius: 5px;
                        border: 1px solid #ddd;
                        font-size: 14px;
                    }

                    .input-group-three input,
                    .input-group-three textarea {
                        padding: 10px;
                        border-radius: 5px;
                        border: 1px solid #ddd;
                        font-size: 14px;
                    }

                    .section-header {
                        font-size: 18px;
                        font-weight: bold;
                        color: #02457A;
                        margin-bottom: 10px;
                    }

                    .input-group input {
                        width: 90%;
                    }

                    .assessment-content .input-group {
                        margin-bottom: 20px;
                    }   
                    
                    .input-group .symptoms, 
                    .input-group .medical-history, 
                    .input-group .diagnosis,
                    .input-group .prescriptions  {
                        width: 90%;
                        padding: 10px;
                        border-radius: 5px;
                        border: 1px solid #ddd;
                        font-size: 14px;
                        resize: vertical;
                        min-height: 50px;
                        height: auto;
                    }

                    .buttons-group {
                        display: flex;
                        gap: 10px;
                        margin-top: 20px;
                        justify-content: flex-start;
                    }

                    .buttons-group button {
                        padding: 10px 20px;
                        border-radius: 5px;
                        font-weight: bold;
                        cursor: pointer;
                        border: none;
                    }

                    .save-btn {
                        background-color: #02457A;
                        color: white;
                    }

                    .cancel-btn {
                        background-color:rgb(7, 184, 63);
                        color: white;
                    }

                    .delete-btn {
                        background-color: #d9534f;
                        color: white;
                    }

                    .buttons-group button:hover {
                        opacity: 0.8;
                    }
                </style>
        </head>

        <body>
                <header>
                    <h2>MEDICARE</h2>
                </header>
                <aside>
                    <div class="profile">
                        <i class="fa-solid fa-circle-user"></i>
                        <span id="authorizedName"><?php echo htmlspecialchars($fullName); ?></span>
                        <i class="fa-regular fa-pen-to-square"></i>
                    </div>

                    <ul>
                        <li><a href="Dashboard.php"><i class="material-icons-outlined">dashboard</i> Dashboard</a></li>
                        <li><a href="Record.php"><i class="material-icons-outlined">description</i> Record</a></li>
                        <li><a href="Assessment.php"><i class="material-icons-outlined">assessment</i> Assessment</a></li>
                        <li><a href="Appointment.php"><i class="material-icons-outlined">calendar_today</i> Appointment</a></li>
                        <li><a href="setting.php"><i class="material-icons-outlined">settings</i> Settings</a></li>
                        <li><a href="javascript:void(0);"  onclick="confirmLogout()"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </aside>

                <main>
                    <div class="panel">
                        <div class="left-section">
                            <span class="assessment-text"><i class="material-icons-outlined">assessment</i> &nbsp;Assessment</span>
                        </div>

                        <div class="right-section">
                            <input type="text" id="searchInput" placeholder="Search by ID, name, or full name...">
                            <i class="fas fa-search" id="searchButton"></i>
                            <i class="fas fa-bell"></i>
                        </div>

                    </div>

                    <div class="assessment-content">
                        <div class="patient-info">
                            <div class="section-header">Patient Information</div>
                            <div class="input-group">
                                <input type="text" id="firstName" placeholder="First Name" readonly>
                                <input type="text" id="lastName" placeholder="Last Name" readonly>
                            </div>

                            <div class="input-group">
                                <input type="number" id="age" placeholder="Age" readonly>
                                <input type="text" id="gender" placeholder="Gender" readonly>
                            </div>

                            <div class="input-group">
                                <input type="date" id="assessmentDate" placeholder="Assessment Date">
                                <input type="date" id="birthDate" placeholder="Birth Date" readonly>
                            </div>

                            <div class="input-group">
                                <textarea id="symptoms" class="symptoms" placeholder="Symptoms" readonly></textarea>
                                <textarea id="medicalHistory" class="medical-history" placeholder="Medical History" readonly></textarea>
                            </div>
                        </div>

                        <div class="physical-exam">
                            <div class="section-header">Physical Examination</div>
                            <div class="input-group">
                                <input type="number" id="heightField" class="input-field" placeholder="Height (cm)">
                                <input type="number" id="weightField" class="input-field" placeholder="Weight (kg)">
                            </div>
                            
                            <div class="input-group">
                                <input type="text" id="temperature" class="input-field" placeholder="Temperature (°C)">
                                <input type="text" id="heartRate" class="input-field" placeholder="Heart Rate">
                                <input type="text" id="bloodPressure" class="input-field" placeholder="Blood Pressure">
                            </div>
                        </div>

                        <div class="diagnostic">
                            <div class="section-header">Diagnostic Results</div>
                                <div class="input-group">
                                    <input type="text" id="testName" class="input-field" placeholder="Test Name">
                                    <input type="text" id="testResult" class="input-field" placeholder="Test Result">
                                </div>

                                <div class="diagnosis">
                                    <div class="section-header">Diagnosis</div>
                                    <div class="input-group">
                                        <textarea id="diagnosisText" class="diagnosis" placeholder="Diagnosis"></textarea>
                                        <textarea id="prescriptions" class="prescriptions" placeholder="Prescriptions"></textarea>

                                        <div class="buttons-group">
                                            <button type="button" id="saveBtn" class="save-btn">Save</button>
                                            <button type="button" id="cancelBtn" class="cancel-btn">Cancel</button>
                                            <button type="button" id="deleteBtn" class="delete-btn">Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </main>
        </body>

        <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const searchButton = document.querySelector('#searchButton');
                    const searchInput = document.querySelector('#searchInput');
                    const saveBtn = document.querySelector('#saveBtn');
                    let currentAppointmentId = null;
                    
                    function handleSearch() {
                        const searchTerm = searchInput.value.trim();
                        
                        if (!searchTerm) {
                            alert('Please enter a search term');
                            return;
                        }
                        
                        const formData = new FormData();
                        formData.append('action', 'search');
                        formData.append('search_term', searchTerm);
                        
                        fetch('Assessment.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Search results:', data);
                            if (data && Array.isArray(data) && data.length > 0) {
                                currentAppointmentId = data[0].appointmentID;
                                console.log('Set currentAppointmentId:', currentAppointmentId);
                                fillPatientData(data[0]);
                            } else if (data && data.error) {
                                alert(data.error);
                                resetForm();
                            } else {
                                alert('No patient found');
                                resetForm();
                            }
                        })
                        .catch(error => {
                            console.error('Error searching:', error);
                            alert('Error searching for patient');
                            resetForm();
                        });
                    }
                    
                    function fillPatientData(patient) {
                        console.log('Filling patient data with appointmentID:', patient.appointmentID);
                        
                        currentAppointmentId = patient.appointmentID;
                        
                        // Basic patient information
                        document.querySelector('#firstName').value = patient.firstName || '';
                        document.querySelector('#lastName').value = patient.lastName || '';
                        document.querySelector('#age').value = patient.age || '';
                        document.querySelector('#gender').value = patient.gender || '';
                        document.querySelector('#birthDate').value = patient.birthday || '';
                        document.querySelector('#symptoms').value = patient.symptoms || '';
                        document.querySelector('#medicalHistory').value = patient.medicalHistory || '';

                        // Physical examination data
                        document.querySelector('#heightField').value = patient.height || '';
                        document.querySelector('#weightField').value = patient.weight || '';
                        document.querySelector('#temperature').value = patient.temperature || '';
                        document.querySelector('#bloodPressure').value = patient.bloodPressure || '';
                        document.querySelector('#heartRate').value = patient.heartRate || '';

                        // Diagnostic data
                        document.querySelector('#testName').value = patient.diagnosticTest || '';
                        document.querySelector('#testResult').value = patient.diagnosticResult || '';

                        // Assessment data
                        document.querySelector('#diagnosisText').value = patient.diagnosis || '';
                        document.querySelector('#prescriptions').value = patient.prescription || '';

                        // Set assessment date
                        if (patient.assessmentDate) {
                            document.querySelector('#assessmentDate').value = patient.assessmentDate.split(' ')[0];
                        } else {
                            document.querySelector('#assessmentDate').value = new Date().toISOString().split('T')[0];
                        }
                        const saveBtn = document.querySelector('#saveBtn');
                        const deleteBtn = document.querySelector('#deleteBtn');
                        
                        saveBtn.disabled = false;
                        saveBtn.classList.remove('disabled');
                        deleteBtn.disabled = false;
                        
                        if (patient.appointmentStatus === 'Finished') {
                            saveBtn.disabled = true;
                            saveBtn.classList.add('disabled');
                        }
                    }
                    
                    saveBtn.addEventListener('click', function() {
                        console.log('Save clicked. CurrentAppointmentId:', currentAppointmentId);
                        
                        if (!currentAppointmentId) {
                            alert('Please search for a patient first');
                            return;
                        }
                        
                        const diagnosis = document.querySelector('#diagnosisText').value;
                        const prescription = document.querySelector('#prescriptions').value;
                        
                        if (!diagnosis || !prescription) {
                            alert('Please fill in both diagnosis and prescription');
                            return;
                        }
                        
                        const formData = new FormData();
                        formData.append('action', 'save');
                        formData.append('appointmentID', currentAppointmentId);
                        formData.append('diagnosis', diagnosis);
                        formData.append('prescription', prescription);
                        
                        fetch('Assessment.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Assessment saved successfully');
                                saveBtn.disabled = true;
                                saveBtn.classList.add('disabled');
                            } 
                            else {
                                alert(data.error || 'Error saving assessment');
                            }
                        })
                        .catch(error => {
                            console.error('Save error:', error);
                            alert('Error saving assessment');
                        });
                    });

                    document.querySelector('#deleteBtn').addEventListener('click', function() {
                        console.log('Delete clicked. CurrentAppointmentId:', currentAppointmentId);
                        
                        if (!currentAppointmentId) {
                            alert('No assessment selected');
                            return;
                        }

                        if (confirm('Are you sure you want to delete this assessment?')) {
                            const formData = new FormData();
                            formData.append('action', 'delete');
                            formData.append('appointmentID', currentAppointmentId);

                            fetch('Assessment.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    alert('Assessment deleted successfully');
                                    resetForm();
                                } else {
                                    alert(data.error || 'Error deleting assessment');
                                }
                            })
                            .catch(error => {
                                console.error('Delete error:', error);
                                alert('Error deleting assessment');
                            });
                        }
                    });
                    
                    function resetForm() {
                        currentAppointmentId = null;
                        console.log('Form reset. CurrentAppointmentId cleared:', currentAppointmentId);
                        
                        const inputs = document.querySelectorAll('.assessment-content input, .assessment-content textarea');
                        inputs.forEach(input => input.value = '');
                        
                        document.querySelector('#assessmentDate').value = new Date().toISOString().split('T')[0];
                        
                        const saveBtn = document.querySelector('#saveBtn');
                        const deleteBtn = document.querySelector('#deleteBtn');
                        saveBtn.disabled = false;
                        saveBtn.classList.remove('disabled');
                        deleteBtn.disabled = true;
                    }
                    
                    searchButton.addEventListener('click', handleSearch);
                    searchInput.addEventListener('keypress', (e) => {
                        if (e.key === 'Enter') {
                            handleSearch();
                        }
                    });
                    
                    document.querySelector('#cancelBtn').addEventListener('click', resetForm);

                    function confirmLogout() {
                        if (confirm("Are you sure you want to logout?")) {
                            window.location.href = "?action=logout&confirm=yes";
                            alert('Successful Logout!');
                        }
                    }
                    window.confirmLogout = confirmLogout;
                });
        </script>
</html>