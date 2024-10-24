<?php
session_start();
require_once 'db_connection.php';
require_once 'db_connection2.php';

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/Capstone Project/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Function to get application counts and total amounts
function getApplicationStats($conn, $user_id) {
    $stats = [
        'pending' => ['count' => 0, 'amount' => 0],
        'approved' => ['count' => 0, 'amount' => 0],
        'rejected' => ['count' => 0, 'amount' => 0]
    ];

    $sql = "SELECT status, COUNT(*) as count, SUM(payment_amount) as total_amount 
            FROM payment_advices 
            WHERE employee_id = ?
            GROUP BY status";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $status = strtolower($row['status']);
        if (isset($stats[$status])) {
            $stats[$status]['count'] = $row['count'];
            $stats[$status]['amount'] = $row['total_amount'];
        }
    }

    return $stats;
}

// Function to get application list with search and filter
function getApplicationList($conn, $user_id, $search = '', $filters = []) {
    $sql = "SELECT application_no, payment_date, recipient_company, payment_amount, status, invoice_file 
            FROM payment_advices 
            WHERE employee_id = ?";
    
    $params = [$user_id];
    $types = "s";

    if (!empty($search)) {
        $sql .= " AND (application_no LIKE ? OR recipient_company LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
        $types .= "ss";
    }

    if (!empty($filters['status'])) {
        $sql .= " AND status IN (" . implode(',', array_fill(0, count($filters['status']), '?')) . ")";
        $params = array_merge($params, $filters['status']);
        $types .= str_repeat("s", count($filters['status']));
    }

    $sql .= " ORDER BY payment_date " . ($filters['sort'] == 'asc' ? 'ASC' : 'DESC');

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Use $conn2 for application data
$stats = getApplicationStats($conn2, $user_id);

// Handle search and filter
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filters = [
    'status' => isset($_GET['status']) ? $_GET['status'] : [],
    'sort' => isset($_GET['sort']) ? $_GET['sort'] : 'desc',
];

$applications = getApplicationList($conn2, $user_id, $search, $filters);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RoboPay</title>
    <style>
            body, html{
    margin: 0px;
    padding: 0px;
    font-family: Arial, sans-serif;
    background-color: #f2f2f7;
    }

    header {
        background-color: #260E69;
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

    .container {
        background-color: white;
        border-radius: 20px;
        margin: -110px 45px 0px;
        padding: 40px;
        position: relative;
        min-height: 300px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .content {
        margin-top: auto;
    }
    .overview-header {
        text-align: center;
        margin-bottom: 14px;
    }
    .overview-header h2 {
        margin: 0;
        font-size: 38px;
    }
    .date {
        text-align: right;
        margin-bottom: 16px;
        color: black;
        font-size: 14px;
    }
    .cards {
        display: flex;
        justify-content: space-between;
        gap: 40px;
    }
    .card {
        flex: 1;
        padding: 20px;
        border-radius: 20px;
        text-align: center;
        border: none;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .card:hover {
        transform: scale(1.05);
    }
    .card.approved {
        background-color: #b7e4c7;
    }
    .card.pending {
        background-color: #fbd776;
    }
    .card.rejected {
        background-color: #e0e0e0;
    }
    .card h3 {
        margin: 0;
        font-size: 22px;
        color: black;
    }
    .card .number {
        font-size: 64px;
        font-weight: bold;
        margin: 8px 0;
    }
    .card .amount {
        font-size: 26px;
        font-weight: bold;
    }
    .view-all {
        display: block;
        width: 200px;
        height: 45px;
        margin: 32px auto 0;
        padding: 12px;
        background-color: #260e69;
        color: white;
        text-align: center;
        text-decoration: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: bold;
        border: none;
        cursor: pointer;
        transition: transform 0.2s;
    } 
    .view-all:hover {
        transform: scale(1.05);
    }
    .applicationlist {
    margin: 45px 45px;
    background-color: white;
    border-radius: 20px;
    padding: 15px 32px 30px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1 {
        text-align: center;
        margin-bottom: 30px;
    }
    .search-bar {
        display: flex;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .search-bar input {
        flex-grow: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    .search-bar button {
        background-color: #4a0e78;
        color: white;
        border: none;
        padding: 8px 16px;
        margin-left: 8px;
        border-radius: 4px;
        cursor: pointer;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 16px;
    }
    th, td {
        text-align: center;
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }
    th {
        background-color: #f2f2f2;
    }
    .pendingsection{
        padding: auto 20px;
    }
    .status {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 14px;
    }
    .drafted{
        background-color: #ccedff;
    }
    .pending {
        background-color: #fbd776;
    }
    .approved {
        background-color: #b7e4c7;
    }
    .rejected {
        background-color: #e0e0e0;
    }
    .download-icon {
        width: 20px;
        cursor: pointer;
    }
    .filter-box {
            display: none;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-top: 10px;
            border-radius: 4px;
        }

        .filter-box h3 {
            margin-top: 0;
        }

        .filter-box label {
            display: block;
            margin-bottom: 5px;
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
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>
    <!--End Header-->
    <!--Start Landing-->
    <div class="container">
        <div class="overview-header">
            <h2>Overview</h2>
        </div>
        <p class="date">Up to Date: <?php echo date('d/m/Y'); ?></p>
        <div class="cards">
            <!--Card 1: Pending-->
            <button class="card pending" onclick="filterAndJump('Pending')">
                <h3>Pending</h3>
                <p>Total PAF</p>
                <div class="number"><?php echo $stats['pending']['count']; ?></div>
                <p>Total Amount</p>
                <div class="amount">RM <?php echo number_format($stats['pending']['amount'], 2); ?></div>
            </button>
            <!--Card 2: Approved-->
            <button class="card approved" onclick="filterAndJump('Approved')">
                <h3>Approved</h3>
                <p>Total PAF</p>
                <div class="number"><?php echo $stats['approved']['count']; ?></div>
                <p>Total Amount</p>
                <div class="amount">RM <?php echo number_format($stats['approved']['amount'], 2); ?></div>
            </button>
            <!--Card 3: Rejected-->
            <button class="card rejected" onclick="filterAndJump('Rejected')">
                <h3>Rejected</h3>
                <p>Total PAF</p>
                <div class="number"><?php echo $stats['rejected']['count']; ?></div>
                <p>Total Amount</p>
                <div class="amount">RM <?php echo number_format($stats['rejected']['amount'], 2); ?></div>
            </button>
        </div>
        <button class="view-all" onclick="location.href='#applicationlist'">View All</button>
    </div>
    <!--End Landing-->
    <!--Start Application List-->
    <div class="applicationlist" id="applicationlist">
        <h1>Application List</h1>
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search" value="<?php echo htmlspecialchars($search); ?>">
            <button id="filterBtn">FILTER</button>
        </div>
        <div id="filterBox" class="filter-box">
            <form id="filterForm">
                <h3>Status</h3>
                <?php
                $statuses = ['Approved', 'Rejected', 'Pending'];
                foreach ($statuses as $status) {
                    $checked = in_array($status, $filters['status']) ? 'checked' : '';
                    echo "<label><input type='checkbox' name='status[]' value='$status' $checked> $status</label>";
                }
                ?>
                <h3>Sort by Date</h3>
                <label>
                    <input type="radio" name="sort" value="desc" <?php echo $filters['sort'] == 'desc' ? 'checked' : ''; ?>> Newest to Oldest
                </label>
                <label>
                    <input type="radio" name="sort" value="asc" <?php echo $filters['sort'] == 'asc' ? 'checked' : ''; ?>> Oldest to Newest
                </label>
            </form>
        </div>
        <!--List-->
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Date Created</th>
                        <th>Invoice No.</th>
                        <th>Business Partner</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody id="applicationTableBody">
                    <?php foreach ($applications as $app): ?>
                    <tr>
                        <td><?php echo date('d/m/Y', strtotime($app['payment_date'])); ?></td>
                        <td><?php echo $app['application_no']; ?></td>
                        <td><?php echo $app['recipient_company']; ?></td>
                        <td>RM <?php echo number_format($app['payment_amount'], 2); ?></td>
                        <td><span class="status <?php echo strtolower($app['status']); ?>"><?php echo $app['status']; ?></span></td>
                        <td>
                            <?php if ($app['invoice_file']): ?>
                                <a href="uploads/<?php echo $app['invoice_file']; ?>" target="_blank">
                                    <img src="Images/pdf-icon.png" alt="PDF" class="download-icon">   
                                </a>
                            <?php endif; ?>
                            <img src="Images/download-icon.png" alt="Download" class="download-icon">
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!--End Application List-->

    <script>
        // Toggle filter box
        document.getElementById('filterBtn').addEventListener('click', function() {
            var filterBox = document.getElementById('filterBox');
            filterBox.style.display = filterBox.style.display === 'none' ? 'block' : 'none';
        });

        // Handle search and filter
        function updateResults() {
            var filterBox = document.getElementById('filterBox');
            filterBox.style.display = 'block';

            var searchTerm = document.getElementById('searchInput').value.toLowerCase();
            var statusFilters = Array.from(document.querySelectorAll('input[name="status[]"]:checked')).map(el => el.value);
            var sortOrder = document.querySelector('input[name="sort"]:checked').value;
            var rows = document.getElementById('applicationTableBody').getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var invoiceNo = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
                var businessPartner = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
                var status = rows[i].getElementsByTagName('td')[4].textContent.trim();
                var date = new Date(rows[i].getElementsByTagName('td')[0].textContent.split('/').reverse().join('-'));

                var matchesSearch = invoiceNo.includes(searchTerm) || businessPartner.includes(searchTerm);
                var matchesStatus = statusFilters.length === 0 || statusFilters.includes(status);

                if (matchesSearch && matchesStatus) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none";
                }
            }

            // Sort the visible rows
            var sortedRows = Array.from(rows)
                .filter(row => row.style.display !== "none")
                .sort((a, b) => {
                    var dateA = new Date(a.getElementsByTagName('td')[0].textContent.split('/').reverse().join('-'));
                    var dateB = new Date(b.getElementsByTagName('td')[0].textContent.split('/').reverse().join('-'));
                    return sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
                });

            var tbody = document.getElementById('applicationTableBody');
            sortedRows.forEach(row => tbody.appendChild(row));
        }

        // Add event listeners
        document.getElementById('searchInput').addEventListener('input', updateResults);
        document.querySelectorAll('input[name="status[]"], input[name="sort"]').forEach(function(el) {
            el.addEventListener('change', updateResults);
        });

        // Initial update
        updateResults();

        function filterAndJump(status) {
            // Uncheck all status checkboxes
            document.querySelectorAll('input[name="status[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });

            // Check the checkbox for the clicked status
            document.querySelector(`input[name="status[]"][value="${status}"]`).checked = true;

            // Update the results
            updateResults();

            // Jump to the application list
            document.getElementById('applicationlist').scrollIntoView({behavior: 'smooth'});
        }
    </script>
</body>
</html>