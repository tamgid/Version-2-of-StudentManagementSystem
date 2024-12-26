<?php
include 'Includes/dbcon.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="./img/logo.jpg" rel="icon">
  <title>NPIUB - Login</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: white;
    }

    .background-image {
      background-image: url('./img/home_banner.jpg');
      background-size: cover;
      background-position: center;
      height: 100vh;
      position: relative;
    }

    .background-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1;
    }

    .login-form-container {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 85%;
      max-width: 350px;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      padding: 1.2rem;
      border-radius: 10px;
      z-index: 2;
    }

    .form-control {
      font-size: 0.85rem;
      height: calc(1.5em + 0.75rem + 2px);
    }

    .btn {
      font-size: 0.85rem;
      padding: 0.4rem 0.75rem;
    }

    img {
      width: 60px;
      height: 60px;
    }
 
    a {
      display: inline-block;
    }
  </style>

</head>

<body>
  <!-- Background Image Section -->
  <div class="background-image">
    <div class="background-overlay"></div>
    <div class="login-form-container">
      <div class="card shadow-sm">
        <div class="card-body">
          <!-- Logo Section (Top Right) -->
          <div class="d-flex justify-content-end">
            <img src="img/logo.jpg" style="width:80px;height:70px" alt="Logo">
          </div>

          <!-- Headings Section (Left Align) -->
          <div class="mt-3">
            <h4 align="left" style="color: #054D95;">Hello NPIUBIAN</h4>
            <h5 align="left" style="color: #2D2E32;">Please Login to Your Account!</h5>
          </div>

          <!-- Login Form -->
          <form class="user mt-3" method="Post" action="">
            <div class="form-group">
              <select required name="userType" class="form-control mb-3">
                <option value="">--Select User Roles--</option>
                <option value="Administrator">Teacher</option>
                <option value="Student">Student</option>
              </select>
            </div>
            <div class="form-group">
              <input type="text" class="form-control" required name="username" id="exampleInputEmail" placeholder="Enter Student Id for Student or Email for Admin ">
            </div>
            <div class="form-group">
              <input type="password" name="password" required class="form-control" id="exampleInputPassword" placeholder="Enter Password">
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-success btn-block" value="Login" name="login" style="background-color: #054D95;" />
            </div>
          </form>

          <!-- Forgot Password Section -->
          <div class="text-center mt-3">
            <span>Forgot your password? </span>
            <a href="forgot_password.php" style="color: #054D95; text-decoration: none;"
              onmouseover="this.style.color='#348681'" onmouseout="this.style.color='#054D95'">Check Details</a>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php
  if (isset($_POST['login'])) {
    $userType = $_POST['userType'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($userType == "Administrator") {
      $query = "SELECT * FROM admin WHERE emailAddress = '$username' AND password = '$password'";
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rows = $rs->fetch_assoc();

      if ($num > 0) {
        $_SESSION['userId'] = $rows['id'];
        $_SESSION['firstName'] = $rows['firstName'];
        $_SESSION['lastName'] = $rows['lastName'];
        $_SESSION['emailAddress'] = $rows['emailAddress'];

        echo "<script type = \"text/javascript\">
                window.location = (\"Admin/index.php\")
                </script>";
      } else {
        echo "<div class='alert alert-danger' role='alert'>
                Invalid Username/Password!
                </div>";
      }
    } else if ($userType == "Student") {
      // Query to get the student record based on studentId
      $query = "SELECT * FROM student WHERE studentId = '$username'";
      $rs = $conn->query($query);
      $num = $rs->num_rows;
      $rows = $rs->fetch_assoc();

      // Check if the student exists
      if ($num > 0) {
        // Retrieve the stored hashed password
        $storedHashedPassword = $rows['studentPassword'];

        // Hash the entered password using MD5
        $enteredPasswordHash = md5($password);

        // Compare the entered password hash with the stored hash
        if ($enteredPasswordHash === $storedHashedPassword) {
          // Password is correct, set session variables
          $_SESSION['userId'] = $rows['id'];
          $_SESSION['studentId'] = $rows['studentId'];
          $_SESSION['firstName'] = $rows['firstName'];
          $_SESSION['middleName'] = $rows['middleName'];
          $_SESSION['lastName'] = $rows['lastName'];
          $_SESSION['emailAddress'] = $rows['email'];
          $_SESSION['dateOfBirth'] = $rows['dob'];
          $_SESSION['fatherName'] = $rows['fatherName'];
          $_SESSION['motherName'] = $rows['motherName'];

          // Redirect to the student dashboard
          echo "<script type='text/javascript'>
                  window.location = ('Student/index.php');
                </script>";
        } else {
          // Invalid password
          echo "<div class='alert alert-danger' role='alert'>
                  Invalid Username/Password!
                </div>";
        }
      } else {
        // No student found with the given username
        echo "<div class='alert alert-danger' role='alert'>
                Invalid Username/Password!
              </div>";
      }
    } else {
      echo "<div class='alert alert-danger' role='alert'>
              Invalid Username/Password!
              </div>";
    }
  }
  ?>

</body>

</html>