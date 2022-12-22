<?php require_once("top.php"); ?>
<link rel="stylesheet" href="datetimepicker/css/bootstrap-datetimepicker.min.css">
<!-- End Col -->
<div class="col-lg-9">
  <!-- Post a Comment -->
  <div class="container content-space-2 bg-dark">
    <!-- Heading -->
    <div class="w-md-75 w-lg-50 text-center mx-md-auto mb-5 mb-md-9">
      <h2 class="text-white">اضافة مستخدم</h2>
    </div>
    <!-- End Heading -->

    <div class="row justify-content-lg-center ">
      <div class="col-lg-11">
        <!-- Card -->
        <div class="card card-lg border shadow-none bg-light">
          <div class="card-body">
            <form id="addUserForm">
              <div class="d-grid gap-4">
                <!-- Form -->
                <div class="row">
                  <div class="col-sm-6 mb-4 mb-sm-0">
                    <label class="form-label" for="name">اسم الكامل</label>
                    <input type="text" class="form-control form-control-lg" name="name" id="name">
                    <span class="text-danger" id="name_err"></span>
                  </div>
                  <div class="col-sm-6">
                    <label class="form-label" for="username">اسم مستخدم</label>
                    <input type="text" class="form-control form-control-lg" name="username" id="username">
                    <span class="text-danger" id="username_err"></span>
                  </div>
                </div>
                <!-- End Form -->
                <div class="row">
                  <div class="col-sm-6 mb-4 mb-sm-0">
                    <label class="form-label" for="office">الكلية او المركز</label>
                    <select class="form-select form-control form-control-lg" name="office" id="office">
                      <option> -- اختر -- </option>
                    </select>
                    <span class="text-danger" id="office_err"></span>
                  </div>
                  <div class="col-sm-6 mb-4 mb-sm-0">
                    <label class="form-label" for="password">كلمة المرور</label>
                    <input type="datetime" class="form-control form-control-lg" name="password" id="password">
                    <span class="text-danger" id="password_err"></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6 mb-4 mb-sm-0">
                    <label class="form-label" for="role">نوع الحساب</label>
                    <select class="form-select form-control form-control-lg" name="role" id="role">
                      <option value="0"> -- اختر -- </option>
                      <option value="2"> مدير كلية</option>
                      <option value="1"> ادمن </option>
                    </select>
                    <span class="text-danger" id="role_err"></span>
                  </div>
                </div>
                <!-- End Form -->

                <div class="d-grid">
                  <button type="button" onclick="addUser()" class="btn btn-primary btn-lg">اضافة</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- End Card -->
      </div>
      <!-- End Col -->
    </div>
    <!-- End Row -->
  </div>
  <!-- End Post a Comment -->
</div>
<!-- End Col -->

<script src="datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script>
  function getCollage(elem) {
    $.ajax({
      url: "script/_getCollage.php",
      type: "POST",
      beforeSent: function() {},
      success: function(res) {
        elem.html("");
        elem.append("<option value=''>الكل</option>");
        $.each(res.data, function() {
          elem.append(
            "<option value='" + this.id + "'>" + this.name + "</option>"
          );
        });
        console.log(res);
      },
      error: function(e) {
        elem.append(
          "<option value='' class='bg-danger'>خطأ اتصل بمصمم النظام</option>"
        );
        console.log(e);
      },
    });
  }
  getCollage($("#office"));

  function addUser() {
    $.ajax({
      url: "script/_addUser.php",
      type: "POST",
      data: $("#addUserForm").serialize(),
      beforeSend: function() {
        $("#addUserForm").addClass('loading');
      },
      success: function(res) {
        $("#addUserForm").removeClass('loading');
        console.log(res);
        if (res.success == 1) {
          $("#addUserForm input").val("");
          Toast.success('تم الاضافة');
          alert("تم الاضافة");
          $("#name_err").text('');
          $("#password_err").text('');
          $("#username_err").text('');
          $("#role_err").text('');
          $("#office_err").text('');
        } else {
          $("#name_err").text(res.error["name_err"]);
          $("#username_err").text(res.error["username_err"]);
          $("#password_err").text(res.error["password_err"]);
          $("#role_err").text(res.error["role_err"]);
          $("#office_err").text(res.error["office_err"]);
          Toast.warning("هناك بعض المدخلات غير صالحة", 'خطأ');
        }

      },
      error: function(e) {
        $("#addUserForm").removeClass('loading');
        console.log(e);
        Toast.error('خطأ');
      }
    });
  }
</script>
<?php require_once("bottom.php"); ?>