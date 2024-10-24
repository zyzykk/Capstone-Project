<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back - Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f2f5;
        }
        .container {
            display: flex;
            width: 800px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .image-section {
            flex: 1;
            background-color: #f0f2f5;
        }
        .placeholder-image {
            width: 100%;
            height: 100%;
            background-image: url('Beautiful Pic.jpg');
            background-size: cover;
            background-position: center;
        }
        .form-section {
            flex: 1;
            padding: 40px;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        p {
            color: #666;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 35px;
            background: none;
            border: none;
            cursor: pointer;
        }
        .login-btn {
            width: 100%;
            padding: 10px;
            background-color: #6c63ff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-btn:hover {
            background-color: #5a52d5;
        }
        .forgot-password {
            float: right;
            color: #6c63ff;
            text-decoration: none;
        }
        .signup-link {
            text-align: center;
            margin-top: 20px;
        }
        .signup-link a {
            color: #6c63ff;
            text-decoration: none;
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
                header("Location: http://localhost/Capstone Project/homepage.php");
            } else {
                header("Location: http://localhost/Capstone Project/ApplicationList.html");
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
        <div class="image-section">
            <div class="placeholder-image"></div>
        </div>
        <div class="form-section">
            <h1>Welcome back!</h1>
            <p>Enter to get unlimited access to data & information.</p>
            <?php
            if (isset($_SESSION['error'])) {
                echo "<div class='error-message'>" . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']); // Remove error after displaying
            }
            ?>
            <form id="loginForm" action="login.php" method="post">
                <div class="form-group">
                    <label for="userId">User ID</label>
                    <input type="text" id="userId" name="userId" placeholder="Enter your User ID" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter password" required>
                    <button type="button" id="togglePassword" class="toggle-password">👁️</button>
                </div>
                <div id="passwordError" class="error-message"></div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="remember" id="remember">
                        Remember me
                    </label>
                    <a href="#" class="forgot-password">Forgot your password?</a>
                </div>
                <button type="submit" class="login-btn">Log in</button>
            </form>
            <p class="signup-link">Don't have an account? <a href="http://localhost/Capstone Project/signup.php">Sign up</a></p>
        </div>
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


