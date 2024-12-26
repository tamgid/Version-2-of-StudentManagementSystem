<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Get student ID from session
$studentId = $_SESSION['studentId'];
$query_student_details = "
    SELECT * 
    FROM student
    WHERE studentId = '$studentId'
";
$rs_student_details = $conn->query($query_student_details);

if ($rs_student_details->num_rows > 0) {
    $student = $rs_student_details->fetch_assoc();
} else {
    echo "<p class='text-danger'>Student details not found.</p>";
    exit;
}

// Handle GET request for payments
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['semesterName'])) {
    $semesterName = $_GET['semesterName'];
    $collectedByFilter = $_GET['collectedByFilter'] ?? '';
    $feeTypeFilter = $_GET['feeTypeFilter'] ?? '';
    $page = $_GET['page'] ?? 1;
    $rowsPerPage = 10;
    $offset = ($page - 1) * $rowsPerPage;

    $whereClause = "WHERE studentId = '$studentId'";
    if ($semesterName !== 'All') {
        $whereClause .= " AND semesterName = '$semesterName'";
    }
    if (!empty($collectedByFilter)) {
        $whereClause .= " AND collectedBy LIKE '%$collectedByFilter%'";
    }
    if (!empty($feeTypeFilter)) {
        $whereClause .= " AND feeType LIKE '%$feeTypeFilter%'";
    }

    // Count total rows
    $countQuery = "SELECT COUNT(*) as total FROM payment $whereClause";
    $countResult = $conn->query($countQuery);
    $totalRows = $countResult->fetch_assoc()['total'];

    // Fetch payment details
    $query_payments = "
        SELECT transactionDate, collectedBy, feeType, amountTotal, amountPaying, amountWillPay, semesterName
        FROM payment
        $whereClause
        LIMIT $rowsPerPage OFFSET $offset
    ";
    $rs_payments = $conn->query($query_payments);

    $payments_html = "";
    if ($rs_payments->num_rows > 0) {
        while ($payment = $rs_payments->fetch_assoc()) {
            $payments_html .= "
                <tr>
                    <td>{$payment['transactionDate']}</td>
                    <td>{$payment['collectedBy']}</td>
                    <td>{$payment['feeType']}</td>
                    <td>{$payment['amountTotal']}</td>
                    <td>{$payment['amountPaying']}</td>
                    <td>{$payment['amountWillPay']}</td>
                    <td>{$payment['semesterName']}</td>
                </tr>
            ";
        }
    } else {
        $payments_html = "<tr><td colspan='7'>No payments found</td></tr>";
    }

    $pagination_html = "
        <button class='btn btn-primary btn-sm' onclick='fetchPayments(\"$semesterName\", $page - 1)' " . ($page <= 1 ? "disabled" : "") . ">Previous</button>
        <button class='btn btn-primary btn-sm' onclick='fetchPayments(\"$semesterName\", $page + 1)' " . (($page * $rowsPerPage) >= $totalRows ? "disabled" : "") . ">Next</button>
        <span class='ml-3'>Showing " . min($totalRows, ($offset + 1)) . " to " . min($totalRows, ($offset + $rowsPerPage)) . " of $totalRows rows</span>
    ";

    echo json_encode(['payments_html' => $payments_html, 'pagination_html' => $pagination_html]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="img/logo.jpg" rel="icon">
    <title>View Payment</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include "Includes/sidebar.php"; ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php include "Includes/topbar.php"; ?>
                <!-- Topbar -->

                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h4 class="mb-0" style="color: #002D5B;">View Payment Details</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Payment Details</li>
                        </ol>
                    </div>

                    <!-- Input Field -->
                    <div class="d-flex justify-content-between mb-4">
                        <div style="width: 40%;">
                            <select id="semesterName" class="form-control" style="border: none; border-bottom: 2px solid #002D5B; background-color: transparent;">
                                <option value="" disabled selected>Select a semester</option>
                                <!-- Options for 2023 -->
                                <option value="Winter-2023">Winter-2023</option>
                                <option value="Spring-2023">Spring-2023</option>
                                <option value="Summer-2023">Summer-2023</option>
                                <option value="Fall-2023">Fall-2023</option>
                                <!-- Options for 2024 -->
                                <option value="Winter-2024">Winter-2024</option>
                                <option value="Spring-2024">Spring-2024</option>
                                <option value="Summer-2024">Summer-2024</option>
                                <option value="Fall-2024">Fall-2024</option>
                                <!-- Options for 2025 -->
                                <option value="Winter-2025">Winter-2025</option>
                                <option value="Spring-2025">Spring-2025</option>
                                <option value="Summer-2025">Summer-2025</option>
                                <option value="Fall-2025">Fall-2025</option>
                            </select>
                        </div>
                    </div>

                    <!-- Payment Table -->
                    <div>
                        <h5 class="mb-3" style="color: #002D5B;">Payment Details</h5>
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered">
                                <thead style="background-color: #6dbaa0; color: white;">
                                    <tr>
                                        <th>Transaction Date</th>
                                        <th>
                                            Collected By
                                            <input type="text" id="collectedByFilter" class="form-control form-control-sm" placeholder="Filter">
                                        </th>
                                        <th>
                                            Fee Type
                                            <input type="text" id="feeTypeFilter" class="form-control form-control-sm" placeholder="Filter">
                                        </th>
                                        <th>Total Amount</th>
                                        <th>Amount Paying</th>
                                        <th>Amount Will Pay</th>
                                        <th>Semester Name</th>
                                    </tr>
                                </thead>
                                <tbody id="payment-table-body">
                                    <tr>
                                        <td colspan="7">Select a semester to view payments</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div id="pagination-controls" class="mt-3"></div>
                    </div>

                </div>
            </div>
            <!-- Footer -->
            <?php include "Includes/footer.php"; ?>
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/ruang-admin.min.js"></script>

    <script>
        function fetchPayments(semesterName, page = 1) {
            const collectedByFilter = $('#collectedByFilter').val();
            const feeTypeFilter = $('#feeTypeFilter').val();

            $.get('', {
                semesterName,
                collectedByFilter,
                feeTypeFilter,
                page
            }, function(response) {
                const data = JSON.parse(response);
                $('#payment-table-body').html(data.payments_html);
                $('#pagination-controls').html(data.pagination_html);
            });
        }

        $('#semesterName').on('change', function() {
            const semesterName = $(this).val();
            fetchPayments(semesterName);
        });

        $('#collectedByFilter, #feeTypeFilter').on('input', function() {
            const semesterName = $('#semesterName').val() || 'All';
            fetchPayments(semesterName);
        });
    </script>
</body>

</html>