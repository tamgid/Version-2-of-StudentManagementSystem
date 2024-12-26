<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {
  $studentId = $_POST['studentId'];
  $studentPassword = $_POST['studentPassword'];
  $firstName = $_POST['firstName'];
  $middleName = $_POST['middleName'];
  $lastName = $_POST['lastName'];
  $nickName = $_POST['nickName'];
  $dob = $_POST['dob'];
  $birthPlace = $_POST['birthPlace'];
  $gender = $_POST['gender'];
  $maritalStatus = $_POST['maritalStatus'];
  $bloodGroup = $_POST['bloodGroup'];
  $religion = $_POST['religion'];
  $nationality = $_POST['nationality'];
  $nationalId = $_POST['nationalId'];
  $passportNo = $_POST['passportNo'];
  $socialNetworkId = $_POST['socialNetworkId'];
  $IM = $_POST['IM'];
  $aboutStudent = $_POST['aboutStudent'];
  $mobileNo = $_POST['mobileNo'];
  $presentMobile = $_POST['presentMobile'];
  $permanentMobile = $_POST['permanentMobile'];
  $email = $_POST['email'];
  $alternativeEmail = $_POST['alternativeEmail'];
  $presentAddress = $_POST['presentAddress'];
  $presentPostOffice = $_POST['presentPostOffice'];
  $presentPoliceStation = $_POST['presentPoliceStation'];
  $presentDistrictCity = $_POST['presentDistrictCity'];
  $presentDivisionState = $_POST['presentDivisionState'];
  $presentCountry = $_POST['presentCountry'];
  $presentZipCode = $_POST['presentZipCode'];
  $permanentAddress = $_POST['permanentAddress'];
  $permanentPostOffice = $_POST['permanentPostOffice'];
  $permanentPoliceStation = $_POST['permanentPoliceStation'];
  $permanentDistrictCity = $_POST['permanentDistrictCity'];
  $permanentDivisionState = $_POST['permanentDivisionState'];
  $permanentCountry = $_POST['permanentCountry'];
  $permanentZipCode = $_POST['permanentZipCode'];
  $hostelAddress = $_POST['hostelAddress'];
  $messAddress = $_POST['messAddress'];
  $otherAddress = $_POST['otherAddress'];
  $fatherName = $_POST['fatherName'];
  $fatherContactNo = $_POST['fatherContactNo'];
  $fatherOccupation = $_POST['fatherOccupation'];
  $fatherDesignation = $_POST['fatherDesignation'];
  $fatherEmployerName = $_POST['fatherEmployerName'];
  $fatherAnnualIncome = $_POST['fatherAnnualIncome'];
  $motherName = $_POST['motherName'];
  $motherContactNo = $_POST['motherContactNo'];
  $motherOccupation = $_POST['motherOccupation'];
  $motherDesignation = $_POST['motherDesignation'];
  $motherEmployerName = $_POST['motherEmployerName'];
  $motherAnnualIncome = $_POST['motherAnnualIncome'];
  $parentAddress = $_POST['parentAddress'];
  $localGuardianName = $_POST['localGuardianName'];
  $localGuardianContactNo = $_POST['localGuardianContactNo'];
  $relationWithLocalGuardian = $_POST['relationWithLocalGuardian'];
  $localGuardianAddress = $_POST['localGuardianAddress'];


  // Hash the password using MD5
  $hashedPassword = md5($studentPassword);

  // File upload handling
  $file = $_FILES['fileUrl'];
  $fileName = $file['name'];
  $fileTmpName = $file['tmp_name'];
  $fileSize = $file['size'];
  $fileError = $file['error'];
  $fileType = $file['type'];

  // Allow only PDF files
  $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  $allowed = ['jpg', 'jpeg', 'png'];

  if (in_array($fileExt, $allowed)) {
    if ($fileError === 0) {
      if ($fileSize <= 20000000) { // Limit file size to 2MB
        $newFileName = uniqid('', true) . '.' . $fileExt; // Unique file name
        $fileDestination = '../Admin/uploads/' . $newFileName; // Upload directory

        // Move file to destination folder
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
          // Insert data into the student table
          $query = mysqli_query($conn, "INSERT INTO student (studentId, studentPassword, firstName, middleName, lastName, nickName, dob, birthPlace, gender, maritalStatus, bloodGroup, religion, nationality, nationalId, passportNo, socialNetworkId, IM, aboutStudent, mobileNo, presentMobile, permanentMobile, email, alternativeEmail, imageUrl, presentAddress, presentPostOffice, presentPoliceStation, presentDistrictCity, presentDivisionState, presentCountry, presentZipCode, permanentAddress, permanentPostOffice, permanentPoliceStation, permanentDistrictCity, permanentDivisionState, permanentCountry, permanentZipCode, hostelAddress, messAddress, otherAddress, fatherName, fatherContactNo, fatherOccupation, fatherDesignation, fatherEmployerName, fatherAnnualIncome, motherName, motherContactNo, motherOccupation, motherDesignation, motherEmployerName, motherAnnualIncome, parentAddress, localGuardianName, localGuardianContactNo, relationWithLocalGuardian, localGuardianAddress) 
  VALUES ('$studentId', '$hashedPassword', '$firstName', '$middleName', '$lastName', '$nickName', '$dob', '$birthPlace', '$gender', '$maritalStatus', '$bloodGroup', '$religion', '$nationality', '$nationalId', '$passportNo', '$socialNetworkId', '$IM', '$aboutStudent', '$mobileNo', '$presentMobile', '$permanentMobile', '$email', '$alternativeEmail', '$fileDestination', '$presentAddress', '$presentPostOffice', '$presentPoliceStation', '$presentDistrictCity', '$presentDivisionState', '$presentCountry', '$presentZipCode', '$permanentAddress', '$permanentPostOffice', '$permanentPoliceStation', '$permanentDistrictCity', '$permanentDivisionState', '$permanentCountry', '$permanentZipCode', '$hostelAddress', '$messAddress', '$otherAddress', '$fatherName', '$fatherContactNo', '$fatherOccupation', '$fatherDesignation', '$fatherEmployerName', '$fatherAnnualIncome', '$motherName', '$motherContactNo', '$motherOccupation', '$motherDesignation', '$motherEmployerName', '$motherAnnualIncome', '$parentAddress', '$localGuardianName', '$localGuardianContactNo', '$relationWithLocalGuardian', '$localGuardianAddress')");

          if ($query) {
            echo "<script type='text/javascript'>
          alert('Education Details Added Successfully!');
          window.location = ('createStudent.php');
        </script>";
          } else {
            $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error Occurred!</div>";
          }
        } else {
          $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Failed to upload the file!</div>";
        }
      } else {
        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>File size exceeds the limit of 2MB!</div>";
      }
    } else {
      $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error occurred while uploading the file!</div>";
    }
  } else {
    $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>Only PDF files are allowed!</div>";
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
  <title>Upload Certificate</title>
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
            <h1 class="h4 mb-0 text-gray-800">Upload Certificate</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Upload Certificate</li>
            </ol>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <!-- Form Basic -->
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Certificate Upload</h6>
                  <?php echo $statusMsg; ?>
                </div>
                <div class="card-body">
                  <form method="post" enctype="multipart/form-data">
                    <!-- Personal Information -->
                    <h6 class="text-primary text-center mb-4">Personal Information</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Student ID<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required name="studentId">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Password<span class="text-danger">*</span></label>
                        <input type="password" class="form-control" required name="studentPassword">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">First Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required name="firstName">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Middle Name</label>
                        <input type="text" class="form-control" name="middleName">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Last Name<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required name="lastName">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Nickname</label>
                        <input type="text" class="form-control" name="nickName">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Date of Birth<span class="text-danger">*</span></label>
                        <input type="date" class="form-control" required name="dob">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Birthplace</label>
                        <input type="text" class="form-control" name="birthPlace">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Gender<span class="text-danger">*</span></label>
                        <select class="form-control" required name="gender">
                          <option value="">Select</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                          <option value="Other">Other</option>
                        </select>
                      </div>
                    </div>

                    <!-- Marital Status and Blood Group -->
                    <h6 class="text-primary mt-4 mb-4 text-center">Additional Information</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Marital Status</label>
                        <select class="form-control" name="maritalStatus">
                          <option value="">Select</option>
                          <option value="Single">Single</option>
                          <option value="Married">Married</option>
                          <option value="Divorced">Divorced</option>
                        </select>
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Blood Group</label>
                        <input type="text" class="form-control" name="bloodGroup">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Religion</label>
                        <input type="text" class="form-control" name="religion">
                      </div>
                    </div>

                    <!-- Nationality -->
                    <h6 class="text-primary mt-4 mb-4 text-center">Nationality</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Nationality</label>
                        <input type="text" class="form-control" name="nationality">
                      </div>
                    </div>

                    <!-- Contact Information -->
                    <h6 class="text-primary text-center mt-4 mb-4">Contact Information</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">National ID</label>
                        <input type="text" class="form-control" name="nationalId">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Passport No</label>
                        <input type="text" class="form-control" name="passportNo">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Social Network ID</label>
                        <input type="text" class="form-control" name="socialNetworkId">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Instant Messaging (IM) ID</label>
                        <input type="text" class="form-control" name="IM">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Mobile No<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" required name="mobileNo">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Present Mobile No</label>
                        <input type="text" class="form-control" name="presentMobile">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Permanent Mobile No</label>
                        <input type="text" class="form-control" name="permanentMobile">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Email Address<span class="text-danger">*</span></label>
                        <input type="email" class="form-control" required name="email">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Alternative Email</label>
                        <input type="email" class="form-control" name="alternativeEmail">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="form-control-label">Upload Student Image<span class="text-danger ml-2">*</span></label>
                      <input type="file" class="form-control" name="fileUrl" accept=".jpg,.jpeg,.png" required>
                    </div>
                    <!-- About Student -->
                    <h6 class="text-primary mt-4 text-center mb-4">About the Student</h6>
                    <div class="form-group">
                      <label style="font-size: 0.9rem;">About Student</label>
                      <textarea class="form-control" name="aboutStudent" rows="4"></textarea>
                    </div>


                    <!-- Present Address -->
                    <h6 class="text-primary text-center mt-4 mb-4">Present Address</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Present Address</label>
                        <input type="text" class="form-control" name="presentAddress">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Post Office</label>
                        <input type="text" class="form-control" name="presentPostOffice">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Police Station</label>
                        <input type="text" class="form-control" name="presentPoliceStation">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">District/City</label>
                        <input type="text" class="form-control" name="presentDistrictCity">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Division/State</label>
                        <input type="text" class="form-control" name="presentDivisionState">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Country</label>
                        <input type="text" class="form-control" name="presentCountry">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Zip Code</label>
                        <input type="text" class="form-control" name="presentZipCode">
                      </div>
                    </div>

                    <!-- Permanent Address -->
                    <h6 class="text-primary mt-4 text-center mb-4">Permanent Address</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Permanent Address</label>
                        <input type="text" class="form-control" name="permanentAddress">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Post Office</label>
                        <input type="text" class="form-control" name="permanentPostOffice">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Police Station</label>
                        <input type="text" class="form-control" name="permanentPoliceStation">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">District/City</label>
                        <input type="text" class="form-control" name="permanentDistrictCity">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Division/State</label>
                        <input type="text" class="form-control" name="permanentDivisionState">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Country</label>
                        <input type="text" class="form-control" name="permanentCountry">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Zip Code</label>
                        <input type="text" class="form-control" name="permanentZipCode">
                      </div>
                    </div>

                    <!-- Hostel and Mess Address -->
                    <h6 class="text-primary mt-4 text-center mb-4">Additional Addresses</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Hostel Address</label>
                        <input type="text" class="form-control" name="hostelAddress">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Mess Address</label>
                        <input type="text" class="form-control" name="messAddress">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Other Address</label>
                        <input type="text" class="form-control" name="otherAddress">
                      </div>
                    </div>

                    <!-- Father Information -->
                    <h6 class="text-primary text-center mt-4 mb-4">Father's Information</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Father's Name</label>
                        <input type="text" class="form-control" name="fatherName">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Father's Contact No</label>
                        <input type="text" class="form-control" name="fatherContactNo">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Father's Occupation</label>
                        <input type="text" class="form-control" name="fatherOccupation">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Father's Designation</label>
                        <input type="text" class="form-control" name="fatherDesignation">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Father's Employer Name</label>
                        <input type="text" class="form-control" name="fatherEmployerName">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Father's Annual Income</label>
                        <input type="text" class="form-control" name="fatherAnnualIncome">
                      </div>
                    </div>

                    <!-- Mother Information -->
                    <h6 class="text-primary mt-4 text-center mb-4">Mother's Information</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Mother's Name</label>
                        <input type="text" class="form-control" name="motherName">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Mother's Contact No</label>
                        <input type="text" class="form-control" name="motherContactNo">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Mother's Occupation</label>
                        <input type="text" class="form-control" name="motherOccupation">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Mother's Designation</label>
                        <input type="text" class="form-control" name="motherDesignation">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Mother's Employer Name</label>
                        <input type="text" class="form-control" name="motherEmployerName">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Mother's Annual Income</label>
                        <input type="text" class="form-control" name="motherAnnualIncome">
                      </div>
                    </div>

                    <!-- Parent Address -->
                    <h6 class="text-primary mt-4 text-center mb-4">Parent's Address</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Parent's Address</label>
                        <input type="text" class="form-control" name="parentAddress">
                      </div>
                    </div>

                    <!-- Local Guardian Information -->
                    <h6 class="text-primary mt-4 text-center mb-4">Local Guardian's Information</h6>
                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Local Guardian's Name</label>
                        <input type="text" class="form-control" name="localGuardianName">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Local Guardian's Contact No</label>
                        <input type="text" class="form-control" name="localGuardianContactNo">
                      </div>
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Relation with Local Guardian</label>
                        <input type="text" class="form-control" name="relationWithLocalGuardian">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-md-4">
                        <label style="font-size: 0.9rem;">Local Guardian's Address</label>
                        <input type="text" class="form-control" name="localGuardianAddress">
                      </div>
                    </div>
                    <button type="submit" name="save" class="btn btn-primary">Upload</button>
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