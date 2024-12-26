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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="img/logo.jpg" rel="icon">
  <title>View Profile</title>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .section {
      display: none;
    }

    .section.active {
      display: block;
    }

    /* Adjustments for small screens */
    @media (max-width: 576px) {
      .text-white.p-4.d-flex.align-items-center {
        min-height: 150px;
        /* Smaller height for small screens */
      }

      #student-image {
        width: 100px;
        /* Smaller width for the image */
        height: 100px;
        /* Smaller height for the image */
      }

      #student-name {
        font-size: 1rem;
        /* Smaller font size for name */
      }

      #student-email {
        font-size: 0.9rem;
        /* Smaller font size for email */
      }
    }

    @media (max-width: 576px) {
      #button-group {
        flex-direction: column;
        /* Stack buttons vertically */
      }

      #button-group .btn {
        width: 100%;
        /* Full width for buttons */
        margin-bottom: 10px;
        /* Add spacing between buttons */
      }
    }
  </style>
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

        <div class="w-100 mx-auto">
          <div class="text-white p-4 d-flex align-items-center" style="background-color: #6dbaa0; min-height: 200px;">
            <div class="ml-3 mt-2 mb-2 mr-3">
              <img src="<?php echo htmlspecialchars($student['imageUrl']); ?>"
                alt="Student"
                class="rounded-circle img-fluid"
                style="width: 170px; height: 170px; object-fit: cover;"
                id="student-image">
            </div>
            <div class="flex-grow-1 ps-3 ps-sm-4 ps-md-5"> <!-- Added responsive padding -->
              <h3 class="fw-bold mb-1" id="student-name">
                <?php echo htmlspecialchars($student['firstName'] . ' ' . $student['middleName'] . ' ' . $student['lastName']); ?>
              </h3>
              <p class="mb-0" id="student-email">Email: <?php echo htmlspecialchars($student['email']); ?></p>
            </div>
          </div>

          <!-- Main Content -->
          <div class="content-container ml-5 mr-5 d-flex flex-column align-items-center">
            <div class="btn-group w-100 mt-3 flex-wrap" role="group" aria-label="Student Information" id="button-group">
              <button class="btn" style="background-color: #f0edff; border: none; height: 40px; color: #2D2E32;"
                onmouseover="this.style.backgroundColor='#b4b2e9'; this.style.color='#ffffff';"
                onmouseout="this.style.backgroundColor='#f0edff'; this.style.color='#2D2E32';"
                onclick="showSection('personal_information')">Personal Information</button>
              <button class="btn" style="background-color: #f0edff; border: none; height: 40px; color: #2D2E32;"
                onmouseover="this.style.backgroundColor='#b4b2e9'; this.style.color='#ffffff';"
                onmouseout="this.style.backgroundColor='#f0edff'; this.style.color='#2D2E32';"
                onclick="showSection('parents_information')">Parents Information</button>
              <button class="btn" style="background-color: #f0edff; border: none; height: 40px; color: #2D2E32;"
                onmouseover="this.style.backgroundColor='#b4b2e9'; this.style.color='#ffffff';"
                onmouseout="this.style.backgroundColor='#f0edff'; this.style.color='#2D2E32';"
                onclick="showSection('contact_information')">Contact Information</button>
              <button class="btn" style="background-color: #f0edff; border: none; height: 40px; color: #2D2E32;"
                onmouseover="this.style.backgroundColor='#b4b2e9'; this.style.color='#ffffff';"
                onmouseout="this.style.backgroundColor='#f0edff'; this.style.color='#2D2E32';"
                onclick="showSection('addresses')">Addresses</button>
              <button class="btn" style="background-color: #f0edff; border: none; height: 40px; color: #2D2E32;"
                onmouseover="this.style.backgroundColor='#b4b2e9'; this.style.color='#ffffff';"
                onmouseout="this.style.backgroundColor='#f0edff'; this.style.color='#2D2E32';"
                onclick="showSection('about_student')">About the Student</button>
            </div>

            <div class="main-content p-4 border bg-white w-100">
              <!-- Personal Information -->
              <div id="personal_information" class="section active">
                <h5 class="fw-bold mb-2" style="color: #2D2E32;">Personal Information</h5>
                <hr style="border: 2px solid #6dbaa0; width: 4%; margin-left: 0;">

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Student ID: <?php echo htmlspecialchars($student['studentId']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Nickname: <?php echo htmlspecialchars($student['nickName']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Date of Birth: <?php echo htmlspecialchars($student['dob']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Birthplace: <?php echo htmlspecialchars($student['birthPlace']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Gender: <?php echo htmlspecialchars($student['gender']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Marital Status: <?php echo htmlspecialchars($student['maritalStatus']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Blood Group: <?php echo htmlspecialchars($student['bloodGroup']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Religion: <?php echo htmlspecialchars($student['religion']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Nationality: <?php echo htmlspecialchars($student['nationality']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Alternative Email: <?php echo htmlspecialchars($student['alternativeEmail']); ?></p>
                  </div>
                </div>
              </div>


              <!-- Contact Information -->
              <div id="contact_information" class="section">
                <h5 class="fw-bold mb-2" style="color: #2D2E32;">Contact Information</h5>
                <hr style="border: 2px solid #6dbaa0; width: 4%; margin-left: 0;">

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>National ID: <?php echo htmlspecialchars($student['nationalId']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Passport No: <?php echo htmlspecialchars($student['passportNo']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Social Network ID: <?php echo htmlspecialchars($student['socialNetworkId']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Instant Messaging (IM) ID: <?php echo htmlspecialchars($student['IM']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Mobile No: <?php echo htmlspecialchars($student['mobileNo']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Present Mobile No: <?php echo htmlspecialchars($student['presentMobile']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Permanent Mobile No: <?php echo htmlspecialchars($student['permanentMobile']); ?></p>
                  </div>
                </div>
              </div>

              <!-- About the Student -->
              <div id="about_student" class="section">
                <h5 class="fw-bold mb-2" style="color: #2D2E32;">About the Student</h5>
                <hr style="border: 2px solid #6dbaa0; width: 4%; margin-left: 0;">
                <p class="lead" style="color: #2D2E32; font-size: 15px;"><?php echo htmlspecialchars($student['aboutStudent']); ?></p>
              </div>

              <!-- Addresses -->
              <div id="addresses" class="section">
                <h5 class="fw-bold mb-2" style="color: #2D2E32;">Present Address</h5>
                <hr style="border: 2px solid #6dbaa0; width: 4%; margin-left: 0;">

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Present Address: <?php echo htmlspecialchars($student['presentAddress']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Present Post Office: <?php echo htmlspecialchars($student['presentPostOffice']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Present Police Station: <?php echo htmlspecialchars($student['presentPoliceStation']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Present District/City: <?php echo htmlspecialchars($student['presentDistrictCity']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Present Division/State: <?php echo htmlspecialchars($student['presentDivisionState']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Present Country: <?php echo htmlspecialchars($student['presentCountry']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Present Zip Code: <?php echo htmlspecialchars($student['presentZipCode']); ?></p>
                  </div>
                </div>
                <h5 class="fw-bold mb-2" style="color: #2D2E32;">Permanent Address</h5>
                <hr style="border: 2px solid #6dbaa0; width: 4%; margin-left: 0;">

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Permanent Address: <?php echo htmlspecialchars($student['permanentAddress']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Permanent Post Office: <?php echo htmlspecialchars($student['permanentPostOffice']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Permanent Police Station: <?php echo htmlspecialchars($student['permanentPoliceStation']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Permanent District/City: <?php echo htmlspecialchars($student['permanentDistrictCity']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Permanent Division/State: <?php echo htmlspecialchars($student['permanentDivisionState']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Permanent Country: <?php echo htmlspecialchars($student['permanentCountry']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Permanent Zip Code: <?php echo htmlspecialchars($student['permanentZipCode']); ?></p>
                  </div>
                </div>

                <h5 class="fw-bold mb-2" style="color: #2D2E32;">Other Address</h5>
                <hr style="border: 2px solid #6dbaa0; width: 4%; margin-left: 0;">

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Hostel Address: <?php echo htmlspecialchars($student['hostelAddress']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Mess Address: <?php echo htmlspecialchars($student['messAddress']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12">
                    <p>Other Address: <?php echo htmlspecialchars($student['otherAddress']); ?></p>
                  </div>
                </div>
              </div>

              <!-- Parents Information -->
              <div id="parents_information" class="section">
                <h5 class="fw-bold mb-2" style="color: #2D2E32;">Father Information</h5>
                <hr style="border: 2px solid #6dbaa0; width: 4%; margin-left: 0;">

                <!-- Father's Information -->
                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Father's Name: <?php echo htmlspecialchars($student['fatherName']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Father's Contact No: <?php echo htmlspecialchars($student['fatherContactNo']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Father's Occupation: <?php echo htmlspecialchars($student['fatherOccupation']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Father's Designation: <?php echo htmlspecialchars($student['fatherDesignation']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Father's Employer Name: <?php echo htmlspecialchars($student['fatherEmployerName']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Father's Annual Income: <?php echo htmlspecialchars($student['fatherAnnualIncome']); ?></p>
                  </div>
                </div>

                <!-- Mother's Information -->
                <h5 class="fw-bold mb-2" style="color: #2D2E32;">Mother Information</h5>
                <hr style="border: 2px solid #6dbaa0; width: 4%; margin-left: 0;">
                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Mother's Name: <?php echo htmlspecialchars($student['motherName']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Mother's Contact No: <?php echo htmlspecialchars($student['motherContactNo']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Mother's Occupation: <?php echo htmlspecialchars($student['motherOccupation']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Mother's Designation: <?php echo htmlspecialchars($student['motherDesignation']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Mother's Employer Name: <?php echo htmlspecialchars($student['motherEmployerName']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Mother's Annual Income: <?php echo htmlspecialchars($student['motherAnnualIncome']); ?></p>
                  </div>
                </div>

                <!-- Parent's Address -->
                <h5 class="fw-bold mb-2" style="color: #2D2E32;">Parent Address</h5>
                <hr style="border: 2px solid #6dbaa0; width: 4%; margin-left: 0;">
                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12">
                    <p>Parent's Address: <?php echo htmlspecialchars($student['parentAddress']); ?></p>
                  </div>
                </div>

                <!-- Local Guardian's Information -->
                <h5 class="fw-bold mb-2" style="color: #2D2E32;">Local Guardian's Information</h5>
                <hr style="border: 2px solid #6dbaa0; width: 4%; margin-left: 0;">
                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Local Guardian's Name: <?php echo htmlspecialchars($student['localGuardianName']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Local Guardian's Contact No: <?php echo htmlspecialchars($student['localGuardianContactNo']); ?></p>
                  </div>
                </div>

                <div class="row mb-2" style="color: #002D5B; font-size: 15px;">
                  <div class="col-12 col-md-6">
                    <p>Relation with Local Guardian: <?php echo htmlspecialchars($student['relationWithLocalGuardian']); ?></p>
                  </div>
                  <div class="col-12 col-md-6">
                    <p>Local Guardian's Address: <?php echo htmlspecialchars($student['localGuardianAddress']); ?></p>
                  </div>
                </div>
              </div>

            </div>
            <!-- End Main Content -->
          </div>

          <!-- Footer -->
          <?php include "Includes/footer.php"; ?>
          <!-- Footer -->
        </div>
      </div>
    </div>

    <script>
      function showSection(sectionId) {
        document.querySelectorAll('.section').forEach(section => {
          section.classList.remove('active');
        });
        document.getElementById(sectionId).classList.add('active');

        document.querySelectorAll('.content-button').forEach(button => {
          button.classList.remove('active');
        });
        document.querySelector(`.content-button[onclick="showSection('${sectionId}')"]`).classList.add('active');
      }
    </script>

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