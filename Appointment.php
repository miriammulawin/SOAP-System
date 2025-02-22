
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
            height: 100vh;
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
        .bg {
            width: 161vh;
            height: 80vh;
        }
        .appointment-container {
            background: #F1F4FB;
            padding: 15px;
            border: 1px solid #000;
            border-radius: 5px;
            margin-top: 15px;
        }
        .appointment-text {
            font-size: 18px;
            font-weight: bold;
            color: rgb(4, 43, 69);
            margin-right: 10px;
        }
        .action-icons {
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
            color: #02457A;
        }
        .action-icons i {
            font-size: 18px;
            cursor: pointer;
        }
        .action-icons i:hover {
            color: #1D70A0;
        }
        .back {
            background-color: #E3E8ED;
            padding: 10px;
            margin-top: 10px;
            height: 52vh;
        }
        .appointment-card {
            background: #D5DEEF;
            padding: 15px;
            margin: 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .appointment-card .button-group {
            display: flex;
            gap: 10px;
        }
        .appointment-card button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .appointment-card .done-btn {
            background: #001B48;
            color: white;
        }
        .appointment-card .done-btn:hover {
            background: rgb(65, 86, 121);
        }
        .appointment-card .cancel-btn {
            background: #dc3545;
            color: white;
        }
        .appointment-card .cancel-btn:hover {
            background: #c82333;
        }
        .appointment-text button {
            padding: 10px 20px;
            background-color: #02457A;
            color: white;
            border: 2px solid #02457A;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: auto;
            margin-right: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .appointment-text button:hover {
            background-color: #1D70A0;
            transform: scale(1.05);
        }
        .appointment-text button:focus {
            outline: none;
            border-color: #1D70A0;
        }
        .appointment-text {
            font-size: 18px;
            font-weight: bold;
            color: rgb(4, 43, 69);
            margin-right: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }
        .appointment-text i {
            font-size: 20px;
            color: #02457A;
            cursor: pointer;
            margin-left: 10px;
            transition: color 0.3s ease;
        }
        .appointment-text i:hover {
            color: #1D70A0;
        }
        button.upcoming {
            background-color: #02457A;
            color: white;
            border: 2px solid #02457A;
        }
        button.upcoming:hover {
            background-color: #1D70A0;
        }
        button.finished {
            background-color: #28a745;
            color: white;
            border: 2px solid #28a745;
        }
        button.finished:hover {
            background-color: #218838;
        }
        button.canceled {
            background-color: #dc3545;
            color: white;
            border: 2px solid #dc3545;
        }
        button.canceled:hover {
            background-color: #c82333;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);

        }

        .modal-content {
            background: #97CADB;
            margin: 10% auto;
            padding: 25px;
            border-radius: 10px;
            width: 500px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            position: relative;

        }


        .close-btn, .close-date-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            cursor: pointer;

        }


        .modal-title {
            color: #001B48;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
            letter-spacing: 2px;
            margin-left: 200px;

        }

        .set-title {
            font-size: 14px;
            color: #333;
            margin-top: 40px;

        }


        .search-container {
        display: flex;
        align-items: center;
        background: white;
        padding: 8px;
        border-radius: 5px;
        margin: 15px 0;
        border: 1px solid #ccc;

        }

        .search-container input {
            border: none;
            color:rgb(139, 143, 146);
            flex: 1;
            padding: 10px;
            font-size: 14px;
            outline: none;

        }

        .search-container i {
            color: gray;
            padding: 5px;
            font-size: 20px;
            cursor: pointer;
            color: #97CADB;
            transition: color 0.3s ease-in-out, transform 0.2s ease-in-out;

        }

        .search-container i {
            color:rgb(9, 56, 107); /* Darker blue on hover */
            transform: scale(1.2); /* Slightly enlarges the icon */
        
        }

        #searchResults {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-top: 10px;
        text-align: left;

        }

    /* Styling for each patient card */
        .patient-card {
            background-color: white;
            border-radius: 8px;
            padding: 15px;
            width: 500px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: background-color 0.3s;

        }

        .patient-card:hover {
            background-color: #f0f8ff; 
            /* Light blue when hovering */
        }

        .patient-card.selected {
            background-color: #00aaff; /* Blue when selected */
            color: white;

        }




        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
            display: none;

        }

        
        .add-patient-btn, .set-date-btn {
            background: #092e50;
            color: white;
            padding: 8px;
            font-size: 10px;
            border: none;
            border-radius: 5px;
            width: 100px;
            cursor: pointer;
            margin-top: 15px;

            
        }

        .date-container {
            display: flex;
            align-items: center; 
            background: white;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 95%;
            position: relative; 

        }


        .date-container input {
            color:rgb(139, 143, 146);
            border: none;
            width: 100%;
            font-size: 20px;
            padding: 10px;
            outline: none;
            padding-right: 10px; 

        }

        .date-container i {
            position: absolute;
            right: 10px; /* Keeps the icon inside the field */
            color: gray;
            cursor: pointer;
        }

        
        .add-appointment-icon {
            font-size: 30px;
            cursor: pointer;
            color: #092e50;
            
         }

         .appointment-content {
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
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
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
        <div id="appointment-panel" class="content-panel">
            <div class="panel">
                <div class="left-section">
                    <span class="appointment-text"><i class="fas fa-calendar-plus"></i> &nbsp;Appointment</span>
                </div>
                <div class="right-section">
                    <input type="text" placeholder="Search...">
                    <i class="fas fa-search"></i>
                    <i class="fas fa-bell"></i>
                </div>
            </div>

            <div class="appointment-container">
                <div class="appointment-text">
                    <button class="upcoming">Upcoming</button>
                    <button class="finished">Finished</button>
                    <button class="canceled">Canceled</button>

                    <div class="action-icons">
                    <i onclick="openModal()" class="fas fa-circle-plus"></i>
                        <i class="fas fa-edit"></i>
                        <i class="fas fa-trash"></i>
                        <i class="fas fa-th grid-icon"></i>
                    </div>

                </div>
        
            </div>
            <div class="appointment-content">
            <h4>Appointment</h1>
            <?php include 'appointmentRecords.php'; ?>
            </div>
           
 <!-- Modal Structure -->
<div id="searchModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Search Patients</h2>
        <input type="text" id="searchInput" onkeyup="searchPatients()" placeholder="Search for patients...">
        <table id="patientsTable">
            <thead>
                <tr>
                    <th>Patient ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                </tr>
            </thead>
            <tbody>
                <!-- Patient records will be inserted here -->
            </tbody>
        </table>

        <!-- Selected Patient Display -->
        <h3>Selected Patient: <span id="selectedPatient">None</span></h3>

        <!-- Appointment Date Section -->
        <div id="appointmentDateSection" style="display:none;">
            <h3>Set Appointment Date</h3>
            <input type="date" id="appointmentDate">
            <button id="addAppointmentBtn" onclick="addAppointment()" disabled>Add Appointment</button>
        </div>
    </div>
</div>


<script>
// Open Modal and Fetch Patients
function openModal() {
    document.getElementById("searchModal").style.display = "block";
    fetchPatients();
}

// Close Modal
function closeModal() {
    document.getElementById("searchModal").style.display = "none";
}

// Fetch Patients from the Database
function fetchPatients() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetchPatients.php", true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            window.patients = JSON.parse(xhr.responseText);  // Store patients globally
            displayPatients(window.patients);  // Display patients in the table
        }
    };
    xhr.send();
}

// Display Patients in Table (Clickable Rows)
function displayPatients(patients) {
    let tableBody = document.querySelector("#patientsTable tbody");
    tableBody.innerHTML = ''; // Clear previous data

    patients.forEach(patient => {
        let row = document.createElement("tr");
        row.innerHTML = `
            <td>${patient.patientID}</td>
            <td>${patient.firstName}</td>
            <td>${patient.lastName}</td>
            <td>${patient.age}</td>
            <td>${patient.gender}</td>
        `;

        // Make row clickable
        row.onclick = function() {
            selectPatient(patient, row);
        };

        tableBody.appendChild(row);
    });
}

// Function to Handle Patient Selection
function selectPatient(patient, row) {
    console.log("Selected Patient:", patient);

    // Store Selected Patient ID
    window.selectedPatientID = patient.patientID;

    // Show Selected Patient's Name
    document.getElementById("selectedPatient").innerText = `${patient.firstName} ${patient.lastName}`;

    // Highlight Selected Row (Reset All First)
    document.querySelectorAll("#patientsTable tbody tr").forEach(tr => {
        tr.style.backgroundColor = ""; // Reset
        tr.style.color = "";
    });
    row.style.backgroundColor = "#4CAF50"; // Green Highlight
    row.style.color = "white";

    // Enable the "Add Appointment" Button
    document.getElementById("appointmentDateSection").style.display = "block";
    document.getElementById("addAppointmentBtn").disabled = false;
}

// Function to Add Appointment
function addAppointment() {
    const appointmentDate = document.getElementById("appointmentDate").value;

    // Check if a Patient is Selected
    if (!window.selectedPatientID) {
        alert("Please select a patient first!");
        return;
    }

    // Check if an Appointment Date is Selected
    if (!appointmentDate) {
        alert("Please select an appointment date!");
        return;
    }

    // Send Appointment Data to Server
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "addAppointment.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (xhr.status === 200) {
            alert("Appointment added successfully!");
            closeModal(); // Close Modal After Adding
            fetchAppointments(); // Refresh Appointment List
        } else {
            alert("Error adding appointment.");
        }
    };
    xhr.send(`patientID=${window.selectedPatientID}&appointmentDate=${appointmentDate}`);
}

// Fetch and display appointments
function fetchAppointments() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "fetchAppointments.php", true);
    xhr.onload = function() {
        if (xhr.status == 200) {
            const appointments = JSON.parse(xhr.responseText);
            displayAppointments(appointments);
        }
    };
    xhr.send();
}

function displayAppointments(appointments) {
    let appointmentsContent = '';
    appointments.forEach(appointment => {
        appointmentsContent += `
            <tr>
                <td>${appointment.appointmentID}</td>
                <td>${appointment.patientID}</td>
                <td>${appointment.diagnosticTest}</td>
                <td>${appointment.diagnosticResult}</td>
                <td>${appointment.appointmentDate}</td>
                <td>${appointment.appointmentStatus}</td>
            </tr>
        `;
    });
    document.querySelector('#appointmentTable tbody').innerHTML = appointmentsContent;
}


// Search functionality
function searchPatients() {
    const input = document.getElementById("searchInput").value.toLowerCase();
    const filteredPatients = window.patients.filter(patient => {
        return (
            patient.firstName.toLowerCase().includes(input) ||
            patient.lastName.toLowerCase().includes(input) ||
            patient.patientID.toLowerCase().includes(input)
        );
    });
    displayPatients(filteredPatients);  // Display filtered results
}
</script>


</body>
</html>


