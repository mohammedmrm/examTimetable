<?php require_once("top.php"); ?>
<link rel="stylesheet" href="datetimepicker/css/bootstrap-datetimepicker.min.css">
<!-- End Col -->
<div class="col-lg-9 bg-light">
  <!-- Post a Comment -->
  <div class="container ">
    <!-- Heading -->
    <div class="pt-4 pb-4">
      <h2>اضافة امتحان</h2>
    </div>
    <!-- End Heading -->
    <div class="row justify-content-lg-center">
      <div class="col-lg-12">
        <!-- Card -->
        <div class="card card-lg border shadow-none bg-light">
          <div class="card-body">
            <form id="addTimetableForm" class="bg-light">
              <div class="d-grid gap-4">
                <!-- Form -->
                <div class="row">
                  <?php if ($_SESSION['user_details']['role_id'] == 1) { ?>
                    <div class="col-sm-4 mb-4 mb-sm-0">
                      <label class="form-label" for="collage">الكلية</label>
                      <select class="form-control form-control-lg" name="collage" id="collage">
                        <option> -- اختر -- </option>
                      </select>
                      <span class="text-danger" id="collage_err"></span>
                    </div>
                  <?php } ?>
                  <div class="col-sm-4">
                    <label class="form-label" for="department"> اسم القسم/الفرع </label>
                    <input type="text" class="form-control form-control-lg" name="department" id="department">
                    <span class="text-danger" id="department_err"></span>
                  </div>
                  <div class="col-sm-4 mb-4 mb-sm-0">
                    <label class="form-label" for="subject">اسم المادة</label>
                    <input type="text" class="form-control form-control-lg" name="subject" id="subject">
                    <span class="text-danger" id="subject_err"></span>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="students">عدد المتحنين</label>
                    <input type="number" max="1000" class="form-control form-control-lg" name="students" id="students">
                    <span class="text-danger" id="students_err"></span>
                  </div>
                  <div class="col-sm-4 mb-4 mb-sm-0">
                    <label class="form-label" for="date">تاريخ الامتحان</label>
                    <input type="date" class="form-control form-control-lg" name="date" id="date">
                    <span class="text-danger" id="date_err"></span>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="time"> وقت الامتحان </label>
                    <input type="time" class="form-control form-control-lg" name="time" id="time">
                    <span class="text-danger" id="time_err"></span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <label class="form-label" for="url"> نوع الدراسة</label>
                    <select class="form-control form-control-lg" onchange="$(this).val() == 4 ? $('#stageDiv').show() : $('#stageDiv').hide();" name="type" id="type">
                      <option value="">-- اختر --</option>
                      <option value="1">دكتوراه</option>
                      <option value="2">ماجستير</option>
                      <option value="3">دبلوم عالي</option>
                      <option value="4">دراسات اولية</option>
                    </select>
                    <span class="text-danger" id="type_err"></span>
                  </div>
                  <div class="col-sm-4" id="stageDiv">
                    <label class="form-label" for="stage">المرحلة</label>
                    <select class="form-control form-control-lg" name="stage" id="stage">
                      <option value=""> -- اختر -- </option>
                      <option value="1"> الاولى</option>
                      <option value="2"> الثانية </option>
                      <option value="3"> الثالثة </option>
                      <option value="4"> الرابعة </option>
                      <option value="5"> الخامسة </option>
                      <option value="6"> السادسة </option>
                    </select>
                    <span class="text-danger" id="stage_err"></span>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="course">الكورس</label>
                    <select class="form-control form-control-lg" name="course" id="course">
                      <option value=""> -- اختر -- </option>
                      <option value="1"> الاول</option>
                      <option value="2"> الثاني </option>
                    </select>
                    <span class="text-danger" id="course_err"></span>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="attempt">الدور</label>
                    <select class="form-control form-control-lg" name="attempt" id="attempt">
                      <option value=""> -- اختر -- </option>
                      <option value="1"> الدور الاول</option>
                      <option value="2"> الدور الثاني </option>
                      <option value="3"> الدور الثاني </option>
                    </select>
                    <span class="text-danger" id="attempt_err"></span>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="mood"> حالة الامتحان </label>
                    <select class="form-control form-control-lg" name="mood" id="mood">
                      <option value="1">حضوري</option>
                      <option value="2">الكتروني</option>
                    </select>
                    <span class=" text-danger" id="mood_err"></span>
                  </div>
                  <div class="col-sm-4">
                    <label class="form-label" for="study_mood">الدراسة (صباحي/مسائي)</label>
                    <select class="form-control " name="study_mood" id="study_mood">
                      <option value="1"> كلاهما </option>
                      <option value="2"> الصباحي </option>
                      <option value="3"> مسائي </option>
                    </select>
                    <span class="text-danger" id="study_mood_err"></span>
                  </div>
                  <div class="col-sm-4">
                    <br>
                    <input type="checkbox" class="form-check-input" name="loading" id="loading" />
                    <label class="form-label" for="loading"> هل الامتحان للمحملين؟ </label>
                    <span class="text-danger" id="loading_err"></span>
                  </div>
                </div>
                <div class="d-grid">
                  <button type="button" onclick="addTimetable()" class="btn btn-primary btn-lg">اضافة</button>
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

<script src="datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script>
  function getCollage(elem) {
    $.ajax({
      url: "script/_getCollage.php",
      type: "POST",
      beforeSent: function() {},
      success: function(res) {
        elem.html("");
        elem.append("<option value=''>-- اختر --</option>");
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
  getCollage($("#collage"));

  function addTimetable() {
    var myform = document.getElementById('addTimetableForm');
    var fd = new FormData(myform);
    $.ajax({
      url: "script/_addTimetable.php",
      type: "POST",
      data: fd,
      processData: false, // tell jQuery not to process the data
      contentType: false,
      cache: false,
      beforeSend: function() {
        $("#addTimetableForm").addClass('loading');
      },
      success: function(res) {
        $("#addTimetableForm").removeClass('loading');
        console.log(res);
        $("#date_err").text(res.date_err);
        if (res.success == 1) {
          $("#addTimetableForm input:not(department)").val("");
          $("#addTimetableForm select").val("");
          $("#addTimetableForm span .text-dange").text("");
          Toast.success('تم الاضافة');
          alert("تم الاضافة");
        } else {
          $("#date_err").text(res.error["date"]);
          $("#collage_err").text(res.error["collage"]);
          $("#subject_err").text(res.error["subject"]);
          $("#department_err").text(res.error["department"]);
          $("#students_err").text(res.error["students"]);
          $("#type_err").text(res.error["type"]);
          $("#mood_err").text(res.error["mood"]);
          $("#study_mood_err").text(res.error["study_mood"]);
          $("#stage_err").text(res.error["stage"]);
          $("#course_err").text(res.error["course"]);
          $("#attempt_err").text(res.error["attempt"]);
          Toast.warning("هناك بعض المدخلات غير صالحة", 'خطأ');
        }

      },
      error: function(e) {
        $("#addTimetableForm").removeClass('loading');
        console.log(e);
        Toast.error('خطأ');
      }
    });
  }
</script>
<?php require_once("bottom.php"); ?>