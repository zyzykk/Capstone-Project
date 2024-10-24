<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoboPay Sign Up</title>
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
            padding-bottom:10px;
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
            margin-bottom: 25px;
        }

        .content-wrapper {
            display: flex;
            justify-content: space-between;
            width: 800px;
            background: linear-gradient(135deg, #3A0CA3 0%, #260E69 100%);
            border-radius: 20px;
            padding: 30px;
            padding-top:0px;
            padding-bottom:10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .signup-form {
            width: 50%;
            padding-right: 40px;
        }

        h1 {
            font-size: 35px;
            margin-bottom: 5px;
        }

        p {
            font-size: 16px;
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .form-group {
            margin-bottom: 13px;
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
                <section class="signup-form">
                    <h1>Create Your Account</h1>
                    <p>Join us for unlimited access to RoboPay features.</p>
                    <form id="signupForm" action="signup.php" method="post">
                        <div class="form-group">
                            <label for="name">Name<span class="required">*</span></label>
                            <input type="text" id="name" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="jobPosition">Job Position<span class="required">*</span></label>
                            <input type="text" id="jobPosition" name="jobPosition" placeholder="Enter your job position" required>
                        </div>
                        <div class="form-group">
                            <label for="department">Department<span class="required">*</span></label>
                            <input type="text" id="department" name="department" placeholder="Enter your department" required>
                        </div>
                        <div class="form-group">
                            <label for="userId">User ID<span class="required">*</span></label>
                            <input type="text" id="userId" name="userId" placeholder="Enter your user ID" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password<span class="required">*</span></label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="login-btn">Sign Up</button>
                    </form>
                    <p class="signup-link">Already have an account? <a href="http://localhost/Capstone Project/login.php"><u>Log In</u></a></p>
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
    <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $jobPosition = $_POST['jobPosition'];
    $department = $_POST['department'];
    $userId = $_POST['userId'];
    $password = $_POST['password'];

    require_once 'db_connection.php';

    // Check if userId already exists in the database
    $checkUserId = "SELECT * FROM employees WHERE user_id='$userId'";
    $result = $conn->query($checkUserId);

    if ($result->num_rows > 0) {
        // Alert if the User ID already exists
        echo '<script>alert("User ID already exists! Please choose another one.")</script>';
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        // Insert new user data into the database
        $sql = "INSERT INTO employees (name, job_position, department, user_id, password) 
                VALUES ('$name', '$jobPosition', '$department', '$userId', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            echo '<script>alert("Sign up successful! Please log in.")</script>';
            echo '<script>window.location.href = "login.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
    }
?>
    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var userId = document.getElementById('userId').value;

            // Validate User ID format (Manager or Employee)
            var userIdPattern = /^[EM]\d{5}$/;
            if (!userIdPattern.test(userId)) {
                alert("User ID must start with 'E' or 'M' followed by 5 digits.");
                event.preventDefault();  // Prevent form submission
            }

            // Validate password strength
            if (password.length < 5) {
                alert("Password must be at least 5 characters long.");
                event.preventDefault();  // Prevent form submission
            }
        });
    </script>
    
</body>
</html>
