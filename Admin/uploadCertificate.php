<?php
error_reporting(0);
include '../Includes/dbcon.php';
include '../Includes/session.php';

//------------------------SAVE--------------------------------------------------

if (isset($_POST['save'])) {
    $studentId = $_POST['studentId'];
    $semesterName = $_POST['semesterName'];

    // File upload handling
    $file = $_FILES['fileUrl'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    // Allow only PDF files
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowed = ['pdf'];

    if (in_array($fileExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize <= 20000000) { // Limit file size to 2MB
                $newFileName = uniqid('', true) . '.' . $fileExt; // Unique file name
                $fileDestination = '../Admin/uploads/' . $newFileName; // Upload directory

                // Move file to destination folder
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    // Insert data into the database
                    $query = mysqli_query($conn, "INSERT INTO certificate (studentId, semesterName, fileUrl) 
                                                  VALUES ('$studentId', '$semesterName', '$fileDestination')");

                    if ($query) {
                        echo "<script type='text/javascript'>
                                alert('Certificate Uploaded Successfully!');
                                window.location = ('uploadCertificate.php');
                              </script>";
                    } else {
                        $statusMsg = "<div class='alert alert-danger' style='margin-right:700px;'>An error occurred while saving certificate details!</div>";
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
                                        <div class="form-group row mb-3">
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Student ID<span class="text-danger ml-2">*</span></label>
                                                <input type="text" class="form-control" name="studentId" required>
                                            </div>
                                            <div class="col-xl-6">
                                                <label class="form-control-label">Semester Name<span class="text-danger ml-2">*</span></label>
                                                <select class="form-control" name="semesterName" required>
                                                    <option value="" disabled selected>Select Semester</option>
                                                    <option value="Winter-2023">Winter-2023</option>
                                                    <option value="Spring-2023">Spring-2023</option>
                                                    <option value="Summer-2023">Summer-2023</option>
                                                    <option value="Fall-2023">Fall-2023</option>
                                                    <option value="Winter-2024">Winter-2024</option>
                                                    <option value="Spring-2024">Spring-2024</option>
                                                    <option value="Summer-2024">Summer-2024</option>
                                                    <option value="Fall-2024">Fall-2024</option>
                                                    <option value="Winter-2024">Winter-2025</option>
                                                    <option value="Spring-2024">Spring-2025</option>
                                                    <option value="Summer-2024">Summer-2025</option>
                                                    <option value="Fall-2024">Fall-2025</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control-label">Upload Certificate (PDF)<span class="text-danger ml-2">*</span></label>
                                            <input type="file" class="form-control" name="fileUrl" accept=".pdf" required>
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