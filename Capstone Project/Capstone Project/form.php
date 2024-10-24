<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoboPay - Payment Advice Submission Form</title>
    <link rel="stylesheet" href="payment-advice-form.css">
<style>:root {
    --primary-color: #260E69;
    --secondary-color: #1F41BB;
    --background-color: #F2F2F7;
    --text-color: #333333;
    --input-bg-color: #F9FAFB;
    --input-border-color: #D1D5DB;
}

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: var(--background-color);
    color: var(--text-color);
}

header {
    background-color: var(--primary-color);
    color: white;
    padding: 20px 40px;

    height:200px;
}

.headercontainer{
    height:70px;    
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.headername{
    text-align: center;
    padding-left:10px;
    padding-top:auto;
    padding-bottom:auto;
    font-size:27px;
}

.websitename {
    display: flex;
    align-items: center;
    flex-direction: row;
}

.logo{
    height: 60px;
}

nav a {
    color: white;
    text-decoration: none;
    margin-left: 20px;
    font-size:20px;
    font-weight:bold;
}


main {
    padding: 2rem;
    margin-top:-170px;
}

.form-container {
    background-color: white;
    border-radius: 30px;
    padding: 2rem;
    max-width: 80%;
    margin: 0 auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: black;
    margin-bottom: 50px;
    margin-top:0px;
}

.form-group {
    margin-bottom: 1.5rem;
    margin-right:25%;
    margin-left:25%;
    justify-content: center;
    max-width:550px;
}

label {
    display: block;
    margin-bottom: 0.5rem;
    font-size: 18px;
    font-weight:bold;
}

input, select, textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid var(--input-border-color);
    border-radius: 15px;
    background-color: var(--input-bg-color);
    font-size: 1rem;
    box-sizing: border-box;
}

select {
    appearance: none;
    background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23131313%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E');
    background-repeat: no-repeat;
    background-position: right 0.7rem top 50%;
    background-size: 0.65rem auto;
}

textarea {
    resize: vertical;
    min-height: 100px;
    font-family: Arial, sans-serif;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 15px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
    width:100%;
    margin:auto;
    max-width:550px;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: #2E0A82;
}

.btn-secondary {
    background-color: var(--secondary-color);
    color: white;
}

.btn-secondary:hover {
    background-color: #3651D4;
}
</style>

</head>
<body>
    <header>
        <div class="headercontainer">
            <div class="websitename">
                <div><img src="Images/robopay-mascot.png" alt="RoboPay Logo" class="logo"> </div>
                <div class="headername"><b>RoboPay</b></div>
            </div>
            <nav>
                <a href="http://localhost/Capstone Project/Employee.php">Home</a>
                <a href="http://localhost/Capstone Project/form.php" class="active">New PAF Submission</a>
            </nav>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h1><div class="title">Payment Advice Submission Form</div></h1>
            <form id="paymentAdviceForm" action="submit_form.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="employeeId">Employee ID</label>
                    <input type="text" id="employeeId" name="employeeId" placeholder="Enter your ID" required>
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <select id="department" name="department" required>
                        <option value="">Select Department</option>
                        <option value="Finance">Finance</option>
                        <option value="HR">HR</option>
                        <option value="IT">IT</option>
                        <option value="Marketing">Marketing</option>
                        <option value="Sales">Sales</option>
                        <option value="Operation">Operation</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="recipientCompany">Company Name (Recipient)</label>
                    <input type="text" id="recipientCompany" name="recipientCompany" placeholder="Enter recipient company name" required>
                </div>
                <div class="form-group">
                    <label for="paymentDate">Payment Date</label>
                    <input type="date" id="paymentDate" name="paymentDate" required>
                </div>
                <div class="form-group">
                    <label for="paymentAmount">Payment Amount</label>
                    <input type="number" id="paymentAmount" name="paymentAmount" step="0.01" placeholder="Enter amount" required>
                </div>
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <select id="currency" name="currency" required>
                        <option value="">Select Currency</option>
                        <option value="USD">MYR</option>
                        <option value="EUR">USD</option>
                        <option value="GBP">SGD</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bankName">Bank Name</label>
                    <input type="text" id="bankName" name="bankName" placeholder="Enter bank name" required>
                </div>
                <div class="form-group">
                    <label for="entryReference">Entry Reference</label>
                    <input type="text" id="entryReference" name="entryReference" placeholder="Enter entry reference" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="Enter payment description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="invoice">Upload Invoice (optional)</label>
                    <input type="file" id="invoice" name="invoice" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Confirm & Submit</button>
                </div>
            </form>
        </div>
    </main>
<script src="form.js"></script>
</body>
</html>
