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
    } else {
        $fullName = "User";
    }
    
     if (isset($_GET['action']) && $_GET['action'] == 'logout' && isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
        $_SESSION = array();
        
        session_destroy();
        
        header("Location: login.php");
        exit();
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

        <style>
                * {
                    padding: 0%;
                    margin: 0%;
                    font-family: "M PLUS Rounded 1c";
                }

                header {
                    max-width: 100%;
                    height: 52px;
                    padding: 10px;
                    background-color: #018ABE; 
                }

                .title h1 {
                    margin-top: 5px;
                    font-size: 32px;
                    color: white;
                    letter-spacing: 7px;
                }

                main {
                    max-width: 100%;
                    height: 809px;
                    background-color: #97CADB;
                }

                aside {
                    float: left;
                    position: relative;
                    background-color: #FFFFFF;
                    width: 16.8%;
                    height: 770px;
                    margin-top: 20px;
                    margin-left: 30px;
                }

                .user {
                    background-color: #C2CDD9;
                    width: 246px;
                    height: 79px;
                    margin-top: 10px;
                    margin-left: 18px   
                }

                #edit {
                    width: 24px;
                    height: 24px;
                    position: absolute;
                    margin-left: 210px;
                    margin-top: 5px;
                    margin-bottom: 10px
                }

                .user img {
                    width: 48px;
                    height: 48px ;
                    margin-top: 20px;
                    margin-left: 10px
                }

                .user span {
                    position: absolute;
                    margin-top: 35px;
                    margin-left: 10px;
                    font-size: 18px;
                    font-family: 'Rounded Mplus 1c';
                }

                .content {
                    background-color: #C2CDD9;
                    width: 246px;
                    height: 84%;
                    margin-top: 18px;
                    margin-left: 18px;
                }
                
                .content ul {
                    margin-left: 25px;  
                }

                .content img {
                    width: 32px;
                    height: 32px;
                    margin-left: 15px;
                    margin-top: 18px;
                    position: relative;
                }

                .content li {
                    list-style: none;
                    margin-top: -32px;
                    margin-left: 35px;
                    margin-bottom: 15px
                }

                .content a {
                    text-decoration: none;
                    color: #022E5F;
                    margin-left: 25px;
                    font-size: 18px;
                    font-weight: bold;
                }

                .content a:hover {
                    color: white;
                }

                section {
                    width: 80%;
                    height: 95%;
                    float: left;
                    background-color: #FFFFFF;
                    margin-top: 20px;
                    margin-left: 15px;
                }
                
                .header-setting {
                    background-color: #C2CDD9;
                    width: 98%;
                    height: 79px;
                    margin-left: 13px;
                    margin-top: 15px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                .header-setting img {
                    width: 40px;
                    height: 40px;
                    margin-left: 20px
                }

                .header-setting p {
                    position: absolute;
                    margin-left: 80px;
                    font-size: 32px;
                    font-weight: 40px;
                }

                .nav-setting {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                    margin-right: 30px;
                }

                .notif img {
                    width: 24px;
                    height: 24px;
                    margin-right: 10px;
                    margin-top: -5px;
                }

                #search {
                    width: 318px;
                    height: 40px;
                    text-align: center;
                    font-size: 20px;
                    border-radius: 10px;
                    margin-bottom: 10px;
                    margin-right: 35px;
                    border: 1px solid #022E5F;
                }

                .nav-setting button{
                    position: absolute;
                    margin-left: -15px;
                    text-align: center;
                    background-color: transparent;
                    border: none;
                }
                
                .nav-setting button img {
                    width: 24px;
                    object-fit: contain;
                    margin-left: -1px;
                }

                .setting {
                    background-color: #C2CDD9;
                    width: 98%;
                    height: 84%;
                    margin-left: 13px;
                    margin-top: 18px;
                }

                .setting-content {
                    width: 40%;
                    height: 100%;
                    float: left;
                }
                
                .setting-content img{
                    width: 37px;
                    height: 37px;
                    display: flex;
                    margin-top: 20px;
                    margin-left: 25px;
                }

                .account {
                    width: 100%;
                    height: 127px;
                    border: 1px solid black;
                }

                .notification {
                   width: 100%;
                    height: 127px;
                    border: 1px solid black;
                }

                .security {
                    width: 100%;
                    height: 127px;
                    border: 1px solid black;
                }

                .appearance {
                    width: 100%;
                    height: 127px;
                    border: 1px solid black;
                }

                .setting-content {
                    display: none;
                }

                .resources {
                    width: 100%;
                    height: 128px;
                    border: 1px solid black;
                }

                .setting-content a {
                    position: absolute;
                    margin-top: -35px;
                    margin-left: 80px;
                    font-size: 20px;
                    text-decoration: none;
                    color: black;
                    font-weight: bold;
                }

                .setting-content p {
                    width: calc(82% - 50px);
                    text-align: justify;
                    margin-left: 80px;
                    font-size: 14px;
                }

                .setting-content a:hover {
                    color: white;
                }

                .setting-pick-content {
                    width: 60%;
                    height: 100%;
                    float: left;
                }

                .account-content {
                    display: none;
                    width: 100%;
                    height: 100%;
                    margin-left:20px;
                }

                .account-content h1 {
                    font-size: 32px;
                    padding: 10px;
                    margin: 25px 20px 10px 25px; 
                }

                .profile {
                    width: 85%;
                    height: auto; 
                    margin-bottom: 20px; 
                }

                .profile h3 {
                    margin-left: 35px;
                    margin-top: -20px;
                    font-size: 20px;
                    font-weight: bold; 
                }

                .profile p {
                    margin-left: 35px;
                    margin-bottom: 10px; 
                    font-size: 15px;
                }

                .profile label {
                    margin-bottom: -10px;
                    font-size: 15px;
                    font-weight: bold;
                    display: block; 
                }

                .name-fields {
                    display: flex; 
                    margin-left: 35px;
                    margin-bottom: 15px; 
                    gap: 25px;
                }

                .first-name,
                .last-name {
                    flex: 1; 
                }

                .first-name input,
                .last-name input {
                    width: 100%; 
                    height: 43px;
                    border-radius: 10px;
                    border: 1px solid #ccc; 
                    padding: 10px; 
                    font-size: 14px;
                    box-sizing: border-box;
                    margin-top: -15px;
                }

                .about {
                    margin-left: 35px;
                    margin-bottom: 20px; 
                }

                .about input {
                    width: 599px; 
                    height: 53px;
                    border-radius: 10px;
                    border: 1px solid #ccc; 
                    padding: 10px; 
                    font-size: 14px;
                    box-sizing: border-box; 
                    margin-top: -20px;
                }

                .line img {
                    display: block;
                    margin: 20px 0;
                    margin-left: 35px;
                }

                .info {
                    width: 85%;
                    height: auto; 
                    margin-top: 20px; 
                }

                .info h3 {
                    margin-left: 35px;
                    font-size: 20px;
                    font-weight: bold; 
                }

                .info p {
                    margin-left: 35px;
                    margin-bottom: 20px; 
                    font-size: 15px;
                }

                .info label {
                    margin-bottom: -10px;
                    font-size: 15px;
                    font-weight: bold;
                    display: block; 
                }

                .contact-fields {
                    display: flex; 
                    margin-left: 35px;
                    margin-bottom: 20px; 
                    gap: 25px; 
                }

                .email,
                .number {
                    flex: 1; 
                }

                .email input,
                .number input {
                    width: 100%; 
                    height: 43px;
                    border-radius: 10px;
                    border: 1px solid #ccc; 
                    padding: 10px; 
                    font-size: 14px;
                    box-sizing: border-box; 
                    margin-top: -20px
                }

                /* Buttons */
                #save-btn,
                #cancel-btn {
                    padding: 10px 30px;
                    border-radius: 20px;
                    font-size: 18px;
                    font-weight: bold;
                    color: white;
                    border: none;
                    cursor: pointer;
                    margin-top: 20px; 
                }

                #save-btn {
                    background-color: #022E5F;
                    margin-left: 435px;
                }

                #cancel-btn {
                    background-color: #97CADB;
                    margin-left: 10px; 
                }

        </style>
    </head>
    
    <body>
            <header>
                    <div class="title">
                            <h1>MEDICARE</h1>
                    </div>
            </header>
        
            <main>
                    <aside>
                            <div class="user">
                                    <img id="edit" src="../SOAP-System/Images/edit.png" alt="">
                                    <img src="../SOAP-System/Images/user-icon2.png" alt="">
                                    <span id="authorizedName">
                                        <?php echo htmlspecialchars($fullName); ?>
                                    </span>
                            </div>

                            <div class="content">
                                    <ul>
                                        <img src="../SOAP-System/Images/dashboard.png" alt="Dashboard Logo">
                                        <li><a href="">Dashboard</a></li>

                                        <img src="../SOAP-System/Images/records.png" alt="Records Logo">
                                        <li><a href="">Records</a></li>

                                        <img src="../SOAP-System/Images/appointment.png" alt="Appointment Logo">
                                        <li><a href="">Appointments</a></li>

                                        <img src="../SOAP-System/Images/assessment.png" alt="Assessment Logo">
                                        <li><a href="">Assessment</a></li>

                                        <img src="../SOAP-System/Images/setting.png" alt="Setting Logo">
                                        <li><a href="javascript:void(0);" onclick="showMainContent('setting')">Setting</a></li>

                                        <img src="../SOAP-System/Images/logout.png" alt="Logout Logo">
                                        <li><a href="javascript:void(0);" onclick="confirmLogout()">Logout</a></li>
                                    </ul>
                            </div>
                    </aside>

                    <section>
                                <div class="header-setting">
                                        <img src="../SOAP-System/Images/fill-setting.png" alt="Setting Logo">
                                        <p>Settings</p>

                                        <div class="nav-setting">
                                                <div class="search-setting">
                                                        <input id="search" type="search" name="Search" placeholder="Search">
                                                        <button><img src="../SOAP-System/Images/search.png" alt="Search"></button>
                                                </div>
                                                
                                                <div class="notif">
                                                    <a href=""><img src="../SOAP-System/Images/notification.png" alt="Notification"></a>
                                                </div>
                                        </div>
                                </div>
                                
                                <div class="setting">
                                        <div class="setting-content">
                                            <ul>
                                                    <div class="account">
                                                        <img src="../SOAP-System/Images/profile.png" alt="Profile">
                                                            <a href="javascript:void(0);" onclick="showContent('account')">Account</a>
                                                            <p>
                                                                Update your personal info, security preferences, and communication settings for a personalized and 
                                                                secure experience.
                                                            </p>
                                                    </div>

                                                    <div class="notification">
                                                        <img src="../SOAP-System/Images/notification-black.png" alt="Notification">
                                                            <a href="">Notifications</a>
                                                            <p>
                                                                Customize how and when you receive alerts, including appointment reminders, updates, 
                                                                and clinic notifications.
                                                            </p>
                                                    </div>

                                                    <div class="security">
                                                        <img src="../SOAP-System/Images/lock.png" alt="Security">
                                                            <a href="">Security</a>
                                                            <p>
                                                                Enhance your account security by updating your password, enabling two-factor authentication, and reviewing 
                                                                login activity.
                                                            </p>
                                                    </div>

                                                    <div class="appearance">
                                                        <img src="../SOAP-System/Images/appearance.png" alt="Appearance">
                                                            <a href="">Appearance</a>
                                                            <p>
                                                                Customize a colors, fonts, logos, and layout to reflect the brand and ensure a professional, user-friendly design.
                                                            </p>
                                                    </div>

                                                    <div class="resources">
                                                        <img src="../SOAP-System/Images/setting-black.png" alt="">
                                                            <a href="">Additional Resources</a>
                                                            <p>
                                                                Extra tools, links, and materials to support and enhance the user experience on the clinic website, providing helpful 
                                                                information for patients and visitors.
                                                            </p>
                                                    </div>
                                            </ul>

                                        </div>

                                        <div class="setting-pick-content">
                                                <div class="account-content" id="account-content">
                                                        <form action="">
                                                                <h1>Account</h1>

                                                                <div class="profile">
                                                                    <h3>Profile</h3>
                                                                    <p>This information will be displayed publicly so be careful what you share.</p>

                                                                    <div class="name-fields">
                                                                        <div class="first-name">
                                                                            <label for="first-name">First Name:</label><br>
                                                                            <input type="text" id="first-name" placeholder="First Name">
                                                                        </div>

                                                                        <div class="last-name">
                                                                            <label for="last-name">Last Name:</label><br>
                                                                            <input type="text" id="last-name" placeholder="Last Name">
                                                                        </div>
                                                                    </div>  

                                                                    <div class="about">
                                                                        <label for="about">About:</label><br>
                                                                        <input type="text" name="about" id="about">
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
                                                                            <label for="email">Email Address:</label><br>
                                                                            <input type="email" id="email" placeholder="Email Address">
                                                                        </div>
                                                                        
                                                                        <div class="number">
                                                                            <label for="phone-number">Phone Number:</label><br>
                                                                            <input type="text" id="phone-number" placeholder="Phone Number">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <button id="save-btn" type="button">Save</button>
                                                                <button id="cancel-btn" type="button">Cancel</button>
                                                        </form>
                                                </div>
                                        </div>
                                </div>
                    </section>
            </main>
    </body>

    <script>
                function confirmLogout() {
                    if (confirm("Are you sure you want to logout?")) {
                        window.location.href = "?action=logout&confirm=yes";
                        alert('Successful Logout!');
                    }
                }

                function showMainContent(contentType) {
                // When Setting is clicked in sidebar
                if (contentType === 'setting') {
                    // Show the setting container
                    document.querySelector('.setting').style.display = 'block';
                    
                    // Show only the setting menu (left side)
                    document.querySelector('.setting-content').style.display = 'block';
                    
                    // Hide all content sections in the right panel
                    var contentSections = document.querySelectorAll('.setting-pick-content > div');
                    for (var i = 0; i < contentSections.length; i++) {
                        contentSections[i].style.display = 'none';
                    }
                    
                    // Initially hide the right panel container itself
                    document.querySelector('.setting-pick-content').style.display = 'none';
                }
            }

            function showContent(contentType) {
                // When a specific setting is clicked in the left menu
                
                // First, show the right panel container
                document.querySelector('.setting-pick-content').style.display = 'block';
                
                // Then, hide all specific content sections
                var contentSections = document.querySelectorAll('.setting-pick-content > div');
                for (var i = 0; i < contentSections.length; i++) {
                    contentSections[i].style.display = 'none';
                }
                
                // Show only the selected content section
                var selectedContent = document.getElementById(contentType + '-content');
                if (selectedContent) {
                    selectedContent.style.display = 'block';
                }
            }
    </script>
</html>