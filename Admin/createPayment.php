<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {
  $transactionDate = $_POST['transactionDate'];
  $collectedBy = $_POST['collectedBy'];
  $feeType = $_POST['feeType'];
  $amountTotal = $_POST['amountTotal'];
  $amountPaying = $_POST['amountPaying'];
  $amountWillPay = $_POST['amountWillPay'];
  $studentId = $_POST['studentId'];
  $semesterName = $_POST['semesterName'];

  $query = mysqli_query($conn, "INSERT INTO payment (transactionDate, collectedBy, feeType, amountTotal, amountPaying, amountWillPay, studentId, semesterName) 
                                VALUES ('$transactionDate', '$collectedBy', '$feeType', '$amountTotal', '$amountPaying', '$amountWillPay', '$studentId', '$semesterName')");

  if ($query) {
    echo "<script type='text/javascript'>
            alert('Payment Details Added Successfully!');
            window.location = ('createPayment.php');
          </script>";
  } else {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error occurred while saving payment details!</div>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo.jpg" rel="icon">
  <title>Add Payment</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
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
            <h1 class="h4 mb-0 text-gray-800">Add Payment Details</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Payment Details</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Payment Details</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Transaction Date<span class="text-danger ml-2">*</span></label>
                        <input type="date" class="form-control" name="transactionDate" required>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Collected By<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="collectedBy" required>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Fee Type<span class="text-danger ml-2">*</span></label>
                        <select class="form-control" name="feeType" required>
                          <option value="" disabled selected>Select Fee Type</option>
                          <option value="Admission Fee">Admission Fee</option>
                          <option value="Campus Development Fee">Campus Development Fee</option>
                          <option value="Extra Curriculam Fee">Extra Curriculam Fee</option>
                          <option value="Lab Fee">Lab Fee</option>
                          <option value="Library Fee">Library Fee</option>
                          <option value="Rover Scout & BNCC Fee">Rover Scout & BNCC Fee</option>
                          <option value="Semester Fee">Semester Fee</option>
                          <option value="Student Life Insurance">Student Life Insurance</option>
                          <option value="Smart Card">Smart Card</option>
                          <option value="Tuition Fee">Tuition Fee</option>
                        </select>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Total Amount<span class="text-danger ml-2">*</span></label>
                        <input type="number" class="form-control" name="amountTotal" required>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Amount Paying<span class="text-danger ml-2">*</span></label>
                        <input type="number" class="form-control" name="amountPaying" required>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Amount Will Pay<span class="text-danger ml-2">*</span></label>
                        <input type="number" class="form-control" name="amountWillPay" required>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Student ID<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="studentId" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="semesterName">Semester Name</label>
                        <select class="form-control" id="semesterName" name="semesterName" required>
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
                    <button type="submit" name="save" class="btn btn-primary">Save</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->
        </div>
        <!---Container Fluid-->
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
</body>

</html>