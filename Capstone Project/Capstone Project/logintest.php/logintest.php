<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            width: 80%;
            max-width: 900px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }

        .image-section {
            width: 50%;
            background-image: url('path-to-your-image.jpg');
            background-size: cover;
            background-position: center;
        }

        .form-section {
            width: 50%;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        label {
            font-size: 0.9rem;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
        }

        input[type="checkbox"] {
            margin-right: 10px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .remember-forgot a {
            color: #6A67CE;
            text-decoration: none;
            font-size: 0.9rem;
        }

        input[type="submit"] {
            background-color: #6A67CE;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 1rem;
        }

        input[type="submit"]:hover {
            background-color: #574bce;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Image Section -->
        <div class="image-section">
        </div>

        <!-- Form Section -->
        <div class="form-section">
            <h2>Welcome Back!</h2>
            <form action="login.php" method="post" onsubmit="return validateForm()">
                <label for="user_id">User ID</label>
                <input type="text" id="user_id" name="user_id" required placeholder="EXXXXX or MXXXXX">
                
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter password">
                
                <div class="remember-forgot">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="#">Forgot your password?</a>
                </div>
                
                <input type="submit" value="Log In">
            </form>
        </div>
    </div>

    <script>
        function validateForm() {
            const userId = document.getElementById('user_id').value;
            const regex = /^(E\d{5}|M\d{5})$/;

            if (!regex.test(userId)) {
                alert("User ID must be in the format EXXXXX or MXXXXX");
                return false;
            }
            return true;
        }
    </script>

<?php
// login.php

session_start();

// Database connection details
$host = "localhost";
$user = "root";  // Change to your MySQL user
$pass = "";      // Change to your MySQL password
$dbname = "login_system";  // Ensure the database is created

// Create connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hash);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $user_id;
            echo "Login successful! Welcome, " . htmlspecialchars($user_id);
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "User ID not found!";
    }

    $stmt->close();
}
$conn->close();
?>

</body>
</html>
