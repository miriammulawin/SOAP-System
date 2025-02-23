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

?>

<!DOCTYPE html>
<html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
            <title>Medical System: Records</title>

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
                    color: rgb(0, 31, 62);
                    margin: 10px 0;
                    font-size: 15px;
                    font-weight: bold;
                    border-radius: 5px;
                    transition: background-color 0.3s ease;
                }

                aside ul a:hover {
                    background-color: #1D70A0;
                    color: white;
                }

                aside ul a i {
                    margin-right: 10px;
                }

                main {
                    margin-top: 60px;
                    margin-left: 240px;
                    background-color: white;
                    width: 160vh;
                    height: 113vh;
                    padding: 20px;
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
                    color: white;
                }

                .record-content {
                    margin-left: -1vh;
                    margin-top: 5px;
                }

                .bg {
                    width: 161vh;
                    height: 80vh;
                }

                .record-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 15px;
                    background: #F1F4FB;
                    border: 1px solid #000;
                    border-radius: 5px;
                    margin-top: 15px;
                }

                .header-title {
                    font-size: 23px;
                    font-weight: bold;
                    color: rgb(4, 43, 69);
                    margin: 0;
                }

                .action-icons {
                    display: flex;
                    gap: 10px;
                    align-items: center;
                    justify-content: flex-end;
                    color: #02457A;
                }

                .action-icons i {
                    font-size: 18px;
                    cursor: pointer;
                }

                .action-icons i:hover {
                    color: #1D70A0;
                }

                .record-content {
                    margin-top: 20px;
                    width: 100%;
                    height: calc(100vh - 80px);
                    background-color: #E6EAEF;
                    box-sizing: border-box;
                    padding: 20px;
                    overflow-y: auto;
                }

                .modal {
                    display: none;
                    position: fixed;
                    z-index: 1;
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0,0,0,0.4);
                    overflow-y: auto;
                }

                .modal-content {
                    background: rgb(216, 235, 241);
                    margin: 5% auto;
                    padding: 20px;
                    width: 50%;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    max-width: 600px;
                    position: relative;
                }
                
                .modal-content::before {
                    content: "";
                    position: absolute;
                    top: -20px;
                    left: -20px;
                    right: -20px;
                    bottom: -20px;
                    background: #97CADB;
                    border-radius: 16px;
                    z-index: -1;
                }

                .modal-content h2{
                    font-weight: normal;
                    font-size: 20px;
                }

                .close {
                    position: absolute;
                    top: 10px;
                    right: 15px;
                    font-size: 24px;
                    cursor: pointer;
                }

                .form-group {
                    margin-bottom: 10px;
                    text-align: left;
                    flex: 1;
                }

                input, textarea, select {
                    width: 100%;
                    padding: 12px;
                    margin-top: 5px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    box-sizing: border-box;
                }

                .row {
                    display: flex;
                    gap: 15px;
                    flex-wrap: wrap;
                }

                .date-container {
                    text-align: right;
                    display: flex;
                    flex-direction: column;
                    align-items: flex-end;
                    margin-bottom: 10px;
                    width: 180px;
                    margin-left: auto;
                }

                .date-container label{
                    margin-right: 140px;
                }

                .btn-submit {
                    display: block;
                    width: 100%;
                    padding: 12px;
                    background: #28a745;
                    color: white;
                    font-size: 16px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                }

                .btn-submit:hover {
                    background: #218838;
                }

                .test-text {
                    font-weight: bold;
                    margin-top: 15px;
                    text-align: center;
                    font-size: 20px;
                }

                .radio-group {
                    display: flex;
                    gap: 15px;
                    flex-wrap: wrap;
                    justify-content: center;
                    margin-top: 5px;
                    font-size: 16px;
                    margin-bottom: 15px;
                }

                .radio-group .top-group {
                    display: flex;
                    gap: 20px;
                    justify-content: center;
                    margin-bottom: 15px;
                }

                .radio-group .bottom-group {
                    display: flex;
                    gap: 20px;
                    justify-content: center;
                }

                .radio-group label {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                    font-size: 18px;
                    text-align: center;
                }

                .popup-modal {
                    display: none;
                    position: fixed;
                    left: 50%;
                    top: 30%;
                    transform: translate(-50%, -50%);
                    background-color: rgba(0, 0, 0, 0.8);
                    color: #fff;
                    padding: 15px;
                    border-radius: 8px;
                    text-align: center;
                    width: 300px;
                    z-index: 1000;
                    font-size: 16px;
                }

                .popup-content {
                    padding: 10px;
                }

                .success {
                    background-color: #28a745;
                }
                
                .error {
                    background-color: #dc3545;
                }

                #testTable {
                    width: 100%;
                    margin: 20px 0;
                    border-collapse: collapse;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    font-family: "M PLUS Rounded 1c", serif;
                }

                #testTable table {
                    width: 100%;
                    border: 1px solid #ddd;
                    text-align: left;
                }

                #testTable th {
                    background-color: #018ABE;
                    color: white;
                    padding: 5px;
                    font-size: 10px;
                    text-align: center;
                }

                #testTable td {
                    padding: 5px;
                    border-bottom: 1px solid #ddd;
                    text-align: center;
                }

                #testTable tr:hover {
                    background-color: #f2f2f2;
                }

                #testTable tr:nth-child(even) {
                    background-color: #f9f9f9;
                }

                .table-container {
                    margin: 20px auto;
                    max-width: 1000px;
                    overflow-x: auto;
                }

                #testTable th, #testTable td {
                    padding: 3px;
                }

                table {
                    width: 100%;
                    border-collapse: collapse;
                    text-align: center;
                    font-size: 13px;
                }
                table, th, td {
                    border: 1px solid black;
                    
                }
                th, td {
                    padding: 8px;
                    text-align: center;
                }
                th {
                    background-color: #f2f2f2;
                }
                th:first-child, td:first-child {
                    width: 20px;
                }
                th.action-column, td.action-column {
                    width: 200px; 
                    padding: 9px; 
                    text-align: center;
                }
                th.birth-column, td.birth-column {
                    width: 100px; 
                    padding: 5px; 
                    text-align: center;
                }
                th.name, td.name {
                    width: 220px; 
                    padding: 5px;
                    text-align: center;
                }
                th.age, td.age {
                    width: 70px; 
                    padding: 5px; 
                    text-align: center;
                }    
                .btn {
                    font-family: "M PLUS Rounded 1c", serif; 
                    padding: 3px 5px;
                    cursor: pointer;
                    margin: 2px;
                    font-size: 13px;
                    border: 1px solid #02457A; 
                    border-radius: 2px;
                }
                .btn-edit {
                    background-color:rgb(30, 57, 101);
                    color: white;
                    width: 50px;
                }
                .btn-view {
                    background-color: rgb(21, 117, 16); 
                    color: white;
                }
                .btn-delete {
                    background-color: #f44336;
                    color: white;
                }
                .close {
                    color: #02457A; 
                    float: right; 
                    font-size: 28px; 
                    font-weight: bold; 
                    cursor: pointer; 
                }
                .close:hover,
                .close:focus {
                    color: #ff0000;
                    text-decoration: none; 
                    cursor: pointer; 
                }
                h1 {
                    color: #02457A; 
                    text-align: center; 
                }
                h3.fill {
                    color: #02457A; 
                }
                .row {
                    display: flex; 
                    justify-content: space-between; 
                    margin-bottom: 15px; 
                }
                .col {
                    flex: 1; 
                    padding: 0 10px; 
                }
                footer {
                    text-align: center; 
                    margin-top: 20px; 
                    color: #02457A; 
                }
                .modal-disp {
                    display: none;
                    position: fixed; 
                    z-index: 1000; 
                    left: 0;
                    top: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0,0,0,0.4); 
                    overflow-y: auto; 
                }
                .modal-contentDisp {
                    background: rgb(216, 235, 241);
                    margin: 5% auto;
                    padding: 20px;
                    width: 50%;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    position: relative; 
                }
                .modal-contentDisp .close {
                    position: absolute;
                    top: 15px;
                    right: 20px;
                    background: transparent;
                    border: none;
                    color: #ff0000; 
                    font-size: 28px; 
                    cursor: pointer;
                    padding: 5px; 
                    transition: color 0.3s ease; 
                }
                .modal-contentDisp .close:hover {
                    color: #ff4d4d; 
                }
                #patientInfo {
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                    margin-top: 20px;
                }
                .displayRow {
                    display: flex;
                    justify-content: flex-start; 
                    width: 100%;
                    margin-bottom: 15px;
                }
                .displayCol {
                    flex: 1;
                    padding: 0 10px;
                }
                .displayCol p {
                    margin: 5px 0;
                }
                h1 {
                    color: #02457A;
                    text-align: left; 
                }
                h3.fill {
                    color: #02457A;
                }
            </style>
        </head>

        <body>
            <!-- [ /// HEADER /// ] -->
            <header>
                <h2>MEDICARE</h2>
            </header>
            <!-- [ /// SIDEBAR /// ] -->
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
                    <li><a href="Settings.php"><i class="material-icons-outlined">settings</i> Settings</a></li>
                    <li><a href="javascript:void(0);"  onclick="confirmLogout()"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </aside>
            <!-- [ /// TOP-BAR /// ] -->
            <main>
                <div id="record-panel" class="content-panel">
                    <div class="panel">
                        <div class="left-section">
                            <button id="openModalBtn">ADD PATIENTS</button>
                        </div>
                        <div class="right-section">
                            <input type="text" placeholder="Search...">
                            <i class="fas fa-search"></i>
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                </div>
                <!-- [ /// RECORD HEADER /// ] -->
                <div class="record-header">
                    <div class="header-title">Record</div>
                    <div class="action-icons">
                        <i id = "openModalIcon" class="fas fa-circle-plus"></i>
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash"></i>
                        <i class="fas fa-th grid-icon"></i>
                    </div>
                </div>
                <!-- [ /// RECORD PATIENT LIST CONTENT /// ] -->
                <div class="record-content">
                    <table id="patientsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class = "name">Full Name</th>
                                <th class = "age">Age</th>
                                <th class = "birth-column">Birthday</th>
                                <th>Symptoms</th>
                                <th class = "action-column">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- [ /// DYNAMICALLY ADD NEW ROW /// ] -->
                        </tbody>
                    </table>

                    <script>
                        let isEditable = false;
                        let currentRow = null;

                        document.addEventListener("DOMContentLoaded", function() {
                            fetchPatients();
                        });
                        // [ /// FUNCTION HANDLE DISPLAY /// ] 
                        function fetchPatients() {
                            fetch("fetch_patient_record.php")
                            .then(response => response.json())
                            .then(data => {
                                const tableBody = document.getElementById("patientsTable").querySelector("tbody");
                                tableBody.innerHTML = ""; // Clear existing rows
                                data.forEach(patient => {
                                    tableBody.innerHTML += `
                                        <tr id="row-${patient.patientID}">
                                            <td>${patient.patientID}</td>
                                            <td>${patient.fullName}</td>
                                            <td>${patient.age}</td>
                                            <td>${patient.birthday}</td>
                                            <td>${patient.symptoms}</td>
                                            <td class="action-column">
                                                <button class="btn-view" onclick="viewPatient(${patient.patientID})">View</button>
                                                <button class="btn-edit" onclick="editPatient(${patient.patientID})">Edit</button>
                                                <button class="btn-delete" onclick="deletePatient(${patient.patientID})">Delete</button>
                                            </td>
                                        </tr>
                                    `;
                                });
                            })
                            .catch(error => {
                                console.error('Error fetching patients:', error);
                            });
                        }
                        // [ /// FUNCTION HANDLE SUBMITTED DATA UPON ADDING /// ] 
                        function handleFormSubmit(event) { // SMALL ADJUST
                            event.preventDefault();
                            const formData = new FormData(document.getElementById('patientForm'));

                            fetch('addPatientRecord.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert(data.message); 
                                    fetchPatientRecords(); // ADJUSTED
                                    document.getElementById("patientModal").style.display = "none"; 
                                } else {
                                    alert(data.message); 
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while adding the patient.'); 
                            });
                        }
                        function viewPatient(patientID) {
                            fetch(`fetch_patient_record.php?id=${patientID}`)
                            .then(response => response.json())
                            .then(patient => {
                                if (patient.error) {
                                    alert(patient.error);
                                } else {
                                    // Populate the modal with patient data
                                    document.getElementById('patientID').innerText = patient.patientID || 'N/A';
                                    document.getElementById('fullName').innerText = `${patient.firstName || 'N/A'} ${patient.lastName || 'N/A'}`;
                                    document.getElementById('address').innerText = patient.address || 'N/A';
                                    document.getElementById('age').innerText = patient.age || 'N/A';
                                    document.getElementById('birthday').innerText = patient.birthday || 'N/A';
                                    document.getElementById('gender').innerText = patient.gender || 'N/A';
                                    document.getElementById('height').innerText = patient.height ? `${patient.height} cm` : 'N/A';
                                    document.getElementById('weight').innerText = patient.weight ? `${patient.weight} kg` : 'N/A';
                                    document.getElementById('symptoms').innerText = patient.symptoms || 'N/A';
                                    document.getElementById('medicalHistory').innerText = patient.medicalHistory || 'N/A';
                                    document.getElementById('temperature').innerText = patient.temperature ? `${patient.temperature} °C` : 'N/A';
                                    document.getElementById('heartRate').innerText = patient.heartRate ? `${patient.heartRate} bpm` : 'N/A';
                                    document.getElementById('bloodPressure').innerText = patient.bloodPressure || 'N/A';
                                    document.getElementById('diagnosticTest').innerText = patient.diagnosticTest || 'N/A';

                                    document.getElementById('displayPatientModal').style.display = 'block';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching patient data:', error);
                                alert('An error occurred while fetching the patient data.');
                            });
                        }
                        function toggleEdit(patientID) {
                            const row = document.getElementById(`row-${patientID}`);
                            const cells = row.getElementsByTagName("td");

                            if (isEditable) {
                                for (let i = 1; i < cells.length - 1; i++) {
                                    cells[i].setAttribute("contenteditable", "false");
                                    cells[i].style.backgroundColor = "#f9f9f9";
                                }
                            } else {
                                for (let i = 1; i < cells.length - 1; i++) {
                                    cells[i].setAttribute("contenteditable", "true");
                                    cells[i].style.backgroundColor = "#ffffcc";
                                }
                            }
                            isEditable = !isEditable;
                            currentRow = row; 
                        }
                        // [ /// FUNCTION HANDLE AND UPDATE THE DATA FROM THE EDITED FORM /// ] 
                        function editPatient(patientID) {
                            fetch(`fetch_patient_record.php?id=${patientID}`)
                            .then(response => response.json())
                            .then(patient => {
                                if (patient.error) {
                                    alert(patient.error); 
                                } else {
                                    document.getElementById('edit_patientID').value = patient.patientID || '';
                                    document.getElementById('edit_first_name').value = patient.firstName || '';
                                    document.getElementById('edit_last_name').value = patient.lastName || '';
                                    document.getElementById('edit_address').value = patient.address || '';
                                    document.getElementById('edit_age').value = patient.age || '';
                                    document.getElementById('edit_gender').value = patient.gender || '';
                                    document.getElementById('edit_birthday').value = patient.birthday || '';
                                    document.getElementById('edit_symptoms').value = patient.symptoms || '';
                                    document.getElementById('edit_medical_history').value = patient.medicalHistory || '';
                                    document.getElementById('edit_height').value = patient.height || '';
                                    document.getElementById('edit_weight').value = patient.weight || '';
                                    document.getElementById('edit_temperature').value = patient.temperature || '';
                                    document.getElementById('edit_heart_rate').value = patient.heartRate || '';
                                    document.getElementById('edit_blood_pressure').value = patient.bloodPressure || '';

                                    document.getElementById('editPatientModal').style.display = 'block';
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching patient data:', error);
                                alert('An error occurred while fetching the patient data.');
                            });
                        }
                        // [ /// FUNCTION HANDLE AND UPDATE THE DATA FROM THE EDITED FORM /// ] 
                        function handleEditFormSubmit(event) { // SMALL ADJUST
                            event.preventDefault(); 
                            const formData = new FormData(document.getElementById('editPatientForm'));

                            fetch('updPatientRecord.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === 'success') {
                                    alert(data.message);
                                    fetchPatientRecords(); // ADJUSTED
                                    document.getElementById('editPatientModal').style.display = 'none'; 
                                } else {
                                    alert(data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('An error occurred while updating the patient record.');
                            });
                        }
                        // [ /// FUNCTION TO DELETE THE DATA FROM THE EDITED FORM /// ] 
                        function deletePatient(patientID) {
                            if (confirm("Are you sure you want to delete this patient record?")) {
                                fetch('delPatientRecord.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: `delete_id=${patientID}`
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.status === 'success') {
                                        alert(data.message);
                                        fetchPatientRecords(); 
                                    } else {
                                        alert(data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('An error occurred while deleting the patient record.');
                                });
                            }
                        }
                    </script>
                </div>
            </main>
            
            <!-- // [ /// ADD RECORD FORM /// ] -->
            <div id="patientModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="document.getElementById('patientModal').style.display='none'">&times;</span>
                    <h1>MEDICARE</h1>
                    <h3 class="fill">Fill-up Form for Patient</h3>
                    <!-- // [ /// ADD FORM /// ] -->
                    <form id="patientForm" action="addPatientRecord.php" method="post" onsubmit="return handleFormSubmit(event)">
                        <div class="row">
                            <div class="form-group">
                                <label for="first_name">First Name:</label>
                                <input type="text" id="first_name" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name:</label>
                                <input type="text" id="last_name" name="lastName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" id="address" name="address" required>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="age">Age:</label>
                                <input type="number" id="age" name="age" required>
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender:</label>
                                <select id="gender" name="gender" required>
                                    <option value="" disabled selected></option> 
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="birthday">Birthday:</label>
                                <input type="date" id="birthday" name="birthday" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="symptoms">Symptoms:</label>
                            <textarea id="symptoms" name="symptoms" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="medical_history">Medical History:</label>
                            <textarea id="medical_history" name="medicalHistory" rows="3"></textarea>
                        </div>

                        <hr>

                        <div class="test-text">Physical Test</div>
                        <br>
                        <div class="row">
                            <div class="form-group">
                                <label for="height">Height (cm):</label>
                                <input type="number" id="height" name="height" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="weight">Weight (kg):</label>
                                <input type="number" id="weight" name="weight" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="temperature">Temperature (°C):</label>
                                <input type="number" id="temperature" name="temperature" step="0.01">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="heart_rate">Heart Rate:</label>
                                <input type="number" id="heart_rate" name="heartRate">
                            </div>
                            <div class="form-group">
                                <label for="blood_pressure">Blood Pressure:</label>
                                <input type="text" id="blood_pressure" name="bloodPressure">
                            </div>
                        </div>

                        <hr>

                        <div class="test-text">Diagnostic Test</div>
                        <br>
                        <div class="radio-group">
                            <div class="top-group">
                                <label for="diagnosticTest"> <input type="radio" name="diagnosticTest" value="Radiology"> Radiology </label>
                                <label for="diagnosticTest"> <input type="radio" name="diagnosticTest" value="Laboratory"> Laboratory </label>
                                <label for="diagnosticTest"> <input type="radio" name="diagnosticTest" value="Cardiovascular"> Cardiovascular </label>
                            </div>
                            <div class="bottom-group">
                                <label for="diagnosticTest"> <input type="radio" name="diagnosticTest" value="Neurology"> Neurology </label>
                                <label for="diagnosticTest"> <input type="radio" name="diagnosticTest" value="Not Applicable"> Not Applicable </label>
                            </div>
                        </div>
                            <button type="submit" class="btn-submit">ADD PATIENT</button>
                    </form>
                </div>
            </div>
            <!-- // [ /// EDIT PATIENT RECORD DATA FORM /// ] -->
            <div id="editPatientModal" class="modal">
                <div class="modal-content">
                    <span class="close-disp" onclick="document.getElementById('editPatientModal').style.display='none'">&times;</span>
                    <h1>MEDICARE</h1>
                    <h3 class="fill">Edit Patient Form</h3>
                    <form id="editPatientForm" action="updPatientRecord.php" method="post" onsubmit="return handleEditFormSubmit(event)">
                        <input type="hidden" id="edit_patientID" name="patientID" required>
                        <div class="row">
                            <div class="form-group">
                                <label for="edit_first_name">First Name:</label>
                                <input type="text" id="edit_first_name" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_last_name">Last Name:</label>
                                <input type="text" id="edit_last_name" name="lastName" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_address">Address:</label>
                            <input type="text" id="edit_address" name="address" required>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="edit_age">Age:</label>
                                <input type="number" id="edit_age" name="age" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_gender">Gender:</label>
                                <select id="edit_gender" name="gender" required>
                                    <option value="" disabled selected></option> 
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="edit_birthday">Birthday:</label>
                                <input type="date" id="edit_birthday" name="birthday" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_symptoms">Symptoms:</label>
                            <textarea id="edit_symptoms" name="symptoms" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_medical_history">Medical History:</label>
                            <textarea id="edit_medical_history" name="medicalHistory" rows="3"></textarea>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="edit_height">Height (cm):</label>
                                <input type="number" id="edit_height" name="height" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_weight">Weight (kg):</label>
                                <input type="number" id="edit_weight" name="weight" step="0.01" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_temperature">Temperature (°C):</label>
                                <input type="number" id="edit_temperature" name="temperature" step="0.01">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="edit_heart_rate">Heart Rate:</label>
                                <input type="number" id="edit_heart_rate" name="heartRate">
                            </div>
                            <div class="form-group">
                                <label for="edit_blood_pressure">Blood Pressure:</label>
                                <input type="text" id="edit_blood_pressure" name="bloodPressure">
                            </div>
                        </div>
                        <button type="submit" class="btn-submit">SAVE</button>
                    </form>
                </div>
            </div>
            <!-- // [ /// DISPLAY FULL PATIENT RECORD DATA /// ] -->
            <div id="displayPatientModal" class="modal-disp">
                <div class="modal-contentDisp">
                    <button class="close" onclick="document.getElementById('displayPatientModal').style.display='none'">
                        <i class="fas fa-times"></i> <!-- Font Awesome 'x' icon -->
                    </button>
                    <h1>MEDICARE DOH FILE</h1>
                    <hr>
                    <h3 class="fill">Patient Information</h3>
                    <div id="patientInfo">
                        <div class="displayRow">
                            <div class="displayCol">
                                <p><strong>Patient ID:</strong> <span id="patientID"></span></p>
                                <p><strong>Full Name:</strong> <span id="fullName"></span></p>
                            </div>
                            <div class="displayCol">
                                <p><strong>Address:</strong> <span id="address"></span></p>
                            </div>
                        </div>
                        <div class="displayRow">
                            <div class="displayCol">
                                <p><strong>Age:</strong> <span id="age"></span></p>
                                <p><strong>Birthday:</strong> <span id="birthday"></span></p>
                            </div>
                            <div class="displayCol">
                                <p><strong>Gender:</strong> <span id="gender"></span></p>
                            </div>
                        </div>
                        <div class="displayRow">
                            <div class="displayCol">
                                <p><strong>Height:</strong> <span id="height"></span> cm</p>
                                <p><strong>Weight:</strong> <span id="weight"></span> kg</p>
                            </div>
                            <div class="displayCol">
                                <p><strong>Symptoms:</strong> <span id="symptoms"></span></p>
                                <p><strong>Medical History:</strong> <span id="medicalHistory"></span></p>
                            </div>
                        </div>
                        <div class="displayRow">
                            <div class="displayCol">
                                <p><strong>Temperature:</strong> <span id="temperature"></span> °C</p>
                            </div>
                            <div class="displayCol">
                                <p><strong>Heart Rate:</strong> <span id="heartRate"></span> bpm</p>
                                <p><strong>Blood Pressure:</strong> <span id="bloodPressure"></span></p>
                            </div>
                        </div>
                        <div class="displayRow">
                            <p><strong>Diagnostic Test:</strong> <span id="diagnosticTest"></span></p>
                        </div>
                    </div>
                    <hr>
                    <footer>
                        <p><strong>Cabuyao Medicare Hospitals</strong></p>
                    </footer>
                </div>
            </div>

                <!-- [ /// SECOND HALF OF Record.php scripts /// ] -->
                <script>
                // [ /// FUNCTION HANDLE DISPLAY TO LOAD AFTER UPDATING AND DELETING /// ] 
                    function fetchPatientRecords() {
                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', 'viewPatientRecord.php', true);
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                const patients = JSON.parse(xhr.responseText);
                                const tableBody = document.querySelector('#patientsTable tbody');
                                tableBody.innerHTML = '';

                                patients.forEach(patient => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
                                        <td>${patient.patientID}</td>
                                        <td>${patient.fullName}</td>
                                        <td>${patient.age}</td>
                                        <td>${patient.birthday}</td>
                                        <td>${patient.symptoms}</td>
                                        <td>
                                            <button class="btn btn-view" onclick="viewPatient(${patient.patientID})">View</button>
                                            <button class="btn btn-edit" onclick="editPatient(${patient.patientID})">Edit</button>
                                            <button class="btn btn-delete" onclick="deletePatient(${patient.patientID})">Delete</button>
                                        </td>
                                    `;
                                    tableBody.appendChild(row);
                                });
                            } else {
                                console.error('Failed to fetch data: ' + xhr.status);
                            }
                        };
                        xhr.send();
                    }
                    window.onload = fetchPatientRecords;
                </script>

                <script>
                    var modal = document.getElementById("patientModal");
                    var openModalBtn = document.getElementById("openModalBtn");
                    var openModalIcon = document.getElementById("openModalIcon");
                    var closeBtn = document.getElementsByClassName("close")[0];

                    function openModal() {
                        modal.style.display = "block";
                    }
                    function closeModal() {
                        modal.style.display = "none";
                    }
                    openModalBtn.onclick = openModal;
                    openModalIcon.onclick = openModal;
                    closeBtn.onclick = closeModal;

                    window.onclick = function(event) {
                        if (event.target === modal) {
                            closeModal();
                        }
                    };
                    document.getElementById("openModalBtn").addEventListener("click", function() {
                        document.getElementById("patientModal").style.display = "block";
                    });
                    window.onclick = function(event) {
                        var modal = document.getElementById("patientModal");
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                </script>

                <script>
                    // [ /// HANDLE FORM's POPUP DISPLAY /// ] 
                    function showPopup(message, type) {
                        var modal = document.getElementById("popupModal");
                        var messageBox = document.getElementById("popupMessage");

                        messageBox.innerHTML = message;
                        modal.style.display = "block";
                        modal.className = "popup-modal " + type;

                        setTimeout(function() {
                            modal.style.display = "none";
                        }, 2000); 
                    }
                </script>

                <script>
                        function fadeIn(element, duration) {
                            element.style.opacity = 0;
                            element.style.display = 'block';
                            let last = +new Date();
                            const fade = function() {
                                element.style.opacity = +element.style.opacity + (new Date() - last) / duration;
                                last = +new Date();
                                if (+element.style.opacity < 1) {
                                    requestAnimationFrame(fade);
                                }
                            };
                            fade();
                        }

                         function confirmLogout() {
                            if (confirm("Are you sure you want to logout?")) {
                                window.location.href = "?action=logout&confirm=yes";
                                alert('Successful Logout!');
                            }
                        }
                        window.confirmLogout = confirmLogout;
                </script>
        </body>
</html>
