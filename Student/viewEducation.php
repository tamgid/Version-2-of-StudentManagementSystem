<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Get student ID from session
$studentId = $_SESSION['studentId'];

// Fetch education details for the student
$query_education = "
SELECT degree, degreeName, institution, universityBoard, passingYear, gradeClassDivision, marksCGPA, remarks 
FROM education 
WHERE studentId = '$studentId'
";
$rs_education = $conn->query($query_education);
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="img/logo.jpg" rel="icon">
    <title>View Education</title>
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
                        <h4 class="mb-0" style="color: #002D5B;">View Education Details</h4>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Education Details</li>
                        </ol>
                    </div>

                    <div class="mt-4">
                        <h5 class="mb-3" style="color: #002D5B;">Education Details</h5>
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered table-hover">
                                <thead style="background-color: #6dbaa0; color: white;">
                                    <tr>
                                        <th>Degree</th>
                                        <th>Degree Name</th>
                                        <th>Institution</th>
                                        <th>University/Board</th>
                                        <th>Passing Year</th>
                                        <th>Grade/Class</th>
                                        <th>Marks/CGPA</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($rs_education->num_rows > 0) {
                                        while ($education = $rs_education->fetch_assoc()) {
                                            echo "
                        <tr>
                            <td>{$education['degree']}</td>
                            <td>{$education['degreeName']}</td>
                            <td>{$education['institution']}</td>
                            <td>{$education['universityBoard']}</td>
                            <td>{$education['passingYear']}</td>
                            <td>{$education['gradeClassDivision']}</td>
                            <td>{$education['marksCGPA']}</td>
                            <td>{$education['remarks']}</td>
                        </tr>
                        ";
                                        }
                                    } else {
                                        echo "
                    <tr>
                        <td colspan='8' class='text-center'>No education details found for the student</td>
                    </tr>
                    ";
                                    }
                                    ?>
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
</body>

</html>