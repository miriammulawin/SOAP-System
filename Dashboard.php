<?php 
    session_start();

    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    function connectDB() {
        $servername = "localhost";
        $username = "root";
        $password = "ravanera1124";
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
                    margin-top: 48px; 
                    margin-left: 240px; 
                    background-color: white;
                    width: 160vh;
                    height: 100vh;
                    padding: 20px;
                }

                .bg {
                            width: 161vh;
                            height: 80vh;
                        }
                .panel {
                    border-radius:10px;
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
                    margin-top: 20px;
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

                .dashboard-content {
                    background-size: cover;
                    margin-left: -1vh;
                    margin-top: 5px;
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


                /* Table container styles */
                #testTable {
                    width: 100%;
                    margin: 20px 0;
                    border-collapse: collapse;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                    font-family: Arial, sans-serif;
                }

                /* Table header styles */
                #testTable table {
                    width: 100%;
                    border: 1px solid #ddd;
                    text-align: left;
                }

                #testTable th {
                    background-color: #018ABE;
                    color: white;
                    padding: 10px;
                    font-size: 16px;
                    text-align: center;
                }

                /* Table cell styles */
                #testTable td {
                    padding: 10px;
                    border-bottom: 1px solid #ddd;
                    text-align: center;
                }

                /* Hover effect on rows */
                #testTable tr:hover {
                    background-color: #f2f2f2;
                }

                /* Alternate row color */
                #testTable tr:nth-child(even) {
                    background-color: #f9f9f9;
                }

                /* Styling for the table container */
                .table-container {
                    margin: 20px auto;
                    max-width: 1000px;
                    overflow-x: auto;
                }

                /* Responsive design */
                @media (max-width: 768px) {
                    #testTable {
                        font-size: 14px;
                    }

                    #testTable th, #testTable td {
                        padding: 8px;
                    }
                }
        </style>
    </head>

    <body>
        <?php 
        require_once 'addPatientRecord.php';

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            addPatientRecord($_POST);
        }
        ?>

        <div id="popupModal" class="popup-modal">
            <div class="popup-content" id="popupMessage"></div>
        </div>

        <!-- Dashboard UI -->
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
            <div id="dashboard-panel" class="content-panel">
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
                
                <div class="test-options">
                    <button onclick="changeContent('Laboratory')">Laboratory</button>
                    <button onclick="changeContent('Radiology')">Radiology</button>
                    <button onclick="changeContent('Neurology')">Neurology</button>
                    <button onclick="changeContent('Cardiovascular')">Cardiovascular</button>
                </div>


                <div class="dashboard-content" id="dashboard">
                    <div class="test-table" id="testTable">
                    <img class="bg" id="noTableImage" src="../SOAP/Images/Login-BG.jpg" alt="No data available">
                    </div>
                </div>
            </div>
        </main>

            <!-- Modal Structure -->
        <div id="patientModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="document.getElementById('patientModal').style.display='none'">&times;</span>

                <h1>MEDICARE</h1>
                <h3 class="fill">Fill-up Form for Patient</h3>
                
                <form action="" method="post" onsubmit="closeModal()">
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
                                <option value="" disabled selected></option> <!-- No selection by default -->
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

                    <!-- Top group: Laboratory, Radiology, Cardiovascular -->
                    <div class="top-group">
                        <label for="diagnosticTest">
                            <input type="radio" name="diagnosticTest" value="Radiology"> Radiology
                        </label>

                        <label for="diagnosticTest">
                            <input type="radio" name="diagnosticTest" value="Laboratory"> Laboratory
                        </label>

                        <label for="diagnosticTest">
                            <input type="radio" name="diagnosticTest" value="Cardiovascular"> Cardiovascular
                        </label>
                    </div>

                    <!-- Bottom group: Neurology and Not Applicable -->
                    <div class="bottom-group">
                        <label for="diagnosticTest">
                            <input type="radio" name="diagnosticTest" value="Neurology"> Neurology
                        </label>

                        <label for="diagnosticTest">
                            <input type="radio" name="diagnosticTest" value="Not Applicable"> Not Applicable
                        </label>
                    </div>
                </div>

                    <button type="submit" class="btn-submit">ADD PATIENT</button>
                </form>
            </div>

        <!-- // Displaying Tables -->
            <script>
                    function changeContent(testType) { 
                        console.log("Fetching data for test type:", testType);

                        fetch(`getPatients.php?testType=${testType}`)
                            .then(response => {
                                console.log("Response status:", response.status); // Check the status code
                                if (!response.ok) {
                                    throw new Error('Network response was not ok');
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log("Data fetched:", data); // Log fetched data

                                if (data.error) {
                                    document.getElementById('testTable').innerHTML = data.error;
                                    return;
                                }

                                if (data.length === 0) {
                                    document.getElementById('testTable').innerHTML = 'No data available for this test type.';
                                    return;
                                }

                                // Create the table and populate it with the fetched data
                                let tableContent = `<table border="1">
                                    <tr>
                                        <th>Patient Name</th>
                                        <th>Age</th>
                                        <th>Test Type</th>
                                        <th>Result</th>
                                        <th>Date Conducted</th>
                                    </tr>`;
                                
                                data.forEach(patient => {
                                    tableContent += `<tr>
                                        <td>${patient.firstName} ${patient.lastName}</td>
                                        <td>${patient.age}</td>
                                        <td>${patient.testType}</td>
                                        <td>${patient.result}</td>
                                        <td>${patient.dateConducted}</td>
                                    </tr>`;
                                });
                                tableContent += `</table>`;
                                document.getElementById('testTable').innerHTML = tableContent;
                            })
                            .catch(error => {
                                console.error("Error fetching data:", error);
                                document.getElementById('testTable').innerHTML = 'Error fetching data.';
                            });
                    }



                        </script>

                        <script>
                    document.getElementById("openModalBtn").addEventListener("click", function() {
                        document.getElementById("patientModal").style.display = "block";
                    });

                    function closeModal() {
                        document.getElementById("patientModal").style.display = "none";
                    }

                    window.onclick = function(event) {
                        var modal = document.getElementById("patientModal");
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                    </script>

                    <script>
                    function showPopup(message, type) {
                        var modal = document.getElementById("popupModal");
                        var messageBox = document.getElementById("popupMessage");

                        messageBox.innerHTML = message;
                        modal.style.display = "block";
                        modal.className = "popup-modal " + type;

                        setTimeout(function() {
                            modal.style.display = "none";
                        }, 2000); // Hide modal after 2 seconds
                    }
                    </script>

                    <script>
                            // Function to fetch and update the patient records dynamically
                            function loadPatientRecords() {
                                var xhr = new XMLHttpRequest();
                                xhr.open("GET", "fetch_patients.php", true); // Assuming the PHP file is 'fetch_patients.php'
                                xhr.onreadystatechange = function() {
                                    if (xhr.readyState == 4 && xhr.status == 200) {
                                        document.getElementById('record-content').innerHTML = xhr.responseText;
                                    }
                                };
                                xhr.send();
                            }

                            // Load the patient records every 5 seconds (adjust as needed)
                            setInterval(loadPatientRecords, 5000);

                            // Initially load the records when the page is loaded
                            window.onload = function() {
                                loadPatientRecords();
                            };
                        </script>

                    <script>
                        document.querySelector(".panel .right-section input[type='text']").addEventListener("input", function() {
                        let searchTerm = this.value.toLowerCase();
                        let rows = document.querySelectorAll("#testTable table tr");

                        rows.forEach(row => {
                            let cells = row.querySelectorAll("td");
                            let matchFound = false;

                            cells.forEach(cell => {
                                if (cell.textContent.toLowerCase().includes(searchTerm)) {
                                    matchFound = true;
                                }
                            });

                            if (matchFound) {
                                row.style.display = "";
                            } else {
                                row.style.display = "none";
                            }
                        });
                    });
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
