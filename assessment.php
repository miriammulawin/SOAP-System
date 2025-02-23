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
            <p>admin101@gmail.com</p>
            <i class="fa-regular fa-pen-to-square"></i>
        </div>
        <ul>
            <li><a href="Dashboard.php"><i class="material-icons-outlined">dashboard</i> Dashboard</a></li>
            <li><a href="Record.php"><i class="material-icons-outlined">description</i> Record</a></li>
            <li><a href="Assessment.php"><i class="material-icons-outlined">assessment</i> Assessment</a></li>
            <li><a href="Appointment.php"><i class="material-icons-outlined">calendar_today</i> Appointment</a></li>
            <li><a href="Settings.php"><i class="material-icons-outlined">settings</i> Settings</a></li>
            <li><a href="Login.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>
    <main>
        <div class="panel">
            <div class="left-section">
                <span class="assessment-text"><i class="material-icons-outlined">assessment</i> &nbsp;Assessment</span>
            </div>
            <div class="right-section">
                <input type="text" id="search" placeholder="Search...">
                <i class="fas fa-search" onclick="searchAssessment()"></i>
            </div>
        </div>

        <!-- Assessment Form -->
        <div class="assessment-content">
            <h3>New Assessment</h3>
            <form id="assessmentForm">
                <div class="input-group">
                    <input type="number" id="appointmentID" placeholder="Appointment ID" required>
                </div>
                <div class="input-group">
                    <textarea id="diagnosis" placeholder="Diagnosis" required></textarea>
                </div>
                <div class="input-group">
                    <textarea id="prescription" placeholder="Prescription" required></textarea>
                </div>
                <div class="buttons-group">
                    <button type="submit" class="save-btn">Save</button>
                    <button type="reset" class="cancel-btn">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Assessment Table -->
        <div class="assessment-content">
            <h3>Assessment Records</h3>
            <table border="1" id="assessmentTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Appointment ID</th>
                        <th>Diagnosis</th>
                        <th>Prescription</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </main>

    <script>
        const API_URL = "http://localhost/Gapas/backEnd/assessment.php";

        // Fetch and display assessments
        function fetchAssessments() {
            fetch(API_URL)
                .then(response => response.json())
                .then(data => {
                    let tableBody = document.querySelector("#assessmentTable tbody");
                    tableBody.innerHTML = "";
                    data.forEach(assessment => {
                        tableBody.innerHTML += `
                            <tr>
                                <td>${assessment.assessmentID}</td>
                                <td>${assessment.appointmentID}</td>
                                <td>${assessment.diagnosis}</td>
                                <td>${assessment.prescription}</td>
                                <td>
                                    <button onclick="editAssessment(${assessment.assessmentID})">Edit</button>
                                    <button onclick="deleteAssessment(${assessment.assessmentID})">Delete</button>
                                </td>
                            </tr>`;
                    });
                })
                .catch(error => console.error("Error fetching assessments:", error));
        }

        // Submit form to add new assessment
        document.getElementById("assessmentForm").addEventListener("submit", function(event) {
            event.preventDefault();
            
            let formData = {
                appointmentID: document.getElementById("appointmentID").value,
                diagnosis: document.getElementById("diagnosis").value,
                prescription: document.getElementById("prescription").value
            };

            fetch(API_URL, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchAssessments();
                document.getElementById("assessmentForm").reset();
            })
            .catch(error => console.error("Error adding assessment:", error));
        });

        // Edit an assessment (prefill form)
        function editAssessment(assessmentID) {
            fetch(`${API_URL}?assessmentID=${assessmentID}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("appointmentID").value = data.appointmentID;
                    document.getElementById("diagnosis").value = data.diagnosis;
                    document.getElementById("prescription").value = data.prescription;

                    let saveButton = document.querySelector("#assessmentForm button");
                    saveButton.textContent = "Update";
                    saveButton.onclick = function () { updateAssessment(assessmentID); };
                })
                .catch(error => console.error("Error fetching assessment:", error));
        }

        // Update assessment
        function updateAssessment(assessmentID) {
            let formData = {
                assessmentID: assessmentID,
                diagnosis: document.getElementById("diagnosis").value,
                prescription: document.getElementById("prescription").value
            };

            fetch(API_URL, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchAssessments();
                document.querySelector("#assessmentForm button").textContent = "Save";
                document.getElementById("assessmentForm").reset();
            })
            .catch(error => console.error("Error updating assessment:", error));
        }

        // Delete assessment
        function deleteAssessment(assessmentID) {
            fetch(API_URL, {
                method: "DELETE",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ assessmentID: assessmentID })
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                fetchAssessments();
            })
            .catch(error => console.error("Error deleting assessment:", error));
        }

        // Load assessments on page load
        document.addEventListener("DOMContentLoaded", fetchAssessments);
    </script>
</body>
</html>
