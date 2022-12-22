<?php
if (!isset($_SESSION)) {
  session_start();
}
$se = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title -->
  <title></title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="../favicon.ico">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <!-- CSS Implementing Plugins -->
  <link rel="stylesheet" href="./assets/vendor/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">


  <!-- CSS Front Template -->
  <link rel="stylesheet" href="./assets/css/theme.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">

  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>
  <style>
    .active {
      border-left: 3px #003366 solid;
    }

    hr {
      border-top: 5px dashed green;
      border-radius: 5px;
    }

    .success-bg {
      background-color: #d0fccf
    }

    .danger-bg {
      background-color: #e1e6f7;
    }
  </style>
</head>

<body>
  <!-- ========== HEADER ========== -->
  <input type="hidden" value="<?php if (isset($_GET['page'])) {
                                echo $_GET['page'];
                              } ?>" id="page">
  <header id="header" class="navbar navbar-expand-lg navbar-end navbar-light bg-white">

    <div class="container">
      <nav class="navbar-nav-wrap">
        <!-- Default Logo -->
        <a class="navbar-brand" href="#" aria-label="Front">
          <img class="navbar-brand-logo" src="./assets/images/uni.jpg" alt="Logo">
        </a>
        <!-- End Default Logo -->

        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-default">
            <i class="bi-list"></i>
          </span>
          <span class="navbar-toggler-toggled">
            <i class="bi-x"></i>
          </span>
        </button>
        <!-- End Toggler -->

        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <!--
            <li class="nav-item">
              <a class="nav-link bold text-dark" href="?page=search.php">بحث</a>
            </li>-->
            <li class="nav-item">
              <a class="nav-link " href="#"></a>
            </li>
            <li class="nav-item">
              <?php if ($_SESSION['login'] == 1) {
                echo 'مرحبا، <a href="?page=profile.php">' . $_SESSION['user_details']['name'] . '</a>&nbsp;&nbsp;<button class="btn btn-info " onclick="logout()">تسجيل الخروج</button>';
              } else {
                echo '<a class="btn btn-primary btn-transition" href="?page=login.php">تسجيل الدخول</a>';
              } ?>
            </li>
          </ul>
        </div>
        <!-- End Collapse -->
      </nav>
    </div>
  </header>

  <!-- ========== END HEADER ========== -->

  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main">
    <!-- Hero -->
    <div class="container contenspace-t-md-0">
      <div class="row justify-content-md-between align-items-md-center">
        <div class="col-md-5">
          <!-- Heading -->
          <div class="mb-4">
            <h1> جدول امتحانات الكليات </h1>
            <p>ابحث عن امتحان </p>
          </div>
          <!-- End Heading -->
        </div>
        <!-- End Col -->
      </div>
      <!-- End Row -->
    </div>
    <!-- End Hero -->

    <!-- Card Grid -->
    <div class="col-12">
      <div class="row col-lg-divider">
        <div class="col-lg-2">
          <!-- Navbar -->
          <div class="navbar-expand-lg">
            <!-- Navbar Toggle -->
            <div class="d-grid">
              <button type="button" class="navbar-toggler btn btn-white mb-3" data-bs-toggle="collapse" data-bs-target="#navbarVerticalNavMenu" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navbarVerticalNavMenu">
                <span class="d-flex justify-content-between align-items-center">
                  <span class="text-dark">القائمة</span>

                  <span class="navbar-toggler-default">
                    <i class="bi-list"></i>
                  </span>

                  <span class="navbar-toggler-toggled">
                    <i class="bi-x"></i>
                  </span>
                </span>
              </button>
            </div>
            <!-- End Navbar Toggle -->
            <?php if (true) { ?>
              <!-- Navbar Collapse -->
              <div id="navbarVerticalNavMenu" class="collapse rounded navbar-collapse bg-light bg-gradient">
                <div class="d-grid gap-4 flex-grow-1">
                  <?php if ($_SESSION['login'] == 1) { ?>
                    <div class="d-grid">
                      <h5 class="dropdown-header h3">الاضافة</h5>
                      <hr />
                      <a class="dropdown-item " href="?page=profile.php">الملف الشخصي</a>
                      <?php if ($se == 1 || $se == 2) { ?>
                        <a class="dropdown-item " href="?page=addExam.php">اضافة امتحان</a>
                      <?php } ?>
                      <?php if ($se == 1) { ?>
                        <a class="dropdown-item " href="?page=addUser.php">اضافة مستخدم</a>
                      <?php } ?>
                    </div>
                  <?php } ?>
                  <div class="d-grid">
                    <h5 class="dropdown-header">البحث</h5>
                    <a class="dropdown-item" href="?page=home.php"> جدول الامتحانات </a>
                    <?php if ($se == 1) { ?>
                      <a class="dropdown-item" href="?page=users.php">المستخدمون</a>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <!-- End Navbar Collapse -->
            <?php } ?>
          </div>
          <!-- End Navbar -->
        </div>
        <script>
          page = $("#page").val();
          if (page != "") {
            $("#navbar-expand-lg a").removeClass("active");
            $("[href='?page=" + page + "']").addClass("active");
          } else {
            $("[href='?page=findWorkshop.php']").addClass("active");
          }

          function logout() {
            $.ajax({
              url: "script/_logout.php",
              type: "POST",
              data: $("#addCatForm").serialize(),
              success: function(res) {
                console.log(res);
                window.location.href = "?page=login.php";
              },
              error: function(e) {
                console.log(e);
              }
            });
          }
        </script>