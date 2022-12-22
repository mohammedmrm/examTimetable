<?php
if (!isset($_SESSION)) {
  session_start();
}
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title
    <title>Hello, world!</title>
    -->
  <!-- Favicon -->
  <link rel="shortcut icon" href="./favicon.ico">

  <!-- Font -->

  <!-- CSS Front Template -->
  <link rel="stylesheet" href="./assets/css/theme.min.css">
  <script src="./assets/js/jquery.js"></script>
  <script src="./assets/js/toast.js"></script>
  <style>
    .loading {
      background-image: url(assets/img/loading.gif);
      background-size: contain;
      background-position: center;
      background-repeat: no-repeat;
      max-height: 300px;
      min-height: 200px;
    }

    .loading * {
      visibility: hidden;
      display: none;
    }

    td {
      white-space: normal !important;
      word-wrap: break-word;
    }

    hr {
      border: 10px solid green;
      border-radius: 5px;
    }

    /* arabic */
    @font-face {
      font-family: 'Cairo';
      font-style: normal;
      font-weight: 400;
      font-display: swap;
      src: local('Cairo'), local('Cairo-Regular'), url(Cairofont.woff2) format('woff2');
      unicode-range: U+0600-06FF, U+200C-200E, U+2010-2011, U+204F, U+2E41, U+FB50-FDFF, U+FE80-FEFC;
    }

    /* latin-ext */
    @font-face {
      font-family: 'Cairo';
      font-style: normal;
      font-weight: 400;
      font-display: swap;
      src: local('Cairo'), local('Cairo-Regular'), url(Cairofont.woff2) format('woff2');
      unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }

    body {
      background-color: #F0F8FF;
      overflow-x: hidden;
    }

    body * :not(.fa):not(.la):not(.close):not(.check-mark):not(.prev):not(.next) {
      font-family: 'Cairo', sans-serif !important;
    }

    body,
    body * :not([type="tel"]):not(.other):not(td):not(th):not(.datepicker):not(div):not(.hour):not(.prev):not(.next):not(.minute) {
      direction: rtl !important;
    }

    input[type=email],
    .form_datetime {
      direction: ltr !important;
    }
  </style>
</head>

<body>
  <?php
  if (!empty($_GET['page'])) {
    if (file_exists("pages/" . $_GET['page'])) {
      include_once("pages/" . $_GET['page']);
    } else {
      include_once("pages/home.php");
    }
  } else {
    include_once("pages/home.php");
  }
  ?>

  <!-- JS Global Compulsory -->
  <script src="./assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Front -->
</body>

</html>