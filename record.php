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

        <div class="record-header">
            <div class="header-title">Record</div>
            <div class="action-icons">
                <i class="fas fa-circle-plus"></i>
                <i class="fas fa-edit"></i>
                <i class="fas fa-trash"></i>
                <i class="fas fa-th grid-icon"></i>
            </div>
        </div>

        <div class="record-content"></div>
    </main>
</body>
</html>
