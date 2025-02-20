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
    <title>Assessment</title>
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
            height: 90vh; 
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
            margin-top: -5vh;
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
            margin-left: 249px; 
            margin-right: 1vh;
            background-color: white;
            width: 146.9vh;
            height: 90vh;
            padding: 20px;
            box-sizing: border-box;
        }
          
        .panel {
            position: relative;
            width: 100%;
            padding: 16px;
            background-color: #cad0d5;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-sizing: border-box;
            border-radius: 5px;
        }

        .panel .left-section  {
            background: #C2CDD9;
            padding: 20px;
            color: #022E5F;
            font-size: 25px;
            font-weight: bold;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 5px;
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

    .content {
        margin-top: 11px; 
        width: 922px;
        height: 587px;
        position: relative;
  }
 
.background {
    width: 143.1vh;
    height: 126%;
    left: 0;
    top: 0;
    display: flex;
            justify-content: space-between;
            align-items: center;
    position: absolute;
    background: linear-gradient(115deg, rgba(255, 255, 255, 0.78) 0%, rgba(151, 202, 219, 0.78) 45%, rgba(1, 138, 190, 0.78) 91%);
    box-sizing: border-box;
}

.input-box {
    position: absolute;
    width: 200px;
    height: 30px;
    background: white;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 7px;
    border: 1px solid #ccc;
    padding: 5px;
  }
  label {
    position: absolute;
    font-size: 16px;
    font-family: Rounded Mplus 1c;
    font-weight: 400;
  }

.patient-name-label { 
    left: 50px; 
    top: 30px; 
}
.patient-name-input { 
    left: 50px; 
    top: 55px; 
    width: 300px; 
}

.age-label { 
    left: 400px; 
    top: 30px; 
}
.age-input { 
    left: 400px; 
    top: 55px; 
    height: 31px;
    width: 98px; 
}

.physical-exam-label, 
.diagnostic-test-label {
    position: absolute;
    font-size: 30px;
    font-family: "M PLUS Rounded 1c", sans-serif;
    font-weight: 400;
    color: #018ABE;
}

.physical-exam-label {
    left: 550px;
    top: 30px;
}

.diagnostic-test-label {
    left: 1040px; 
    top: 30px;
    width: 160.78px;
    height: 31.33px;
    white-space: nowrap;;
    color: #3A5987;
}

.test-result-block {
    position: absolute;
    left: 1050px;
    top: 95px;
    font-size: 20px;
    font-family: "M PLUS Rounded 1c", sans-serif;
    font-weight: 500;
    color: #3A5987;
    display: flex;
    align-items: center; 
    white-space: nowrap;  
}

.test-result-icon {
    margin-right: 12px;
    margin-bottom: 2px; 
    order: -1;
    display: flex; 
    align-items: center; 
}

.test-result-icon svg {
    width: 35px;  
    height: 35px;  
    transition: fill 0.3s ease;
    vertical-align: middle; 
}

.vital-signs-block {
    position: absolute;
    left: 550px;
    top: 95px;
    font-size: 20px;  
    font-family: "M PLUS Rounded 1c", sans-serif;
    font-weight: 500;
    color: #018ABE;
    display: flex;
    align-items: center;
}

.vital-signs-icon {
    margin-right: 12px;  
    order: -1;
}

.vital-signs-icon svg {
    width: 30px;  
    height: 30px;  
    transition: fill 0.3s ease;
}



.gender-label { 
    left: 400px; 
    top: 100px; 
}
.gender-input { 
    left: 400px; 
    top: 128px; 
    height: 31px;
    width: 98px; 
}

.assessment-label { 
    left: 50px; 
    top: 100px; 
}
.assessment-input { 
    left: 50px; 
    top: 125px; 
    width: 300px; 
}

.symptoms-label { 
    left: 50px; 
    top: 180px; 
}
.symptoms-input { 
    left: 50px; 
    top: 205px; 
    height: 47px; 
    width: 443px; 
}

.history-label { 
    left: 50px; 
    top: 290px; 
}
.history-input { 
    left: 50px; 
    top: 315px; 
    height: 32px; 
    width: 443px; 
}
.medical-form {
 position: absolute;
 left: 790px;
 top: 300px;
 width: 500px;
 height: 168px;
 font-family: "M PLUS Rounded 1c", sans-serif;;
}


.input-container {
  position: relative;
  display: inline-block;
}

[class^="unit-"] {
  position: absolute;
  color: #018ABE;
  font-size: 12px;
  margin-left: 8px;
}

/* Height */
.height-label { 
    position: absolute;
    left: 50px; 
    top: 40px; 
}

.height-input { 
    position: absolute;
    left: 50px; 
    top: 65px; 
    width: 119.10px; 
}

.unit-cm {
    left: 150px;
    top: 73px;
}

/* Weight */
.weight-label { 
    position: absolute;
    left: 350px; 
    top: 40px; 
}

.weight-input { 
    position: absolute;
    left: 350px; 
    top: 65px; 
    width: 119.10px; 
}

.unit-kg {
    left: 450px;
    top: 73px;
}

/* Temperature */
.temperature-label { 
    position: absolute;
    left: 50px; 
    top: 120px; 
}

.temperature-input { 
    position: absolute;
    left: 50px; 
    top: 145px; 
    width: 119.10px; 
}

.unit-f {
    left: 150px;
    top: 153px;
}

/* Heart Rate */
.heart-rate-label { 
    position: absolute;
    left: 350px; 
    top: 120px; 
}

.heart-rate-input { 
    position: absolute;
    left: 350px; 
    top: 145px; 
    width: 119.10px; 
}

.unit-bpm {
    left: 445px;
    top: 153px;
}

/* Blood Pressure */
.blood-pressure-label { 
    position: absolute;
    left: 190px; 
    top: 200px; 
}

.blood-pressure-input { 
    position: absolute;
    left: 190px; 
    top: 225px; 
    width: 119.10px; 
}

.unit-mmhg {
    left: 270px;
    top: 233px;
}

.test-type-label { 
  position: absolute;
  left: 578px; 
  top: 40px; 
  white-space: nowrap;;
}

.test-type-input { 
  position: absolute;
  left: 578px; 
  top: 70px; 
  width: 119.10px; 
}

.status-label { 
  position: absolute;
  left: 578px; 
  top: 130px; 
}

.status-input { 
  position: absolute;
  left: 578px; 
  top: 160px; 
  width:119.10px; 
}

.medical-records-container {
    width: 900px;
    height: 173px;
    position: absolute;
    top: 600px;
    left: 500px;
}

.medical-records-container .section-label {
    color: black;
    font-size: 16px;
    font-family: "M PLUS Rounded 1c", sans-serif;
    font-weight: 400;
    word-wrap: break-word;
}

.medical-records-container .content-box {
    background: white;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    border-radius: 7px;
}

/* Diagnosis Section */
.diagnosis-section .section-label {
    position: absolute;
    left: -180px;
    top: 0;
}

.diagnosis-section .content-box {
    position: absolute;
    width: 550px;
    height: 200px;
    left: -180px;
    top: 31px;
}

/* Prescription Section */
.prescription-section .section-label {
    position: absolute;
    left: 650px;
    top: 3px;
}

.prescription-section .content-box {
    position: absolute;
    width: 550px;
    height: 200px;
    left: 650px;
    top: 31px;
}

.button-container {
    position: absolute;
    display: flex;
    gap: 10px;
    left: 1450px;
    top: 890px;
}

.add-button {
    width: 107px;
    height: 36px;
    background: #022E5F;
    color: white;
    font-size: 20px;
    font-family: "Rounded Mplus 1c", sans-serif;
    font-weight: 800;
    border: none;
    border-radius: 10px;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-button:hover {
    background: #034692;
    transform: translateY(-2px);
    box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.3);
}

.cancel-button {
    width: 95px;
    height: 36px;
    background: #97CADB;
    color: black;
    font-size: 20px;
    font-family: "Rounded Mplus 1c", sans-serif;
    font-weight: 800;
    border: none;
    border-radius: 10px;
    box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.25);
    cursor: pointer;
    transition: all 0.3s ease;
}

.cancel-button:hover {
    background: #7ab3c7;
    transform: translateY(-2px);
    box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.3);
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
                <span><i class="material-icons-outlined" style="font-size: 38px; vertical-align: middle;">assessment</i> &nbsp;Assessment</span>
            </div>
            <div class="right-section">
                <i class="fa-regular fa-bell"></i>
                <input type="text" placeholder="Search...">
                <i class="fas fa-search"></i>
            </div>
        </div>

        
 <!-- Content Section -->
 <div class="content">
  <div class="background"></div>

  <!-- Patient Information Section -->
  <label class="patient-name-label">Patient Name:</label>
  <input type="text" class="input-box patient-name-input">
  
  <label class="age-label">Age:</label>
  <input type="number" class="input-box age-input">

  <label class="physical-exam-label">Physical Examination:</label>
  <label class="diagnostic-test-label">Diagnostic Test:</label>
  
 <!-- Test Result Block -->
  <div class="test-result-block">
    <span>Test Result</span>
    <div class="test-result-icon">
        <svg width="26" height="38" viewBox="0 0 26 38" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12.5591 30.6884H0.118408V11.5986H19.2082V21.1435H17.6174V13.1895H1.70923V29.0976H13.3545L12.5591 30.6884ZM24.5151 34.7525C24.6311 34.9845 24.6891 35.2206 24.6891 35.4609C24.6891 35.6763 24.6477 35.8793 24.5648 36.0699C24.4819 36.2604 24.3701 36.4303 24.2292 36.5794C24.0884 36.7286 23.9185 36.8446 23.7197 36.9274C23.5208 37.0103 23.3137 37.0517 23.0983 37.0517H13.7274C13.5119 37.0517 13.3089 37.0103 13.1184 36.9274C12.9278 36.8446 12.7579 36.7327 12.6088 36.5919C12.4597 36.451 12.3437 36.2812 12.2608 36.0823C12.178 35.8835 12.1365 35.6763 12.1365 35.4609C12.1365 35.2206 12.1945 34.9845 12.3105 34.7525L16.0266 27.3204V24.3252H14.4358V22.7344H22.3899V24.3252H20.799V27.3204L24.5151 34.7525ZM21.5074 32.2793L19.2082 27.6932V24.3252H17.6174V27.6932L15.3182 32.2793H21.5074ZM7.27709 24.002L15.0696 16.2095L16.1881 17.3281L7.27709 26.2391L3.13848 22.1005L4.25702 20.982L7.27709 24.002Z" fill="#018ABE"/>
        </svg>
    </div>
</div>

<!-- Vital Signs Block -->
<div class="vital-signs-block">
            <span>Vital Signs</span>
            <div class="vital-signs-icon">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.731079 13.186V11.0649H6.77618L9.21544 17.5342L15.5787 0.751099L19.5027 11.0649H24.0631V13.186H18.018L15.5787 6.71666L9.21544 23.4998L5.29142 13.186H0.731079Z" fill="#018ABE"/>
                    </svg>
            </div>
    </div>


    <!-- Patient Details Section -->

  <label class="gender-label">Gender:</label>
  <select class="input-box gender-input">
    <option value="male">Male</option>
    <option value="female">Female</option>
    <option value="other">Other</option>
  </select>
  
  <label class="assessment-label">Assessment Date:</label>
  <input type="date" class="input-box assessment-input">
  
  <label class="symptoms-label">Symptoms:</label>
  <input type="text" class="input-box symptoms-input">
  
  <label class="history-label">Medical History:</label>
  <input type="text" class="input-box history-input">
</div>

<!-- Medical Form Section -->
<div class="medical-form">
  <!-- Vital Signs Section -->
  <label class="height-label">Height:</label>
  <input type="text" class="input-box height-input">
  <label class="unit-cm">cm</label>

  <label class="weight-label">Weight:</label>
  <input type="text" class="input-box weight-input">
  <label class="unit-kg">kg</label>

  <label class="temperature-label">Temperature:</label>
  <input type="text" class="input-box temperature-input">
  <label class="unit-f">°F</label>

  <label class="heart-rate-label">Heart Rate:</label>
  <input type="text" class="input-box heart-rate-input">
  <label class="unit-bpm">bpm</label>

  <label class="blood-pressure-label">Blood Pressure:</label>
  <input type="text" class="input-box blood-pressure-input">
  <label class="unit-mmhg">mmHg</label>

  <!-- Diagnostic Section -->
  <label class="test-type-label">Type of Test:</label>
  <input type="text" class="input-box test-type-input">

  <label class="status-label">Status:</label>
  <input type="text" class="input-box status-input">
</div>

<div class="medical-records-container">
    <div class="diagnosis-section">
        <div class="section-label">Diagnosis:</div>
        <div class="content-box"></div>
    </div>
    
    <div class="prescription-section">
        <div class="section-label">Prescriptions:</div>
        <div class="content-box"></div>
    </div>
</div>

<div class="button-container">
        <button class="add-button">Add</button>
        <button class="cancel-button">Cancel</button>
    </div>
    </main>

   
</body>
</html>
