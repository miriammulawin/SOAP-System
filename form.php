<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicare Patient Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
/* Style for the select element */
select {
    width: 100%;
    padding: 12px 30px 12px 12px; /* Add extra padding for the dropdown icon */
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
    background-color: #fff;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    position: relative;
}

/* Add custom dropdown icon */
select::after {
    content: '\25BC'; /* Downward arrow */
    font-size: 16px;
    color: #555;
    position: absolute;
    top: 50%;
    right: 10px;
    transform: translateY(-50%);
    pointer-events: none;
}

/* Remove the default arrow (for webkit browsers) */
select::-ms-expand {
    display: none;
}

/* Optional: Add styling to options */
select option {
    padding: 10px;
}

/* Focus styles */
select:focus {
    outline: none;
    border-color: #28a745;
}

    </style>
</head>
<body>
    <button onclick="document.getElementById('modal').style.display='block'">Open Form</button>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('modal').style.display='none'">&times;</span>
            <h1>MEDICARE</h1>
            <h2>Fill-up Form for Patient</h2>
            <form action="process_patient.php" method="post">
                <div class="row">
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" required>
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
                    <div class="select-wrapper">
                        <select id="gender" name="gender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                            <option value="Prefer not to say">Prefer not to say</option>
                        </select>
                    </div>
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
                    <textarea id="medical_history" name="medical_history" rows="3" required></textarea>
                </div>

                <hr>
                <h2>Physical Examination of Patient</h2>
                <div class="row">
                    <div class="form-group">
                        <label for="height">Height (cm):</label>
                        <input type="number" id="height" name="height" required>
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight (kg):</label>
                        <input type="number" id="weight" name="weight" required>
                    </div>
                    <div class="form-group">
                        <label for="temperature">Temperature (°C)</label>
                        <input type="number" id="temperature" name="temperature" step="0.1" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="heart rate">Heart Rate:</label>
                        <input type="number" id="height" name="height" required>
                    </div>
                    <div class="form-group">
                        <label for="blood pressure">Blood Pressure:</label>
                        <input type="number" id="weight" name="weight" required>
                    </div>
                </div>

                <hr>
                <div class="diagnostic-test">Diagnostic Test</div>
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
            <input type="radio" name="diagnosticTest" value="Not Applicable" checked> Not Applicable
        </label>
    </div>

    <button type="submit" class="btn-submit">ADD PATIENT</button>
</div>
    </div>
</body>
</html>
<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicare Patient Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
    <button onclick="document.getElementById('modal').style.display='block'">Open Form</button>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('modal').style.display='none'">&times;</span>
            <h1>MEDICARE</h1>
            <h2>Fill-up Form for Patient</h2>
            <div class="date-container">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
            </div>
            <form action="process_patient.php" method="post">
                <div class="row">
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" required>
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" required>
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
                        <input type="text" id="gender" name="gender" required>
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
                    <textarea id="medical_history" name="medical_history" rows="3" required></textarea>
                </div>

                <hr>
                <h2>Physical Examination of Patient</h2>
                <div class="row">
                    <div class="form-group">
                        <label for="height">Height (cm):</label>
                        <input type="number" id="height" name="height" required>
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight (kg):</label>
                        <input type="number" id="weight" name="weight" required>
                    </div>
                    <div class="form-group">
                        <label for="temperature">Temperature (°C)</label>
                        <input type="number" id="temperature" name="temperature" step="0.1" required>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group">
                        <label for="heart rate">Heart Rate:</label>
                        <input type="number" id="height" name="height" required>
                    </div>
                    <div class="form-group">
                        <label for="blood pressure">Blood Pressure:</label>
                        <input type="number" id="weight" name="weight" required>
                    </div>
                </div>

                <hr>
                <div class="diagnostic-test">Diagnostic Test</div>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="diagnostic[]" value="Radiology"> Radiology</label>
                    <label><input type="checkbox" name="diagnostic[]" value="Cardiology"> Cardiology</label>
                    <label><input type="checkbox" name="diagnostic[]" value="Not Applicable"> Not Applicable</label>
                </div>
                <div class="checkbox-group">
                    <label><input type="checkbox" name="diagnostic[]" value="Laboratory"> Laboratory</label>
                    <label><input type="checkbox" name="diagnostic[]" value="Neurological"> Neurological</label>
                </div>
                <button type="submit" class="btn-submit">ADD PATIENT</button>
            </form>
        </div>
    </div>
</body>
</html>
