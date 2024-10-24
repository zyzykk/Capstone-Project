<?php
session_start();

// Include the database connection file
require_once 'db_connection2.php';

// Function to get the next application number
function getNextApplicationNumber($conn2) {
    $sql = "SELECT MAX(CAST(SUBSTRING(application_no, 4) AS UNSIGNED)) as max_num FROM payment_advices";
    $result = $conn2->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        $nextNum = $row['max_num'] + 1;
    } else {
        $nextNum = 1;
    }
    return 'PA-' . str_pad($nextNum, 6, '0', STR_PAD_LEFT);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = $_POST['employeeId'];
    $department = $_POST['department'];
    $recipientCompany = $_POST['recipientCompany'];
    $paymentDate = $_POST['paymentDate'];
    $paymentAmount = $_POST['paymentAmount'];
    $currency = $_POST['currency'];
    $bankName = $_POST['bankName'];
    $entryReference = $_POST['entryReference'];
    $description = $_POST['description'];

    // Generate the next application number
    $applicationNo = getNextApplicationNumber($conn2);

    // File upload handling
    $invoiceFileName = null;
    if (isset($_FILES['invoice']) && $_FILES['invoice']['error'] == 0) {
        $allowed = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png');
        $filename = $_FILES['invoice']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (in_array($ext, $allowed)) {
            $uploadDir = __DIR__ . '/uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $invoiceFileName = $applicationNo . '.' . $ext;
            $uploadPath = $uploadDir . $invoiceFileName;
            if (!move_uploaded_file($_FILES['invoice']['tmp_name'], $uploadPath)) {
                $_SESSION['error_message'] = "Failed to upload file. Error: " . error_get_last()['message'];
                header("Location: http://localhost/Capstone Project/form.php");
                exit();
            }
        }
    }

    $status = "Pending";

    // Use prepared statement to prevent SQL injection
    $sql = "INSERT INTO payment_advices (application_no, employee_id, department, recipient_company, payment_date, payment_amount, currency, bank_name, entry_reference, description, invoice_file, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn2->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn2->error);
    }

    $stmt->bind_param("sssssdssssss", $applicationNo, $employeeId, $department, $recipientCompany, $paymentDate, $paymentAmount, $currency, $bankName, $entryReference, $description, $invoiceFileName, $status);

    if ($stmt->execute()) {
        echo "<script>
                alert('Payment advice submitted successfully. Application Number: " . $applicationNo . "');
                window.location.href = 'http://localhost/Capstone Project/Employee.php';
              </script>";
        exit();
    } else {
        $_SESSION['error_message'] = "Error: " . $stmt->error;
        header("Location: http://localhost/Capstone Project/form.php");
        exit();
    }

    $stmt->close();
    $conn2->close();
}
?>