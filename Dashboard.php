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
                    margin-top: 60px; 
                    margin-left: 240px; 
                    background-color: white;
                    width: 160vh;
                    height: 100vh;
                    padding: 20px;
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

                .dashboard-content {
                    background-size: cover;
                    margin-left: -1vh;
                    margin-top: 5px;
                }

                .bg {
                    width: 161vh;
                    height: 80vh;
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
                input, textarea {
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
                .diagnostic-test {
                    font-weight: bold;
                    margin-top: 15px;
                    text-align: center;
                    font-size: 23px;
                }
                .checkbox-group {
                    display: flex;
                    gap: 15px;
                    flex-wrap: wrap;
                    justify-content: center;
                    margin-top: 5px;
                    font-size: 16px;
                    margin-bottom: 15px;
                }
                .checkbox-group label {
                    display: flex;
                    align-items: center;
                    gap: 5px;
                    font-size: 18px;
                    text-align: center;
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
                    <p>admin101@gmail.com</p>
                    <i class="fa-regular fa-pen-to-square"></i>
                </div>
                
                <ul>
                    <li><a href="Dashboard.php"><i class="material-icons-outlined">dashboard</i> Dashboard</a></li>
                    <li><a href="Record.php"><i class="material-icons-outlined">description</i> Record</a></li>
                    <li><a href="Assessment.php"><i class="material-icons-outlined">assessment</i> Assessment</a></li>
                    <li><a href="Appointment.php"><i class="material-icons-outlined">calendar_today</i> Appointment</a></li>
                    <li><a href="setting.php"><i class="material-icons-outlined">settings</i> Settings</a></li>
                    <li><a href="Login.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
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
                        <img class="bg" src="../SOAP-System/Images/Login-BG.jpg" alt="">
                        <div class="test-table" id="testTable"></div>
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
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="birthday">Birthday (Year/Month/Day):</label>
                            <input type="text" id="birthday" name="birthday" placeholder="YYYY/MM/DD" required pattern="\d{4}/\d{2}/\d{2}">
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

                    <div class="diagnostic-test">Diagnostic Test</div>
                    <div class="checkbox-group">
                        <label><input type="checkbox" name="diagnosticTest[]" value="Radiology"> Radiology</label>
                        <label><input type="checkbox" name="diagnosticTest[]" value="Cardiology"> Cardiology</label>
                        <label><input type="checkbox" name="diagnosticTest[]" value="Not Applicable"> Not Applicable</label>
                        <label><input type="checkbox" name="diagnosticTest[]" value="Laboratory"> Laboratory</label>
                        <label><input type="checkbox" name="diagnosticTest[]" value="Neurological"> Neurological</label>
                    </div>

                    <button type="submit" class="btn-submit">ADD PATIENT</button>
                </form>
            </div>

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

        </body>
</html>
