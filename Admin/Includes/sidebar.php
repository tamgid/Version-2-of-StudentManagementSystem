<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php" style="background-color: #6777EF;">
    <div class="sidebar-brand-icon">
      <img src="../img/logo.jpg">
    </div>
    <div class="sidebar-brand-text mx-3" style="font-size: larger;">NPIUB</div>
  </a>
  <hr class="sidebar-divider my-0">

  <li class="nav-item active">
    <a class="nav-link text-dark" href="index.php" style="font-size: larger;">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading text-dark" style="font-size: medium;">
    Student
  </div>
  <li class="nav-item">
    <a class="nav-link collapsed text-dark" href="#" data-toggle="collapse" data-target="#collapseManageStudents" aria-expanded="true" aria-controls="collapseManageStudents" style="font-size: larger;">
      <i class="fas fa-chalkboard-teacher"></i>
      <span>Manage Student</span>
    </a>
    <div id="collapseManageStudents" class="collapse" aria-labelledby="headingManageStudents" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item text-dark" href="createStudent.php" style="font-size: medium;">Add Student Details</a>
        <a class="collapse-item text-dark" href="uploadCertificate.php" style="font-size: medium;">Upload Certificate</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading text-dark" style="font-size: medium;">
    Education
  </div>
  <li class="nav-item">
    <a class="nav-link collapsed text-dark" href="#" data-toggle="collapse" data-target="#collapseManageEducation" aria-expanded="true" aria-controls="collapseManageEducation" style="font-size: larger;">
      <i class="fas fa-chalkboard"></i>
      <span>Manage Education</span>
    </a>
    <div id="collapseManageEducation" class="collapse" aria-labelledby="headingManageEducation" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item text-dark" href="createEducation.php" style="font-size: medium;">Add Education Details</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading text-dark" style="font-size: medium;">
    Course
  </div>
  <li class="nav-item">
    <a class="nav-link collapsed text-dark" href="#" data-toggle="collapse" data-target="#collapseManageCourses" aria-expanded="true" aria-controls="collapseManageCourses" style="font-size: larger;">
      <i class="fas fa-user-graduate"></i>
      <span>Manage Courses</span>
    </a>
    <div id="collapseManageCourses" class="collapse" aria-labelledby="headingManageCourses" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item text-dark" href="createCourses.php" style="font-size: medium;">Add Course Details</a>
      </div>
    </div>
  </li>

  <hr class="sidebar-divider">
  <div class="sidebar-heading text-dark" style="font-size: medium;">
    Payment
  </div>
  <li class="nav-item">
    <a class="nav-link collapsed text-dark" href="#" data-toggle="collapse" data-target="#collapseAssignPayment" aria-expanded="true" aria-controls="collapseAssignPayment" style="font-size: larger;">
      <i class="fas fa-chalkboard-teacher"></i>
      <span>Manage Payments</span>
    </a>
    <div id="collapseAssignPayment" class="collapse" aria-labelledby="headingAssignPayment" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item text-dark" href="createPayment.php" style="font-size: medium;">Add Payment Details</a>
      </div>
    </div>
  </li>
</ul>