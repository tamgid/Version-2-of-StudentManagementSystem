<?php
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Get total number of students
$query = "SELECT COUNT(*) as totalStudents FROM student";
$result = $conn->query($query);
$totalStudents = ($result->num_rows > 0) ? $result->fetch_assoc()['totalStudents'] : 0;

// Get total number of unique courses
$query = "SELECT COUNT(DISTINCT courseCode) as totalCourses FROM course";
$result = $conn->query($query);
$totalUniqueCourses = ($result->num_rows > 0) ? $result->fetch_assoc()['totalCourses'] : 0;

// Get total transaction amount
$query = "SELECT SUM(amountPaying) as totalTransaction FROM payment";
$result = $conn->query($query);
$totalTransaction = ($result->num_rows > 0) ? $result->fetch_assoc()['totalTransaction'] : 0;

// Get total number of unique semesters
$query = "SELECT COUNT(DISTINCT semesterName) as totalSemesters FROM semester_course";
$result = $conn->query($query);
$totalSemesters = ($result->num_rows > 0) ? $result->fetch_assoc()['totalSemesters'] : 0;

// Get amountPaying per semester for chart
$semesterNames = [];
$amountPaying = [];

$query = "SELECT semesterName, SUM(amountPaying) as totalAmountPaying FROM payment GROUP BY semesterName";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
  $semesterNames[] = $row['semesterName'];
  $amountPaying[] = $row['totalAmountPaying'];
}
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
  <title>Admin Dashboard</title>
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
            <h1 class="h4 mb-0 text-gray-800">Admin Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Total Students Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 shadow-sm bg-primary text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Students</div>
                      <div class="h5 mb-0 font-weight-bold"><?php echo $totalStudents; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Unique Courses Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 shadow-sm bg-success text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Unique Courses</div>
                      <div class="h5 mb-0 font-weight-bold"><?php echo $totalUniqueCourses; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Transaction Amount Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 shadow-sm bg-warning text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Transaction</div>
                      <div class="h5 mb-0 font-weight-bold"><?php echo number_format($totalTransaction, 2); ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Semesters Card -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100 shadow-sm bg-info text-white">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Unique Semesters</div>
                      <div class="h5 mb-0 font-weight-bold"><?php echo $totalSemesters; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar-alt fa-2x"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Semester Payment Chart -->
          <div class="row mb-3">
            <div class="col-xl-12 col-md-12 mb-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <canvas id="semesterPaymentChart" style="height: 400px;"></canvas>
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
    // Semester Payment Chart Script
    var ctx = document.getElementById('semesterPaymentChart').getContext('2d');
    var semesterPaymentChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($semesterNames); ?>,
        datasets: [{
          label: 'Total Amount Paying',
          data: <?php echo json_encode($amountPaying); ?>,
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
              stepSize: 10000
            }
          }
        }
      }
    });
  </script>
</body>

</html>