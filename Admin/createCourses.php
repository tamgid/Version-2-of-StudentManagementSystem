<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Fetch data from the form
  $semesterName = $_POST['semesterName'];
  $courseCode = $_POST['courseCode'];
  $courseTitle = $_POST['courseTitle'];
  $credit = intval($_POST['credit']);
  $regClearence = $_POST['regClearence'];
  $roomNo = $_POST['roomNo'];
  $noOfDays = intval($_POST['noOfDays']);
  $timeSlot = $_POST['timeSlot'];
  $teacher = $_POST['teacher'];
  $gradePoint = floatval($_POST['gradePoint']);
  $grade = $_POST['grade'];
  $advised = $_POST['advised'];
  $section = $_POST['section'];
  $batch = $_POST['batch'];
  $department = $_POST['department'];
  $programName = $_POST['programName'];
  $studentId = $_POST['studentId'];

  // Insert into the course table
  $insertCourseQuery = "INSERT INTO course (courseCode, courseTitle, credit) VALUES ('$courseCode', '$courseTitle', $credit)";
  if (mysqli_query($conn, $insertCourseQuery)) {
    $courseId = mysqli_insert_id($conn); // Fetch the primary key of the inserted course

    // Insert into the semester_course table
    $insertSemesterCourseQuery = "
      INSERT INTO semester_course (
        regClearence, roomNo, noOfDays, timeSlot, teacher, gradePoint, grade, advised, 
        section, batch, department, programName, semesterName, courseId, studentId
      ) VALUES (
        '$regClearence', '$roomNo', $noOfDays, '$timeSlot', '$teacher', $gradePoint, '$grade', '$advised', 
        '$section', '$batch', '$department', '$programName', '$semesterName', $courseId, '$studentId'
      )";

    if (mysqli_query($conn, $insertSemesterCourseQuery)) {
      echo "<script type='text/javascript'>
        alert('Education Details Added Successfully!');
        window.location = ('createCourses.php');
      </script>";
    } else {
      $statusMsg = "<div class='alert alert-danger'>Error inserting into semester-course table: " . mysqli_error($conn) . "</div>";
    }
  } else {
    $statusMsg = "<div class='alert alert-danger'>Error inserting into course table: " . mysqli_error($conn) . "</div>";
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
  <title>Add Course</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include "Includes/sidebar.php"; ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- Topbar -->
        <?php include "Includes/topbar.php"; ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <h1 class="h4 mb-4 text-gray-800">Add Courses Details</h1>
          <?php if (isset($statusMsg)) echo $statusMsg; ?>
          <div class="card mb-4">
            <div class="card-header">
              <h6 class="m-0 font-weight-bold text-primary">Add Details</h6>
            </div>
            <div class="card-body">
              <form method="post">
                <div class="row">
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
                      <!-- Options for 2026 -->
                      <option value="Winter-2025">Winter-2026</option>
                      <option value="Spring-2025">Spring-2026</option>
                      <option value="Summer-2025">Summer-2026</option>
                      <option value="Fall-2025">Fall-2026</option>
                    </select>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="courseCode">Course Code</label>
                    <input type="text" class="form-control" id="courseCode" name="courseCode" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="courseTitle">Course Title</label>
                    <input type="text" class="form-control" id="courseTitle" name="courseTitle" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="credit">Credit</label>
                    <input type="number" class="form-control" id="credit" name="credit" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="regClearence">Registration Clearance</label>
                    <input type="text" class="form-control" id="regClearence" name="regClearence" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="roomNo">Room Number</label>
                    <input type="text" class="form-control" id="roomNo" name="roomNo" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="noOfDays">Number of Days</label>
                    <input type="number" class="form-control" id="noOfDays" name="noOfDays" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="timeSlot">Time Slot</label>
                    <input type="text" class="form-control" id="timeSlot" name="timeSlot" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="teacher">Teacher</label>
                    <input type="text" class="form-control" id="teacher" name="teacher" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="gradePoint">Grade Point</label>
                    <input type="number" step="0.01" class="form-control" id="gradePoint" name="gradePoint" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="grade">Grade</label>
                    <input type="text" class="form-control" id="grade" name="grade" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="advised">Advised</label>
                    <input type="text" class="form-control" id="advised" name="advised" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="section">Section</label>
                    <input type="text" class="form-control" id="section" name="section" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="batch">Batch</label>
                    <input type="text" class="form-control" id="batch" name="batch" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="department">Department</label>
                    <input type="text" class="form-control" id="department" name="department" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="programName">Program Name</label>
                    <input type="text" class="form-control" id="programName" name="programName" required>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-md-6">
                    <label for="studentId">Student ID</label>
                    <input type="text" class="form-control" id="studentId" name="studentId" required>
                  </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>

          </div>
        </div>
        <!-- End Page Content -->
      </div>
      <!-- Footer -->
      <?php include "Includes/footer.php"; ?>
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>