<?php
    session_start();  

    $servername = "localhost";
    $username = "root";
    $dbname = "medicalsystem";
    $password = "Password123";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM AuthorizeUser WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email); 
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if ($user['Password'] == $password) {
                $_SESSION['user_id'] = $user['AuthorizeUserID'];
                $_SESSION['user_name'] = $user['NameUser'];

                echo "<script>alert('Login successful! Welcome, " . $user['NameUser'] . "');</script>";
            } else {
                echo "<script>alert('Incorrect password.');</script>";
            }
        } else {
             echo "<script>alert('User with that email does not exist.');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical System: Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c&display=swap" rel="stylesheet">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            height: 100%;
            font-family: "M PLUS Rounded 1c";
        }

        main {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url('../SOAP-System/Images/Login-BG.jpg');
            background-repeat: no-repeat;
            background-size: cover;
        }

        .loginForm {
            background: rgba(255, 255, 255, 0.8);
            opacity: 0.8;
            border-radius: 40px;
            padding: 40px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            height: 500px;
            text-align: center;
        }

        .intro h2 {
            margin-bottom: 10px;
            font-size: 20px;
        }

        .intro h1 {
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 7px;
            color: #001B48;
        }

        .intro p {
            margin-top: -5px;
            font-size: 13px;
            margin-bottom: 20px;
        }

        .input-box {
            margin-bottom: 20px;
            position: relative;
        }

        .input-box label {
            float: left;
            margin-bottom: 5px;
            font-size: 15px;
            font-weight: bold;
        }

        .input-box input {
            width: 310px;
            padding: 10px 15px 10px 45px;
            font-size: 16px;
            border: 2px solid #001B48;
            border-radius: 5px;
            outline: none;
            transition: border-color 0.3s;
        }

        .input-box input:focus {
            border-color: #0078d4;
        }

        .input-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            color: #999;
        }

        .show-password {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            margin-bottom: 15px;
            margin-left: 3px;
        }

        .forgot {
            display: flex;
            align-items: center;
            float: right;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 15px;
            margin-top: -15px;
            margin-right: 10px;
        }

        .forgot a {
            text-decoration: none;
            color: #0078d4;
            transition: color 0.3s;
        }

        .forgot a:hover {
            color: #0056a3;
        }

        .loginForm button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            color: white;
            background: #0078d4;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .loginForm button:hover {
            background: #0056a3;
        }
    </style>
</head>

<body>
    <main>
        <section class="loginForm">
            <form id="login-form" action="login.php" method="POST">
                <div class="intro">
                    <h2>Welcome Back!</h2>
                    <h1>MEDICARE</h1>
                    <p>Login to your account to continue</p>
                </div>

                <div class="input-box">
                    <label for="email">Email</label>
                    <input id="login-username" type="text" name="email" required>
                    <i class='bx bxs-user'></i>
                </div>

                <div class="input-box">
                    <label for="password">Password</label>
                    <input id="login-password" type="password" name="password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>

                <!-- Show Password Checkbox -->
                <div class="show-password">
                    <input type="checkbox" id="show-password">
                    <label for="show-password">Show Password</label>
                </div>

                <div class="forgot">
                    <a href="#">Forgot password?</a>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>
        </section>
    </main>

    <script>
        document.getElementById("show-password").addEventListener("change", function() {
            let passwordInput = document.getElementById("login-password");
            if (this.checked) {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        });
    </script>
</body>
</html>
