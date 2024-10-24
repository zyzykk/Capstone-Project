<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-section">
            <h1>Sign Up</h1>
            <form id="signupForm" action="signup.php" method="post">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="jobPosition">Job Position</label>
                    <input type="text" id="jobPosition" name="jobPosition" required>
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" id="department" name="department" required>
                </div>
                <div class="form-group">
                    <label for="userId">User ID</label>
                    <input type="text" id="userId" name="userId" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="login-btn">Sign Up</button>
            </form>
            <p class="signup-link">Already have an account? <a href="http://localhost/Capstone Project/login.php">Log in</a></p>
        </div>
    </div>
    <script src="signup.js"></script>
 <?php
require_once 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $jobPosition = $_POST['jobPosition'];
    $department = $_POST['department'];
    $userId = $_POST['userId'];
    $password = $_POST['password'];

    // Validate User ID format
    if (!preg_match('/^[EM]\d{5}$/', $userId)) {
        die("Invalid User ID format");
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO employees (name, job_position, department, user_id, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $jobPosition, $department, $userId, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: http://localhost/Capstone Project/login.php?signup=success");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
</body>
</html>