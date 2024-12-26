<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Get the studentId from the session
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
// Initialize variables
$totalPaid = 0;
$totalDue = 0;
$totalPayable = 0;
$totalCourses = 0;

// Fetch total paid amount
$query = "SELECT SUM(amountPaying) as totalPaid FROM payment WHERE studentId = '$studentId'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $totalPaid = $row['totalPaid'] ?? 0; // Total Paid amount
}

// Fetch the amountWillPay for the last transaction date
$query = "SELECT amountWillPay FROM payment WHERE studentId = '$studentId' ORDER BY transactionDate DESC LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $totalDue = $row['amountWillPay'] ?? 0; // Total Due amount
}

// Calculate total payable
$totalPayable = $totalPaid + $totalDue;

// Fetch the total number of purchased courses for the student
$query = "SELECT COUNT(*) as totalCourses FROM semester_course WHERE studentId = '$studentId'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $totalCourses = $row['totalCourses']; // Total number of purchased courses
}

// Fetch the total amount paid for each fee type
$feeTypes = [];
$feeAmounts = [];

$query = "SELECT feeType, SUM(amountPaying) as totalPaid FROM payment WHERE studentId = '$studentId' GROUP BY feeType";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
  $feeTypes[] = $row['feeType'];
  $feeAmounts[] = $row['totalPaid'];
}

// Fetch CGPA for each semester
$semesterNames = [];
$cgpaValues = [];

// Query to calculate CGPA for each semester
$query = "
    SELECT 
        sc.semesterName,
        SUM(c.credit * sc.gradePoint) / SUM(c.credit) AS semesterCGPA
    FROM 
        semester_course sc
    INNER JOIN 
        course c ON sc.courseId = c.id
    WHERE 
        sc.studentId = '$studentId'
    GROUP BY 
        sc.semesterName
";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
  $semesterNames[] = $row['semesterName'];
  $cgpaValues[] = round($row['semesterCGPA'], 2); // Round CGPA to 2 decimal places
}

// Calculate average CGPA across all semesters
$totalCGPA = array_sum($cgpaValues); // Sum of all semester CGPAs
$numberOfSemesters = count($cgpaValues); // Number of semesters
$averageCGPA = $numberOfSemesters > 0 ? round($totalCGPA / $numberOfSemesters, 2) : 0; // Average CGPA rounded to 2 decimal places
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo.jpg" rel="icon">
  <title>Student Dashboard</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "Includes/sidebar.php"; ?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include "Includes/topbar.php"; ?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h4 mb-0 text-gray-800">Student Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Total Payable Payments Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 shadow-sm bg-primary text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Payable Payments</div>
                      <div class="h5 mb-0 font-weight-bold"><?php echo number_format($totalPayable, 2); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-money-check-alt fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Paid Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 shadow-sm bg-success text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Paid</div>
                      <div class="h5 mb-0 font-weight-bold"><?php echo number_format($totalPaid, 2); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-wallet fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Due Payment Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 shadow-sm bg-danger text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Due Payment</div>
                      <div class="h5 mb-0 font-weight-bold"><?php echo number_format($totalDue, 2); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-exclamation-circle fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Purchased Courses Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 shadow-sm bg-info text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Registered Courses</div>
                      <div class="h5 mb-0 font-weight-bold"><?php echo $totalCourses; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Average CGPA Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 shadow-sm bg-warning text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total CGPA</div>
                      <div class="h5 mb-0 font-weight-bold"><?php echo $averageCGPA; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-chart-line fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Fee Type Bar Chart -->
          <div class="row mb-3">
            <div class="col-xl-12 col-md-12 mb-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <canvas id="feeTypeChart" style="height: 400px;"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- CGPA Bar Chart -->
          <div class="row mb-3">
            <div class="col-xl-12 col-md-12 mb-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <canvas id="cgpaChart" style="height: 400px;"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <?php include 'Includes/footer.php'; ?>
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
  <script src="../vendor/chart.js/Chart.min.js"></script>

  <script>
    // Fee Type Chart Script
    var ctx1 = document.getElementById('feeTypeChart').getContext('2d');
    var feeTypeChart = new Chart(ctx1, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($feeTypes); ?>,
        datasets: [{
          label: 'Amount Paid (in K)',
          data: <?php echo json_encode($feeAmounts); ?>,
          backgroundColor: '#4e73df',
          borderColor: '#4e73df',
          borderWidth: 1,
          barThickness: 50
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 2000
            }
          }
        }
      }
    });

    // CGPA Chart Script
    var ctx2 = document.getElementById('cgpaChart').getContext('2d');
    var cgpaChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($semesterNames); ?>,
        datasets: [{
          label: 'CGPA',
          data: <?php echo json_encode($cgpaValues); ?>,
          backgroundColor: '#1cc88a',
          borderColor: '#1cc88a',
          borderWidth: 1,
          barThickness: 50
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            max: 4, // CGPA scale
            ticks: {
              stepSize: 0.5
            }
          }
        }
      }
    });
  </script>
</body>

</html>