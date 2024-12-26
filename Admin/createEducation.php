<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {

  $degree = $_POST['degree'];
  $degreeName = $_POST['degreeName'];
  $institution = $_POST['institution'];
  $universityBoard = $_POST['universityBoard'];
  $passingYear = $_POST['passingYear'];
  $gradeClassDivision = $_POST['gradeClassDivision'];
  $marksCGPA = $_POST['marksCGPA'];
  $remarks = $_POST['remarks'];
  $studentId = $_POST['studentId'];

  $query = mysqli_query($conn, "INSERT INTO education (degree, degreeName, institution, universityBoard, passingYear, gradeClassDivision, marksCGPA, remarks, studentId) 
                                VALUES ('$degree', '$degreeName', '$institution', '$universityBoard', '$passingYear', '$gradeClassDivision', '$marksCGPA', '$remarks', '$studentId')");

  if ($query) {
    echo "<script type='text/javascript'>
            alert('Education Details Added Successfully!');
            window.location = ('createEducation.php');
          </script>";
  } else {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
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
  <title>Add Education</title>
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
            <h1 class="h4 mb-0 text-gray-800">Add Education Details</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Education Details</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Education Details</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post">
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Degree<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="degree" required>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Degree Name<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="degreeName" required>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Institution<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="institution" required>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">University/Board<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="universityBoard" required>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Passing Year<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="passingYear" required>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Grade/Class/Division<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="gradeClassDivision" required>
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Marks/CGPA<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="marksCGPA" required>
                      </div>
                      <div class="col-xl-6">
                        <label class="form-control-label">Remarks</label>
                        <input type="text" class="form-control" name="remarks">
                      </div>
                    </div>
                    <div class="form-group row mb-3">
                      <div class="col-xl-6">
                        <label class="form-control-label">Student ID<span class="text-danger ml-2">*</span></label>
                        <input type="text" class="form-control" name="studentId" required>
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