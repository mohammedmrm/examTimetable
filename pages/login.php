<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required Meta Tags Always Come First -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Title -->
  <title>Login Simple | Front - Multipurpose Responsive Template</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="./favicon.ico">

  <!-- Font -->
  <link href="@@vars.googleFont" rel="stylesheet">

  <!-- CSS Implementing Plugins -->
  <!-- bundlecss:vendor [.] -->
  <link rel="stylesheet" href="./node_modules/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.css">

  <!-- CSS Front Template -->
  <!-- bundlecss:theme [.] @@vars.version -->
  <link rel="stylesheet" href="./assets/css/theme.min.css">
</head>

<body>

  <!-- ========== MAIN CONTENT ========== -->
  <main id="content" role="main">
    <!-- Form -->
    <div class="container content-space-3 content-space-t-lg-4 content-space-b-lg-3">
      <div class="flex-grow-1 mx-auto" style="max-width: 28rem;">
        <!-- Heading -->
        <div class="text-center mb-5 mb-md-7">
          <h1 class="h2">مرحباً بك</h1>
          <p>سجل الدخول لادارة حسابك</p>
        </div>
        <!-- End Heading -->

        <!-- Form -->
        <form class="js-validate needs-validation" novalidate id="loginForm">
          <!-- Form -->
          <div class="mb-4">
            <span id="msg" class="text-danger"></span>
          </div>
          <div class="mb-4">
            <label class="form-label" for="username">البريد الالكتروني</label>
            <input type="email" class="form-control form-control-lg" name="email" id="username" placeholder="email@site.com" aria-label="email@site.com" required>
            <span class="invalid-feedback">الرجأ ادخال بريد الكتروني صالح</span>
          </div>
          <!-- End Form -->

          <!-- Form -->
          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
              <label class="form-label" for="password">كلمة المرور</label>

            </div>

            <div class="input-group input-group-merge" data-hs-validation-validate-class>
              <input type="password" class="js-toggle-password form-control form-control-lg" name="password" id="password" placeholder="" aria-label="" required minlength="8" data-hs-toggle-password-options='{
                     "target": "#changePassTarget",
                     "defaultClass": "bi-eye-slash",
                     "showClass": "bi-eye",
                     "classChangeTarget": "#changePassIcon"
                   }'>
              <a id="changePassTarget" class="input-group-append input-group-text" href="javascript:;">
                <i id="changePassIcon" class="bi-eye"></i>
              </a>
            </div>

            <span class="invalid-feedback">ادخل كلمة مرور صحيحة</span>
          </div>
          <!-- End Form -->

          <div class="d-grid mb-3">
            <button type="button" onclick="login()" class="btn btn-primary btn-lg">سجل الدخول</button>
          </div>
        </form>
        <!-- End Form -->
      </div>
    </div>
    <!-- End Form -->
  </main>

  <!-- JS Global Compulsory @@deleteLine:build -->
  <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JS Implementing Plugins -->
  <!-- bundlejs:vendor [.] -->
  <script src="./assets/vendor/hs-header/dist/hs-header.min.js"></script>
  <script src="./assets/vendor/hs-mega-menu/dist/hs-mega-menu.min.js"></script>
  <script src="./assets/vendor/hs-show-animation/dist/hs-show-animation.min.js"></script>
  <script src="./assets/vendor/hs-go-to/dist/hs-go-to.min.js"></script>
  <script src="./assets/vendor/hs-toggle-password/dist/js/hs-toggle-password.js"></script>

  <!-- JS Front -->
  <!-- bundlejs:theme [.] -->

  <!-- JS Plugins Init. -->
  <script>
    (function() {
      // INITIALIZATION OF HEADER
      // =======================================================
      new HSHeader('#header').init()


      // INITIALIZATION OF MEGA MENU
      // =======================================================
      new HSMegaMenu('.js-mega-menu', {
        desktop: {
          position: 'left'
        }
      })


      // INITIALIZATION OF SHOW ANIMATIONS
      // =======================================================
      new HSShowAnimation('.js-animation-link')


      // INITIALIZATION OF BOOTSTRAP VALIDATION
      // =======================================================
      HSBsValidation.init('.js-validate', {
        onSubmit: data => {
          data.event.preventDefault()
          alert('Submited')
        }
      })


      // INITIALIZATION OF BOOTSTRAP DROPDOWN
      // =======================================================
      HSBsDropdown.init()


      // INITIALIZATION OF GO TO
      // =======================================================
      new HSGoTo('.js-go-to')


      // INITIALIZATION OF TOGGLE PASSWORD
      // =======================================================
      new HSTogglePassword('.js-toggle-password')
    })();

    function login() {
      $.ajax({
        url: "script/_login.php",
        type: "POST",
        data: {
          username: $("#username").val(),
          password: $("#password").val()
        },
        beforeSend: function() {
          $("#loginForm").addClass("loading");
        },
        success: function(res) {
          $("#loginForm").removeClass("loading");
          console.log(res);
          if (res.msg == 1) {
            window.location.href = "?page=home.php";
          } else if (res.msg == 2) {
            $("#loginForm").html("<h2>يرجى تأكيد البريد الالكتروني اولاً.</h2> <button class='btn btn-info' type='button' onclick='resendEmail(\"" + $("#username").val() + "\")'>اعادة ارسال</button><br /> او قم بأعادة<a href='index.php?page=login.php'> تسجيل الدخول</a>");
          } else {
            $("#msg").text(res.msg);
          }
        },
        error: function(e) {
          $("#loginForm").removeClass("loading");
          console.log(e.responseText);
        }
      });
    }

    function resendEmail(email) {
      $.ajax({
        url: "script/_resendActiveLink.php",
        type: "POST",
        data: {
          email: email
        },
        beforeSend: function() {
          $("#loginForm").addClass("loading");
        },
        success: function(res) {
          console.log(res);
          $("#loginForm").removeClass("loading");
          if (res.success == 1) {
            Toast.success('تم اعادة ارسال البريد الالكتروني');
          } else {
            Toast.warning('حاول مرة اخرى');
          }
        },
        error: function(e) {
          $("#loginForm").removeClass("loading");
          console.log(e);
        }
      });
    }
  </script>
</body>

</html>