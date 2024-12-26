<?php
include 'Includes/dbcon.php';

$successMessage = ''; // Variable to hold the success message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $applicationDate = date('Y-m-d'); // Current date

  // Insert email and application date into the forgot_password table
  $query = "INSERT INTO forgot_password (email, applicationDate) VALUES ('$email', '$applicationDate')";
  if ($conn->query($query)) {
    $successMessage = "Your request is received by the administrative panel. They will notify you regarding the password change.";
  } else {
    echo "<script>alert('Error submitting your request. Please try again later.');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .forgot-password-container {
      width: 100%;
      max-width: 400px;
      padding: 20px;
      background-color: white;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      position: relative;
    }

    .btn {
      background-color: #054D95;
      color: white;
    }

    .btn:hover {
      background-color: #348681;
    }

    .back-button {
      position: absolute;
      top: 10px;
      left: 10px;
      color: #348681;
      text-decoration: none;
      font-weight: bold;
    }

    .back-button:hover {
      color: #054D95;
    }

    .success-message {
      color: #348681;
      font-size: 14px;
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="forgot-password-container">
    <a href="index.php" class="back-button">&larr; Back</a>
    <h4 class="text-center" style="color: #054D95;">Forgot Password</h4>
    <form method="POST" action="">
      <div class="form-group">
        <label for="email" style="color: #2D2E32;">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
      </div>
      <?php if ($successMessage): ?>
        <div class="success-message" id="successMessage">
          <?php echo $successMessage; ?>
        </div>
      <?php endif; ?>
      <div class="form-group text-center mt-3">
        <button type="submit" class="btn btn-block">Submit</button>
      </div>
    </form>
  </div>

  <script>
    // Hide the success message after 5 seconds
    window.onload = function() {
      const successMessage = document.getElementById('successMessage');
      if (successMessage) {
        setTimeout(() => {
          successMessage.style.display = 'none';
        }, 2000); // 5000ms = 5 seconds
      }
    };
  </script>
</body>

</html>