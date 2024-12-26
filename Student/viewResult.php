<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

// Get student ID and other session details
$studentId = $_SESSION['studentId'];
$dateOfBirth = $_SESSION['dateOfBirth'];
$fatherName = $_SESSION['fatherName'];
$motherName = $_SESSION['motherName'];
$studentName = $_SESSION['firstName'] . " " . $_SESSION['middleName'] . " " . $_SESSION['lastName'];
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

    // Fetch results for the selected semester
    $query_results = "
    SELECT sc.courseId, sc.gradePoint, sc.grade, c.courseCode, c.courseTitle, c.credit
    FROM semester_course sc
    INNER JOIN course c ON sc.courseId = c.id
    WHERE sc.studentId = '$studentId' AND sc.semesterName = '$semesterName'
  ";
    $rs_results = $conn->query($query_results);

    $results_html = "";
    $totalCredits = 0;
    $totalWeightedPoints = 0;

    if ($rs_results->num_rows > 0) {
        while ($result = $rs_results->fetch_assoc()) {
            $results_html .= "
        <tr>
          <td>{$result['courseCode']}</td>
          <td>{$result['courseTitle']}</td>
          <td>{$result['credit']}</td>
          <td>{$result['grade']}</td>
          <td>{$result['gradePoint']}</td>
        </tr>
      ";
            $totalCredits += $result['credit'];
            $totalWeightedPoints += $result['credit'] * $result['gradePoint'];
        }
    } else {
        $results_html = "<tr><td colspan='5'>No results found for the selected semester</td></tr>";
    }

    $sgpa = $totalCredits > 0 ? round($totalWeightedPoints / $totalCredits, 2) : 0;

    // Fetch certificate URL for the selected semester
    $query_certificate = "
    SELECT fileUrl FROM certificate
    WHERE studentId = '$studentId' AND semesterName = '$semesterName'
  ";
    $rs_certificate = $conn->query($query_certificate);

    $certificateUrl = '';
    if ($rs_certificate->num_rows > 0) {
        $certificateUrl = $rs_certificate->fetch_assoc()['fileUrl'];
    }

    echo json_encode([
        'results_html' => $results_html,
        'totalCredits' => $totalCredits,
        'sgpa' => $sgpa,
        'certificateUrl' => $certificateUrl
    ]);
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
    <title>View Result</title>
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
                        <h5 class="mb-0" style="color: #002D5B;">View Student Results</h5>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="./">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Student Results</li>
                        </ol>
                    </div>

                    <!-- Dropdown and Show Result Button -->
                    <div class="row mb-4">
                        <div class="col-12 d-flex flex-column flex-md-row align-items-md-center">
                            <div class="mb-3 mb-md-0 w-100">
                                <select id="semesterName" class="form-control" style="border: none; border-bottom: 2px solid #002D5B; background-color: transparent;">
                                    <option value="" disabled selected>Select a semester</option>
                                    <option value="Winter-2023">Winter-2023</option>
                                    <option value="Spring-2023">Spring-2023</option>
                                    <option value="Summer-2023">Summer-2023</option>
                                    <option value="Fall-2023">Fall-2023</option>
                                    <option value="Winter-2024">Winter-2024</option>
                                    <option value="Spring-2024">Spring-2024</option>
                                    <option value="Summer-2024">Summer-2024</option>
                                    <option value="Fall-2024">Fall-2024</option>
                                    <option value="Winter-2025">Winter-2025</option>
                                    <option value="Spring-2025">Spring-2025</option>
                                    <option value="Summer-2025">Summer-2025</option>
                                    <option value="Fall-2025">Fall-2025</option>
                                </select>
                            </div>
                            <button id="showResultButton" class="btn btn-primary mx-md-3 mt-2 mt-md-0 w-100 w-md-auto" style="background-color: #6777EF;">Show Result</button>
                            <button id="digitalCertificateButton" class="btn btn-primary mt-2 mt-md-0 w-100 w-md-auto" style="background-color: #6777EF;">Digital Certificate</button>
                        </div>
                    </div>
                    <!-- Student Info Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div style="border-bottom: 2px solid #002D5B;">
                                <div class="row">
                                    <!-- Student Info Column -->
                                    <div class="col-6 col-md-4 mb-3">
                                        <h5 style="color: #002D5B;">Student Info</h5>
                                        <hr style="border: 2px solid #6dbaa0; width: 10%; margin-left: 0;">
                                        <p>Name of Student:</p>
                                        <p>Student Id:</p>
                                        <p>Date of Birth:</p>
                                        <p>Father Name:</p>
                                        <p>Mother Name:</p>
                                        <p>Enrollment:</p>
                                    </div>

                                    <!-- Student Info Details Column -->
                                    <div class="col-6 col-md-4 mb-3" style="margin-top: 60px;">
                                        <p><?php echo $studentName; ?></p>
                                        <p><?php echo $studentId; ?></p>
                                        <p><?php echo $dateOfBirth; ?></p>
                                        <p><?php echo $fatherName; ?></p>
                                        <p><?php echo $motherName; ?></p>
                                        <p id="enrollment">Select semester first</p>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <h5 style="color: #2D2E32;">UGC Uniform Grading System</h5>
                                        <table class="table table-bordered table-sm" style="font-size: 12px;">
                                            <thead style="background-color: #6dbaa0; color: white;">
                                                <tr>
                                                    <th>Marks</th>
                                                    <th>Grade</th>
                                                    <th>Grade Point</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>80-100%</td>
                                                    <td>A+</td>
                                                    <td>4.00</td>
                                                    <td>Outstanding</td>
                                                </tr>
                                                <tr>
                                                    <td>75-79%</td>
                                                    <td>A</td>
                                                    <td>3.75</td>
                                                    <td>Excellent</td>
                                                </tr>
                                                <tr>
                                                    <td>70-74%</td>
                                                    <td>A-</td>
                                                    <td>3.50</td>
                                                    <td>Very Good</td>
                                                </tr>
                                                <tr>
                                                    <td>65-69%</td>
                                                    <td>B+</td>
                                                    <td>3.25</td>
                                                    <td>Good</td>
                                                </tr>
                                                <tr>
                                                    <td>60-64%</td>
                                                    <td>B</td>
                                                    <td>3.00</td>
                                                    <td>Satisfactory</td>
                                                </tr>
                                                <tr>
                                                    <td>55-59%</td>
                                                    <td>B-</td>
                                                    <td>2.75</td>
                                                    <td>Above Average</td>
                                                </tr>
                                                <tr>
                                                    <td>50-54%</td>
                                                    <td>C+</td>
                                                    <td>2.50</td>
                                                    <td>Average</td>
                                                </tr>
                                                <tr>
                                                    <td>45-49%</td>
                                                    <td>C</td>
                                                    <td>2.25</td>
                                                    <td>Below Average</td>
                                                </tr>
                                                <tr>
                                                    <td>40-44%</td>
                                                    <td>D</td>
                                                    <td>2.00</td>
                                                    <td>Pass</td>
                                                </tr>
                                                <tr>
                                                    <td>00-39%</td>
                                                    <td>F</td>
                                                    <td>0.00</td>
                                                    <td>Fail</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Results Table -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3" style="color: #002D5B;">Academic Result of: <span id="semesterDisplay">Select semester first</span></h5>
                            <table class="table table-bordered">
                                <thead style="background-color: #6dbaa0; color: white;">
                                    <tr>
                                        <th>Course Code</th>
                                        <th>Course Title</th>
                                        <th>Credit</th>
                                        <th>Grade</th>
                                        <th>Grade Point</th>
                                    </tr>
                                </thead>
                                <tbody id="result-table-body">
                                    <tr>
                                        <td colspan="5">Select a semester and click "Show Result" to view results</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-3 d-flex flex-column flex-md-row" style="color: #002D5B;">
                                <p>Total Credits Taken: <span id="totalCredits">Select semester first</span></p>
                                <p class="ml-4">SGPA: <span id="sgpa">Select semester first</span></p>
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

    <script>
        $('#showResultButton').on('click', function() {
            const semesterName = $('#semesterName').val();
            if (!semesterName) {
                alert('Please enter a semester name');
                return;
            }

            $('#semesterDisplay').text(semesterName);
            $('#enrollment').text(semesterName);

            $.get('', {
                semesterName
            }, function(response) {
                const data = JSON.parse(response);
                $('#result-table-body').html(data.results_html);
                $('#totalCredits').text(data.totalCredits);
                $('#sgpa').text(data.sgpa);

                // Handle the Digital Certificate button
                if (data.certificateUrl) {
                    $('#digitalCertificateButton').on('click', function() {
                        window.open(data.certificateUrl, '_blank');
                    });
                } else {
                    $('#digitalCertificateButton').on('click', function() {
                        alert('No certificate found for the selected semester.');
                    });
                }
            });
        });
    </script>

</body>

</html>