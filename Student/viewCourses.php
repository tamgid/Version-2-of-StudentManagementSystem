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

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['semesterName'])) {
    $semesterName = $_GET['semesterName'];

    // Fetch courses for the selected semester
    $query_courses = "
    SELECT sc.id AS semester_course_id, sc.regClearence, sc.roomNo, sc.noOfDays, sc.timeSlot, sc.teacher, sc.gradePoint, sc.grade, 
           sc.advised, sc.section, sc.batch, sc.department, sc.programName, sc.semesterName, c.courseCode, c.courseTitle, c.credit
    FROM semester_course sc
    INNER JOIN course c ON sc.courseId = c.id
    WHERE sc.studentId = '$studentId' AND sc.semesterName = '$semesterName'
  ";
    $rs_courses = $conn->query($query_courses);

    $courses_html = "";
    if ($rs_courses->num_rows > 0) {
        while ($course = $rs_courses->fetch_assoc()) {
            $courses_html .= "
        <tr>
          <td>{$course['courseCode']}</td>
          <td>{$course['courseTitle']}</td>
          <td>{$course['credit']}</td>
          <td>{$course['section']}</td>
          <td>{$course['teacher']}</td>
          <td>{$course['advised']}</td>
          <td>{$course['regClearence']}</td>
          <td>
            <button class='btn btn-sm' style='background-color: #6777EF; color: #2D2E32;' onclick='showRoutine({$course['semester_course_id']})'>
              ROUTINE
            </button>
          </td>
        </tr>
      ";
        }
    } else {
        $courses_html = "<tr><td colspan='8'>No courses found for the selected semester</td></tr>";
    }

    echo json_encode(['courses_html' => $courses_html]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['routine_id'])) {
    $routine_id = $_GET['routine_id'];

    // Fetch routine details
    $query_routine = "
    SELECT roomNo, noOfDays, timeSlot, teacher
    FROM semester_course
    WHERE id = '$routine_id'
  ";
    $rs_routine = $conn->query($query_routine);
    $routine = $rs_routine->fetch_assoc();

    echo json_encode($routine);
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
    <title>View Courses</title>
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/ruang-admin.min.css" rel="stylesheet">
    <style>
        /* Custom styles for horizontal scroll */
        .scrollable-table {
            overflow-x: auto;
        }
    </style>
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
                        <h4 class="mb-0" style="color: #002D5B;">View Course Details</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Course Details</li>
                        </ol>
                    </div>

                    <!-- Input Field -->
                    <div class="mb-4">
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

                    <!-- Routine Table -->
                    <div id="routine-container" class="mb-4" style="display: none;">
                        <h5 class="mb-3" style="color: #002D5B;">Routine Details</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead style="background-color: #6dbaa0; color: white;">
                                    <tr>
                                        <th>Room No</th>
                                        <th>No of Days</th>
                                        <th>Time Slot</th>
                                        <th>Teacher</th>
                                    </tr>
                                </thead>
                                <tbody id="routine-table-body">
                                    <tr>
                                        <td colspan="4">Select a course to view the routine</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Course Table -->
                    <div class="mt-4">
                        <h5 class="mb-3" style="color: #002D5B;">Course Details</h5>
                        <div class="scrollable-table">
                            <table class="table table-bordered">
                                <thead style="background-color: #6dbaa0; color: white;">
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Title</th>
                                        <th>Credit</th>
                                        <th>Section</th>
                                        <th>Teacher</th>
                                        <th>Advised</th>
                                        <th>Reg Clearance</th>
                                        <th>Routine</th>
                                    </tr>
                                </thead>
                                <tbody id="course-table-body">
                                    <tr>
                                        <td colspan="8">Select a semester to view courses</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
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
        // Fetch courses based on the selected semester
        $('#semesterName').on('change', function() {
            const semesterName = $(this).val();
            $.get('', {
                semesterName
            }, function(response) {
                const data = JSON.parse(response);
                $('#course-table-body').html(data.courses_html);
                $('#routine-container').hide();
            });
        });

        // Fetch routine details for a specific course
        function showRoutine(routine_id) {
            $.get('', {
                routine_id
            }, function(response) {
                const data = JSON.parse(response);
                $('#routine-table-body').html(`
                    <tr>
                        <td>${data.roomNo}</td>
                        <td>${data.noOfDays}</td>
                        <td>${data.timeSlot}</td>
                        <td>${data.teacher}</td>
                    </tr>
                `);
                $('#routine-container').show();
            });
        }
    </script>
</body>

</html>