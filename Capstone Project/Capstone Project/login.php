<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoboPay Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        :root {
    --primary-color: #260E69;
    --secondary-color: #1F41BB;
    --accent-color: #CCEDFF;
    --text-color: #FFFFFF;
    --input-bg-color: #F0F0F0;
    --input-text-color: #333333;
}

body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    background-color: var(--primary-color);
    color: var(--text-color);
    height: 100%;
    width: 100%;
    overflow: hidden;
}

.container {
    position: relative;
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
}

header {
    padding: 20px 40px;
}

.websitename {
    display: flex;
    align-items: center;
    flex-direction: row;
    height:70px;
}

.headername{
    text-align: center;
    padding-left:10px;
    padding-top:auto;
    padding-bottom:auto;
    font-size:27px;
}

.logo {
    height: 60px;
}

main {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom:25px;
}

.content-wrapper {
    display: flex;
    justify-content: space-between;
    width: 800px;
    background: linear-gradient(135deg, #3A0CA3 0%, #260E69 100%);
    border-radius: 20px;
    padding: 35px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.login-form {
    width: 50%;
    padding-right: 40px;
}

h1 {
    font-size: 40px;
    margin-bottom:5px;
}

p {
    font-size: 16px;
    margin-bottom: 15px;
    opacity: 0.8;
}

.form-group {
    margin-bottom: 13px;
    position: relative;
}

label {
    display: block;
    margin-bottom: 5px;
    font-size: 14px;
}

.required {
    color: red;
}

input[type="text"],
input[type="password"] {
    width: 95%;
    padding: 12px;
    border: none;
    border-radius: 8px;
    background-color: var(--input-bg-color);
    color: var(--input-text-color);
    font-size: 14px;
}

.forgot-password {
    position: absolute;
    right: 0;
    top: 0;
    color: var(--text-color);
    text-decoration: none;
    font-size: 14px;
}

.login-btn {
    width: 100%;
    padding: 12px;
    background-color: var(--secondary-color);
    color: var(--text-color);
    border: none;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 10px;
}

.login-btn:hover {
    background-color: #3651D4;
}

.signup-link {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
}

.signup-link a {
    color: var(--text-color);
    text-decoration: none;
    font-weight: bold;
}

.welcome-image {
    width: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.image-container {
    background-color: var(--accent-color);
    border-radius: 20px;
    margin: 25px;
    text-align: center;
    width: 100%;
}

.image-container h2 {
    color: var(--primary-color);
    font-size: 24px;
    margin-bottom: 20px;
}

.mascot {
    width: 80%;
    max-width: 180px;
}

.toggle-password {
            position: absolute;
            right: 10px;
            top: 35px;
            background: none;
            border: none;
            cursor: pointer;
}

.error-message {
            color: #ff0000;
            font-size: 16px;
            padding: 10px;
            margin: 10px 0;
            background-color: #ffe6e6;
            border: 1px solid #ff0000;
            border-radius: 5px;
            text-align: center;
            display: none;
        }
    </style>
    <?php
session_start();
require_once 'db_connection.php'; // Ensure db_connection.php connects correctly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $password = $_POST['password'];
    $_SESSION['error'] = "";

    // Validate User ID format
    if (!preg_match('/^[EM]\d{5}$/', $userId)) {
        $_SESSION['error'] = "Invalid User ID format";
        header("Location: http://localhost/Capstone Project/login.php");
        exit();
    }

    $sql = "SELECT * FROM employees WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];

            // Redirect based on User ID prefix
            if (substr($userId, 0, 1) === 'E') {
                header("Location: http://localhost/Capstone Project/Employee.php");
            } else {
                header("Location: http://localhost/Capstone Project/Manager.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Invalid password";
        }
    } else {
        $_SESSION['error'] = "User not found";
    }

    header("Location: http://localhost/Capstone Project/login.php");
    exit();
}
?>
</head>
<body>
    <div class="container">
        <header>
        <div class="websitename">
            <div class="logo"><img src="Images/robopay-mascot.png" alt="RoboPay Logo" class="logo"> </div>
            <div class="headername"><b>RoboPay</b></div>
        </div>
        </header>
        <main>
            <div class="content-wrapper">
                <section class="login-form">
                    <h1>Welcome Back!</h1>
                    <p>Enter to get unlimited access to data & information.</p>
                    <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']); // Remove error after displaying
            }
            ?>
                    <form id="loginForm" action="login.php" method="post">
                        <div class="form-group">
                            <label for="userId">User ID<span class="required">*</span></label>
                            <input type="text" id="userId" name="userId" placeholder="Enter your user ID" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password<span class="required">*</span></label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                            <button type="button" id="togglePassword" class="toggle-password">👁️</button>
                            <a href="#" class="forgot-password"><u>Forgot Password</u></a>
                        </div>
                        <div id="passwordError" class="error-message"></div>
                        <button type="submit" class="login-btn">Log In</button>
                    </form>
                    <p class="signup-link">Don't have Account? <a href="http://localhost/Capstone Project/signup.php"><u>Sign Up</u></a></p>
                </section>
                <section class="welcome-image">
                    <div class="image-container">
                        <h2>Welcome to RoboPay!</h2>
                        <img src="robopay-mascot.png" alt="RoboPay Mascot" class="mascot">
                    </div>
                </section>
            </div>
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const userIdInput = document.getElementById('userId');
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('togglePassword');

            loginForm.addEventListener('submit', function(e) {
                if (!isValidUserId(userIdInput.value)) {
                    alert('Invalid User ID. It should start with E or M followed by 5 numbers.');
                    e.preventDefault();
                }
            });

            togglePasswordButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.textContent = type === 'password' ? '👁️' : '🔒';
            });

            function isValidUserId(userId) {
                const regex = /^[EM]\d{5}$/;
                return regex.test(userId);
            }
        });
    </script>  
</body>
</html>