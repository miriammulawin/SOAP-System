<?php
    session_start();
    
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
    
    $servername = "localhost";
    $username = "root";
    $dbname = "MedicalSystem";
    $password = "12345";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $userId = $_SESSION['user_id'];
    $sql = "SELECT FirstName, LastName FROM AuthorizeUser WHERE AuthorizeUserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
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

    function fetchUserData($userId, $conn) {
        $sql = "SELECT * FROM AuthorizeUser WHERE AuthorizeUserID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } 
        else {
            return false;
        }
    }

    $userId = $_SESSION['user_id'];
    $userData = fetchUserData($userId, $conn);

    if (!$userData) {
        $fullName = "User";
    } 
    else {
        $fullName = $userData['FirstName'];
        if (!empty($userData['LastName'])) {
            $fullName .= " " . $userData['LastName'];
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $about = trim($_POST['about']);
        $email = trim($_POST['email']);
        $phoneNumber = trim($_POST['phone_number']);
        
        $errors = [];
        if (empty($firstName)) {
            $errors[] = "First name is required";
        }
        
        if (empty($email)) {
            $errors[] = "Email is required";
        } 
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format";
        }
        
        if (empty($phoneNumber)) {
            $errors[] = "Phone number is required";
        }
        
        if (empty($errors)) {
            $updateSql = "UPDATE AuthorizeUser SET FirstName = ?, LastName = ?, Email = ?, Number = ?, About = ? WHERE AuthorizeUserID = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("sssssi", $firstName, $lastName, $email, $phoneNumber, $about, $userId);
            
            if ($updateStmt->execute()) {
                $_SESSION['update_success'] = true;
                
                $userData = fetchUserData($userId, $conn);
                $fullName = $userData['FirstName'];
                if (!empty($userData['LastName'])) {
                    $fullName .= " " . $userData['LastName'];
                }
                
                echo "<script> 
                        alert('Successful Update!'); 
                        window.location.href='setting.php';
                    </script>";
                exit();
            } 
            else {
                $updateError = "Failed to update profile: " . $conn->error;
            }
        }
    }
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Medical System: Setting</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

        <style>
                * {
                    padding: 0;
                    margin: 0;
                    font-family: "M PLUS Rounded 1c", sans-serif;
                    box-sizing: border-box;
                }

                body {
                    min-height: 100vh;
                    display: flex;
                    flex-direction: column;
                }

                header {
                    width: 100%;
                    padding: 10px 20px;
                    background-color: #018ABE;
                    display: flex;
                    align-items: center;
                }

                .title h1 {
                    font-size: clamp(24px, 5vw, 32px);
                    color: white;
                    letter-spacing: 5px;
                }

                main {
                    flex: 1;
                    background-color: #97CADB;
                    display: flex;
                    flex-direction: row;
                    min-height: calc(100vh - 72px);
                }

                aside {
                    background-color: #FFFFFF;
                    width: 280px;
                    padding: 20px 10px;
                    transition: transform 0.3s ease;
                    margin: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                }

                .user { 
                    height: 12%;
                    width: 93%;
                    position: relative;
                    display: flex;
                    align-items: center;
                    border: 2px solid #E6EAEF;
                    margin-left: 10px;
                    margin-bottom: 20px;
                }

                .user img {
                    width: 48px;
                    height: 48px;
                    margin-left: 10px;
                    margin-right: 10px;
                    border-radius: 50%;
                }

                .user span {
                    font-size: 18px;
                }

                .content {
                    padding: 10px;
                    height: calc(100% - 100px);
                    border-radius: 8px;
                }

                .content ul {
                    list-style: none;
                    box-sizing: border-box;
                    padding: 0;
                    margin: 0;
                }

                .content li {
                    display: flex;
                    align-items: center;
                }

                .content ul a {
                    width: 100%;
                    height: 50px; 
                    display: flex;
                    align-items: center;
                    justify-content: flex-start; 
                    border: 2px solid #E6EAEF;
                    padding: 10px 20px;
                    text-decoration: none;
                    color: rgb(0, 31, 62);
                    font-size: 15px;
                    font-weight: bold;
                    border-radius: 5px;
                    transition: background-color 0.3s ease;
                    box-sizing: border-box;
                    margin-bottom: 10px;
                }

                .content a:hover {
                    background-color: #1D70A0;
                    color:white;
                }

                .content i {
                    margin-right: 10px;
                }

                section {
                    flex: 1;
                    background-color: #FFFFFF;
                    margin: 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                    overflow-y: auto;
                }

                .setting-container {
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                }

                .header-setting {
                    background-color: #C2CDD9;
                    padding: 15px 20px;
                    margin: 15px;
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    flex-wrap: wrap;
                    gap: 15px;
                }

                .header-setting img {
                    width: 36px;
                    height: 36px;
                }

                .header-title {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                }

                .header-setting p {
                    font-size: clamp(20px, 4vw, 32px);
                    font-weight: bold;
                }

                .nav-setting {
                    display: flex;
                    align-items: center;
                    gap: 15px;
                    flex-wrap: wrap;
                }

                .search-setting {
                    position: relative;
                }

                #search {
                    width: clamp(180px, 30vw, 318px);
                    height: 40px;
                    text-align: center;
                    font-size: 16px;
                    border-radius: 10px;
                    border: 1px solid #022E5F;
                    padding: 0 40px 0 15px;
                    margin-right: 10px;
                }

                .nav-setting a i {
                    font-size: 20px;
                    color: #02457A;
                }

                .nav-setting a i:hover {
                    color: white;
                }

                .notif i {
                    font-size: 20px;
                    color: #02457A;
                }

                .setting {
                    background-color: #C2CDD9;
                    margin: 15px;
                    border-radius: 8px;
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                    overflow: hidden;
                }

                @media (min-width: 1024px) {
                    .setting {
                        flex-direction: row;
                    }
                }

                .setting-content {
                    padding: 15px;
                    width: 100%;
                }

                @media (min-width: 1024px) {
                    .setting-content {
                        width: 40%;
                        border-right: 1px solid #97CADB;
                    }
                }

                .setting-content > ul > div {
                    background-color: #FFFFFF;
                    margin-bottom: 15px;
                    padding: 15px;
                    border-radius: 8px;
                    transition: transform 0.2s;
                    display: flex;
                    flex-direction: column;
                }

                .setting-content > ul > div:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                }

                .setting-content-header {
                    display: flex;
                    align-items: center;
                    margin-bottom: 10px;
                }

                .setting-content img {
                    width: 32px;
                    height: 32px;
                    margin-right: 15px;
                }

                .setting-content a {
                    text-decoration: none;
                    color: #022E5F;
                    font-size: 18px;
                    font-weight: bold;
                    transition: color 0.2s;
                }

                .setting-content a:hover {
                    color: #018ABE;
                }

                .setting-content p {
                    font-size: 14px;
                    color: #555;
                    line-height: 1.5;
                }

                .setting-pick-content {
                    display: none;
                    flex: 1;
                    padding: 15px;
                    background-color: #C2CDD9;
                    border-radius: 0 8px 8px 0;
                }

                .account-content {
                    width: 100%;
                    max-width: 800px;
                    margin: 0 auto;
                }

                .account-content h1 {
                    font-size: 28px;
                    margin-bottom: 25px;
                    color: #022E5F;
                }

                .profile, .info {
                    background-color: #f5f7fa;
                    padding: 20px;
                    border-radius: 8px;
                    margin-bottom: 30px;
                }

                .profile h3, .info h3 {
                    font-size: 20px;
                    color: #022E5F;
                    margin-bottom: 10px;
                }

                .profile p, .info p {
                    margin-bottom: 20px;
                    color: #555;
                    font-size: 14px;
                }

                .name-fields, .contact-fields {
                    display: flex;
                    flex-direction: column;
                    gap: 20px;
                    margin-bottom: 20px;
                }

                @media (min-width: 640px) {
                    .name-fields, .contact-fields {
                        flex-direction: row;
                    }
                }

                .first-name, .last-name, .email, .number {
                    flex: 1;
                }

                label {
                    display: block;
                    margin-bottom: 8px;
                    font-weight: bold;
                    color: #333;
                }

                input[type="text"],
                input[type="email"] {
                    width: 100%;
                    height: 43px;
                    border-radius: 8px;
                    border: 1px solid #ccc;
                    padding: 10px;
                    font-size: 14px;
                    transition: border-color 0.2s;
                }

                input[type="text"]:focus,
                input[type="email"]:focus {
                    border-color: #018ABE;
                    outline: none;
                }

                .line img {
                    width: 100%;
                    height: 1px;
                    background-color: #ccc;
                    margin: 30px 0;
                }

                .button-group {
                    display: flex;
                    justify-content: flex-end;
                    gap: 15px;
                    margin-top: 30px;
                }

                #save-btn, #cancel-btn {
                    padding: 10px 25px;
                    border-radius: 25px;
                    font-size: 16px;
                    font-weight: bold;
                    color: white;
                    border: none;
                    cursor: pointer;
                    transition: opacity 0.2s;
                }

                #save-btn {
                    background-color: #022E5F;
                }

                #cancel-btn {
                    background-color: #97CADB;
                }

                #save-btn:hover, #cancel-btn:hover {
                    opacity: 0.9;
                }

                .menu-toggle {
                    display: none;
                    background: none;
                    border: none;
                    font-size: 24px;
                    color: white;
                    cursor: pointer;
                }

                @media (max-width: 768px) {
                    main {
                        flex-direction: column;
                    }
                    
                    aside {
                        width: calc(100% - 40px);
                        transform: translateX(-120%);
                        position: absolute;
                        z-index: 100;
                        height: calc(100vh - 92px);
                    }
                    
                    aside.active {
                        transform: translateX(0);
                    }
                    
                    .menu-toggle {
                        display: block;
                        margin-right: 15px;
                    }
                    
                    section {
                        width: calc(100% - 40px);
                    }
                    
                    .setting-pick-content {
                        padding: 10px;
                    }
                    
                    .header-setting {
                        flex-direction: column;
                        align-items: flex-start;
                    }
                    
                    .nav-setting {
                        width: 100%;
                        justify-content: space-between;
                    }
                    
                    #search {
                        width: 100%;
                    }
                    
                    .button-group {
                        flex-direction: column;
                        width: 100%;
                    }
                    
                    #save-btn, #cancel-btn {
                        width: 100%;
                        text-align: center;
                    }
                }

                .d-flex {
                    display: flex;
                }

                .align-center {
                    align-items: center;
                }

                .hidden {
                    display: none;
                }
        </style>
    </head>
    
    <body>
            <header>
                    <button id="menuToggle" class="menu-toggle">☰</button>
                    
                    <div class="title">
                        <h1>MEDICARE</h1>
                    </div>
            </header>

            <main>
                <aside id="sidebar">
                    <div class="user">
                        <img src="../SOAP-System/Images/user-icon2.png" alt="User Icon">
                        <span id="authorizedName"><?php echo htmlspecialchars($fullName); ?></span>
                    </div>

                    <div class="content">
                        <ul>
                            <li>
                                <a href="Dashboard.php"><i class="material-icons-outlined">dashboard</i> Dashboard</a>
                            </li>

                            <li>
                                <a href="Record.php"><i class="material-icons-outlined">description</i> Record</a>
                            </li>

                            <li>
                                <a href="Assessment.php"><i class="material-icons-outlined">assessment</i> Assessment</a>
                            </li>

                            <li>
                                <a href="Appointment.php"><i class="material-icons-outlined">calendar_today</i> Appointment</a>
                            </li>

                            <li>
                                <a href="setting.php"><i class="material-icons-outlined">settings</i> Settings</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="confirmLogout()"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
                            </li>
                        </ul>
                    </div>
                </aside>

                <section>
                    <div class="setting-container">
                        <div class="header-setting">
                            <div class="header-title">
                                <img src="../SOAP-System/Images/fill-setting.png" alt="Setting Logo">
                                <p>Settings</p>
                            </div>

                            <div class="nav-setting">   
                                <div class="search-setting">
                                    <input id="search" type="search" name="Search" placeholder="Search">
                                    <a href=""><i class="fas fa-search"></i></a>
                                </div>
                                
                                <div class="notif">
                                    <a href=""><i class="fas fa-bell"></i></a>
                                </div>
                            </div>
                        </div>
                    
                        <div class="setting">
                            <div class="setting-content">
                                <ul>
                                    <div class="account">
                                        <div class="setting-content-header">
                                            <img src="../SOAP-System/Images/profile.png" alt="Profile">
                                            <a href="javascript:void(0);" onclick="showContent('account')">Account</a>
                                        </div>
                                        <p>
                                            Update your personal info, security preferences, and communication settings for a personalized and 
                                            secure experience.
                                        </p>
                                    </div>

                                    <div class="notification">
                                        <div class="setting-content-header">
                                            <img src="../SOAP-System/Images/notification-black.png" alt="Notification">
                                            <a href="">Notifications</a>
                                        </div>
                                        <p>
                                            Customize how and when you receive alerts, including appointment reminders, updates, 
                                            and clinic notifications.
                                        </p>
                                    </div>

                                    <div class="security">
                                        <div class="setting-content-header">
                                            <img src="../SOAP-System/Images/lock.png" alt="Security">
                                            <a href="">Security</a>
                                        </div>
                                        <p>
                                            Enhance your account security by updating your password, enabling two-factor authentication, and reviewing 
                                            login activity.
                                        </p>
                                    </div>

                                    <div class="appearance">
                                        <div class="setting-content-header">
                                            <img src="../SOAP-System/Images/appearance.png" alt="Appearance">
                                            <a href="">Appearance</a>
                                        </div>
                                        <p>
                                            Customize colors, fonts, logos, and layout to reflect the brand and ensure a professional, user-friendly design.
                                        </p>
                                    </div>

                                    <div class="resources">
                                        <div class="setting-content-header">
                                            <img src="../SOAP-System/Images/setting-black.png" alt="Resources">
                                            <a href="">Additional Resources</a>
                                        </div>
                                        <p>
                                            Extra tools, links, and materials to support and enhance the user experience on the clinic website, providing helpful 
                                            information for patients and visitors.
                                        </p>
                                    </div>
                                </ul>
                            </div>

                            <div class="setting-pick-content">
                                <div class="account-content" id="account-content">
                                    <form action="" method="POST">
                                        <h1>Account</h1>

                                        <div class="profile">
                                            <h3>Profile</h3>
                                            <p>This information will be displayed publicly so be careful what you share.</p>

                                            <div class="name-fields">
                                                <div class="first-name">
                                                    <label for="first-name">First Name:</label>
                                                    <input type="text" id="first-name" placeholder="First Name" name="first_name" value="<?php echo htmlspecialchars($userData['FirstName'] ?? ''); ?>">
                                                </div>

                                                <div class="last-name">
                                                    <label for="last-name">Last Name:</label>
                                                    <input type="text" id="last-name" placeholder="Last Name" name="last_name" value="<?php echo htmlspecialchars($userData['LastName'] ?? ''); ?>">
                                                </div>
                                            </div>  

                                            <div class="about">
                                                <label for="about">About:</label>
                                                <input type="text" name="about" id="about" value="<?php echo htmlspecialchars($userData['About'] ?? ''); ?>">
                                            </div>
                                        </div>

                                        <div class="line">
                                            <img src="../SOAP-System/Images/line.png" alt="Line">
                                        </div>

                                        <div class="info">
                                            <h3>Personal Information</h3>
                                            <p>This information will be displayed publicly so be careful what you share.</p>

                                            <div class="contact-fields">
                                                <div class="email">
                                                    <label for="email">Email Address:</label>
                                                    <input type="email" id="email" placeholder="Email Address" name="email" value="<?php echo htmlspecialchars($userData['Email'] ?? ''); ?>">
                                                </div>
                                                
                                                <div class="number">
                                                    <label for="phone-number">Phone Number:</label>
                                                    <input type="text" id="phone-number" name="phone_number" placeholder="Phone Number" value="<?php echo htmlspecialchars($userData['Number'] ?? ''); ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="button-group">
                                            <button id="save-btn" type="submit" name="update_profile">Save</button>
                                            <button id="cancel-btn" type="button">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
    </body>

        <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const menuToggle = document.getElementById('menuToggle');
                    const sidebar = document.getElementById('sidebar');
                    
                    if (menuToggle && sidebar) {
                        menuToggle.addEventListener('click', function() {
                            sidebar.classList.toggle('active');
                        });
                    }
                    
                    document.addEventListener('click', function(e) {
                        if (sidebar && sidebar.classList.contains('active') && 
                            !sidebar.contains(e.target) && 
                            e.target !== menuToggle) {
                            sidebar.classList.remove('active');
                        }
                    });
                    
                    function confirmLogout() {
                        if (confirm("Are you sure you want to logout?")) {
                            window.location.href = "?action=logout&confirm=yes";
                            alert('Successful Logout!');
                        }
                    }
                    window.confirmLogout = confirmLogout;

                    function showMainContent(contentType) {
                        if (contentType === 'setting') {
                            document.querySelector('.setting-container').style.display = 'flex';
                            document.querySelector('.setting').style.display = 'flex';
                            document.querySelector('.setting-content').style.display = 'block';
                            
                            var contentSections = document.querySelectorAll('.setting-pick-content > div');
                            for (var i = 0; i < contentSections.length; i++) {
                                contentSections[i].style.display = 'none';
                            }
                            
                            if (window.innerWidth < 1024) {
                                document.querySelector('.setting-pick-content').style.display = 'none';
                            } 
                            else {
                                document.querySelector('.setting-pick-content').style.display = 'block';
                            }
                            
                            if (sidebar.classList.contains('active')) {
                                sidebar.classList.remove('active');
                            }
                        }
                    }
                    window.showMainContent = showMainContent;

                    function showContent(contentType) {
                        document.querySelector('.setting-pick-content').style.display = 'block';
                        
                        var contentSections = document.querySelectorAll('.setting-pick-content > div');
                        for (var i = 0; i < contentSections.length; i++) {
                            contentSections[i].style.display = 'none';
                        }
                        
                        var selectedContent = document.getElementById(contentType + '-content');
                        if (selectedContent) {
                            selectedContent.style.display = 'block';
                        }
                        
                        if (window.innerWidth < 1024) {
                            document.querySelector('.setting-content').style.display = 'none';
                        }
                    }
                    window.showContent = showContent;

                    if (window.location.search.includes('update=success')) {
                        showMainContent('setting');
                        showContent('account');
                    }
                    
                    const saveButton = document.getElementById('save-btn');
                    if (saveButton) {
                        saveButton.addEventListener('click', function(e) {
                            const firstName = document.getElementById('first-name').value.trim();
                            const email = document.getElementById('email').value.trim();
                            const phoneNumber = document.getElementById('phone-number').value.trim();
                            let hasErrors = false;
                            let errorMessages = [];
                            
                            if (!firstName) {
                                errorMessages.push("First name is required");
                                hasErrors = true;
                            }
                            
                            if (!email) {
                                errorMessages.push("Email is required");
                                hasErrors = true;
                            } 
                            else if (!isValidEmail(email)) {
                                errorMessages.push("Invalid email format");
                                hasErrors = true;
                            }

                            function isValidEmail(email) {
                                let atSymbol = email.indexOf("@");
                                let dotSymbol = email.lastIndexOf(".");
                                
                                if (atSymbol < 1 || dotSymbol < atSymbol + 2 || dotSymbol + 2 >= email.length) {
                                    return false; 
                                }
                                return true; 
                            }
                            
                            if (!phoneNumber) {
                                errorMessages.push("Phone number is required");
                                hasErrors = true;
                            }
                            
                            if (hasErrors) {
                                e.preventDefault();
                                alert(errorMessages.join("\n"));
                                return false;
                            }

                            if (!confirm("Are you sure you want to save these changes?")) {
                                e.preventDefault();
                                return false;
                            }
                        });
                    }
                    
                    const cancelButton = document.getElementById('cancel-btn');
                    if (cancelButton) {
                        cancelButton.addEventListener('click', function(e) {
                            const formFields = document.querySelectorAll('.account-content input');
                            let formChanged = false;

                            formFields.forEach(field => {
                                if (field.defaultValue !== field.value) {
                                    formChanged = true;
                                }
                            });

                            if (formChanged) {
                                if (!confirm("Are you sure you want to discard your changes?")) {
                                    e.preventDefault();
                                    return false;
                                }
                                
                                formFields.forEach(field => {
                                    field.value = field.defaultValue;
                                });
                            }

                            document.querySelector('.setting-pick-content').style.display = 'none';
                            if (window.innerWidth < 1024) {
                                document.querySelector('.setting-content').style.display = 'block';
                            }
                        });
                    }
                    
                    window.addEventListener('resize', function() {
                        if (window.innerWidth >= 1024) {
                            document.querySelector('.setting-content').style.display = 'block';
                            sidebar.classList.remove('active');
                        }
                    });
                });
        </script>
</html>