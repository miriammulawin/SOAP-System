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
    <title>Appointment</title>
    <style>
        body {
            background-color: #97CADB;
            margin: 0;
            padding: 0;
            font-family: "M PLUS Rounded 1c", serif;
            overflow: hidden;
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
            width: 220px; 
            height: 100vh; 
            background-color: #ffffff;
            padding-top: 60px; 
            color: #333333;
            font-size: 18px;
            padding-left: 10px;
            margin-left: 1vh;
            margin-top: 60px; 
            padding-left: 10px;
        }

        .holder {
            background-color: #E3E8ED;
            height: 65%;
            width: 85%;
            padding: 10px;
            margin-top: 2vh;
            margin-left: 0.2vh;
         
        }

        .profile {
            background-color: #cad0d5;
            height: 12%;
            width: 85%; 
            padding: 10px;
            padding-top: 10px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            margin-top: -6.5vh;
            margin-left: 0.2vh;
        }

        .profile i {
            font-size: 50px;
        }

        .profile .fa-pen-to-square {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 20px;
            color: #02457A;
            cursor: pointer;
        }

        .profile p {
            margin-left: 10px;
            font-size: 13px;
        }

        aside ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        aside ul a {
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
            margin-left: 246px; 
            background-color: white;
            width: 167vh;
            height: 90vh;
            padding: 20px;
        }
  
        .panel {
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

        .panel .left-section  {
            background: #C2CDD9;
            padding: 15px;
            color: #022E5F;
            font-size: 25px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel .left-section button:hover {
            background-color: #45a049;
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
            font-size: 25px;
            margin-left: -5px;
            margin-right: 5px;
            cursor: pointer;
            color: #02457A;
        }

        .panel .right-section i:hover {
            color: white;
        }

        .appointment-container {
            background: #F1F4FB;
            padding: 15px;
            border: 1px solid #000;
            border-radius: 5px;
            margin-top: 15px;
        }
        .test-options {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            width: 50%;
            padding: 10px;
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
            margin-right: 10px
        }

        .test-options button:hover {
            background-color: #02457A;
            color:white;
        }

        .action-icons {
            margin-left: 120%; /* Pushes icons to the right */
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: flex-end;
            width: 100%;
            color: #02457A;

        }

        .action-icons i {
            cursor: pointer;
            font-size: 18px;
        }

        .back{
            background-color: #E3E8ED;
            padding: 10px;
            margin-top: 10px;
            height: 52vh
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
            gap: 10px; /* Space between buttons */
        }

        .appointment-card button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .appointment-card .done-btn {
            background: #001B48; /* Green */
            color: white;
        }

        .appointment-card .done-btn:hover {
            background:rgb(65, 86, 121);
        }

        .appointment-card .cancel-btn {
            background: #dc3545; /* Red */
            color: white;
        }

        .appointment-card .cancel-btn:hover {
            background: #c82333;
        }

        .content{
            background-size: cover;
            background-image: url(../SOAP/Images/Login-BG.jpg); // remove it for assestment/ records/ appointment
            width: 161vh;
            height: 80vh;
            margin-left: -1vh;
            margin-top:5px;
        }

    </style>
</head>
<body>
    <header>
        <h2>MEDICARE</h2>
    </header>

    <!-- Sidebar -->
    <aside>
        <div class="profile">
            <i class="fa-solid fa-circle-user"></i>
            <p>admin101@gmail.com</p>
            <i class="fa-regular fa-pen-to-square"></i>
        </div>
        <div class="holder">
            <ul>
                <li><a href="#"><i class="material-icons-outlined">dashboard</i> Dashboard</a></li>
                <li><a href="#"><i class="material-icons-outlined">description</i> Record</a></li>
                <li><a href="#"><i class="material-icons-outlined">assessment</i> Assessment</a></li>
                <li><a href="#"><i class="material-icons-outlined">calendar_today</i> Appointment</a></li>
                <li><a href="#"><i class="material-icons-outlined">settings</i> Settings</a></li>
                <li><a href="#"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </aside>

    <main>
        <!-- Panel Section -->
        <div class="panel">
            <div class="left-section">
            <span><i class="fas fa-calendar-plus"></i> &nbsp;Appointment</span>
            </div>
            <div class="right-section">
                <i class="fa-regular fa-bell"></i>
                <input type="text" placeholder="Search...">
                <i class="fas fa-search"></i>
            </div>
        </div>

        <div class="appointment-container">
        <div class="test-options">
            <button>Upcoming</button>
            <button>Finished</button>
            <button>Canceled</button>
            <div class="action-icons">
                <i class="fas fa-circle-plus"></i>
                <i class="fas fa-edit"></i>
                <i class="fas fa-trash"></i>
                <i class="fas fa-th grid-icon"></i>
            </div>
        </div>
        </div>

        <div class="back">
        <div class="mt-3">
        <div class="appointment-card">
        <span>John Doe - Checkup</span>
            <div class="button-group">
                <button class="done-btn">Done</button>
                <button class="cancel-btn">Cancel</button>
            </div>
        </div>   
        
        <div class="appointment-card">
        <span>John Doe - Checkup</span>
            <div class="button-group">
                <button class="done-btn">Done</button>
                <button class="cancel-btn">Cancel</button>
            </div>
        </div>   
        </div>
        </div>
    </div>
    </main>
</body>
</html>
