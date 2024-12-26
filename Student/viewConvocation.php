<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';
// Fetch all student information using studentId from session
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
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['studentId'];

    // Check if the student has completed 8 unique semesters
    $query_semesters = "
        SELECT DISTINCT semesterName 
        FROM semester_course 
        WHERE studentId = '$studentId'
    ";
    $rs_semesters = $conn->query($query_semesters);
    $uniqueSemesters = $rs_semesters->num_rows;

    if ($uniqueSemesters < 8) {
        $message = "You are not eligible for the convocation.";
    } else {
        // Check if the student already has a convocation entry
        $query_check_convocation = "
            SELECT * FROM convocation 
            WHERE studentId = '$studentId'
        ";
        $rs_check_convocation = $conn->query($query_check_convocation);

        if ($rs_check_convocation->num_rows === 0) {
            // Fetch additional data for insertion
            $departmentQuery = "
                SELECT department, programName 
                FROM semester_course 
                WHERE studentId = '$studentId' 
                LIMIT 1
            ";
            $rs_department = $conn->query($departmentQuery);
            $departmentData = $rs_department->fetch_assoc();

            $studentName = $_SESSION['firstName'] . ' ' . $_SESSION['middleName'] . ' ' . $_SESSION['lastName'];
            $email = $_SESSION['emailAddress'];
            $dob = $_SESSION['dateOfBirth'];
            $fatherName = $_SESSION['fatherName'];
            $motherName = $_SESSION['motherName'];
            $department = $departmentData['department'];
            $programName = $departmentData['programName'];

            // Insert into convocation table
            $insertQuery = "
                INSERT INTO convocation (studentId, studentName, email, dob, fatherName, motherName, department, programName)
                VALUES ('$studentId', '$studentName', '$email', '$dob', '$fatherName', '$motherName', '$department', '$programName')
            ";
            if ($conn->query($insertQuery) === TRUE) {
                $message = "Your convocation information is stored successfully.";
            } else {
                $message = "An error occurred while storing your convocation information.";
            }
        } else {
            $message = "You have already registered for the convocation.";
        }
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
    <title>View Convocation</title>
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
                        <h4 class="mb-0" style="color: #002D5B;">Convocation Registration</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Convocation Registration</li>
                        </ol>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Enter Student ID</h6>
                                </div>
                                <div class="card-body">
                                    <?php if (isset($message)) { ?>
                                        <div class="alert alert-info text-center">
                                            <?php echo $message; ?>
                                        </div>
                                    <?php } ?>
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label for="studentId">Student ID</label>
                                            <input type="text" class="form-control" id="studentId" name="studentId" placeholder="Enter your Student ID" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block">Check Eligibility</button>
                                    </form>
                                </div>
                            </div>
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
</body>

</html>