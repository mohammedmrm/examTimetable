<?php require_once("top.php"); ?>
<link rel="stylesheet" href="datetimepicker/css/bootstrap-datetimepicker.min.css">
<div class="col-lg-10 ">
  <!-- Post a Comment -->
  <div class="container">
    <!-- Heading -->
    <div class="text-center">
      <h2> جدول الامتحانات </h2>
    </div>
    <!-- End Heading -->
    <div class="row justify-content-lg-center">
      <div class="col-lg-12">
        <!-- Card -->
        <div class="card card-lg border shadow-none bg-light">
          <div class="card-body">
            <form id="findWorkshopForm" class="">
              <div class="d-grid gap-4 ">
                <!-- Form -->
                <div class="row">
                  <div class="col-sm-2 mb-4 mb-sm-0">
                    <label class="form-label" for="collage">الكلية</label>
                    <select class="form-control " name="collage" id="collage">
                      <option value=""> الكل </option>
                    </select>
                    <span class="text-danger" id="collage_err"></span>
                  </div>
                  <div class="col-sm-3 mb-4 mb-sm-0">
                    <label class="form-label" for="date">التاريخ</label>
                    <div class="input-group col-12">
                      <div class="input-group-prepend">
                        <label class="input-group-text text-black" onclick="removeDate()" data-toggle="tooltip" data-placement="top" title="عرض كل التواريخ">X</label>
                      </div>
                      <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="date" id="date">
                      <span class="text-danger" id="date_err"></span>
                    </div>
                  </div>
                  <div class="col-sm-2 mb-4 mb-sm-0">
                    <label class="form-label" for="type">نوع الدراسة</label>
                    <select class="form-control " name="type" id="type">
                      <option value=""> الكل </option>
                      <option value="1"> دكتوراه </option>
                      <option value="2"> ماجستير </option>
                      <option value="3"> دبلوم عالي </option>
                      <option value="4"> اولية </option>
                    </select>
                    <span class="text-danger" id="type_err"></span>
                  </div>
                  <div class="col-sm-2 mb-4 mb-sm-0">
                    <label class="form-label" for="mood">نوع الامتحان</label>
                    <select class="form-control " name="mood" id="mood">
                      <option value=""> الكل </option>
                      <option value="1"> حضوري </option>
                      <option value="2"> الكتروني </option>
                    </select>
                    <span class="text-danger" id="mood_err"></span>
                  </div>
                  <div class="col-sm-2 mb-4 mb-sm-0">
                    <label class="form-label" for="office">&nbsp;</label>
                    <button type="button" onclick="getTimetable()" class="form-control btn btn-primary ">بحث</button>
                  </div>
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
    <div class="row">
      <hr />

      <!-- Table -->
      <div class="table-responsive table-striped">
        <table id="tb-timetable" class="table" style="font-size: 12;">
          <thead class="thead-light">
            <tr>
              <th>الكلــــــــية</th>
              <th>القسم/الفرع</th>
              <th>التاريخ و الوقت</th>
              <th>نوع الامتحــــــــــــــان</th>
              <th>نوع الدراسة</th>
              <th>المرحلة</th>
              <th>عدد الممتحنين</th>
              <th> تعديل او حذف </th>
            </tr>
          </thead>
          <tbody id="timetable">

          </tbody>
        </table>
      </div>
    </div>
    <!-- End Table -->
    <div class="row">
      <div class="card-footer border-top">
        <div class="d-flex justify-content-end gap-3">
          <nav aria-label="...">
            <ul class="pagination" id="pagination">
            </ul>
            <input type="hidden" id="p" name="p" value="<?php echo !empty($_GET['p']) ? $_GET['p'] : 1; ?>" />
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- End Post a Comment -->
  <div class="modal fade" id="editExam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">تعديل بينات الامتحان</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
                      <select class="form-control form-control-lg" name="type" id="type">
                        <option value="">-- اختر --</option>
                        <option value="1">دكتوراه</option>
                        <option value="2">ماجستير</option>
                        <option value="3">دبلوم عالي</option>
                        <option value="4">دراسات اولية</option>
                      </select>
                      <span class="text-danger" id="type_err"></span>
                    </div>
                    <div class="col-sm-4">
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
                      <select class="form-control" name="attempt" id="attempt">
                        <option value=""> -- اختر -- </option>
                        <option value="1"> الدور الاول</option>
                        <option value="2"> الدور الثاني </option>
                        <option value="3"> الدور الثاني </option>
                      </select>
                      <span class="text-danger" id="attempt_err"></span>
                    </div>
                    <div class="col-sm-4">
                      <label class="form-label" for="mood"> حالة الامتحان </label>
                      <select class="form-control" name="mood" id="mood">
                        <option value="1">حضوري</option>
                        <option value="2">الكتروني</option>
                      </select>
                      <span class=" text-danger" id="mood_err"></span>
                    </div>
                    <input id="timetableId" type="hidden" name="timetableId" value="">
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- End Card -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
          <button type="button" class="btn btn-primary" onclick="saveChanges()">حفظ التغيرات</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- End Col -->
<input type="hidden" id="userId" value="<?php echo $_SESSION['userid'] ?>">
<script src="datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script>
  exams = {};
  timetable = $("#tb-timetable").DataTable({
    "oLanguage": {
      "sLengthMenu": "عرض_MENU_سجل",
      "sSearch": "بحث:"
    },
    dom: 'Bfrtip',
    buttons: [{
        extend: 'excel',
        exportOptions: {
          columns: ':visible'
        }
      },
      {
        extend: 'print',
        exportOptions: {
          columns: ':visible'
        }
      },
      'colvis'
    ]
  });
  $(document).ready(function() {
    getCollage($("#collage"));
    getCollage($("#addTimetableForm #collage"));
    getTimetable();
  });

  function removeDate() {
    $("#date").val('');
  }

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


  function getTimetable() {
    $.ajax({
      url: "script/_getTimetable.php",
      type: "POST",
      data: $("#findWorkshopForm").serialize(),
      beforeSend: function() {
        $("#timetable").addClass("loading");
      },
      success: function(res) {
        console.log(res);
        $("#timetable").html("");
        $("#pagination").html("");
        $("#timetable").removeClass("loading");
        collage = 0;
        timetable.rows({
          page: "current"
        }).remove().draw();
        exam = res.data;
        i = 0;
        $.each(res.data, function() {
          mood = "";
          type = "";
          stage = "";
          if (Number(this.collage_id) % 2 == 0) {
            bg = "success-bg";
          } else {
            bg = "danger-bg";
          }
          if (this.stage == 1) {
            stage = "الاولى";
          } else if (this.stage == 2) {
            stage = "الثانية";
          } else if (this.stage == 3) {
            stage = "الثالثة";
          } else if (this.stage == 4) {
            stage = "الرابعة";
          } else if (this.stage == 5) {
            stage = "الخامسة";
          } else if (this.stage == 6) {
            stage = "السادسة";
          }

          if (this.type == 1) {
            type = "دكتوراه"
          } else if (this.type == 2) {
            type = "ماجستير"
          } else if (this.type == 3) {
            type = "دبلوم عالي"
          } else if (this.type == 4) {
            type = "دراسات اولية"
          }

          if (this.mood == 1) {
            mood = "حضوري"
          } else {
            mood = "الكتروني"
          }
          if (this.attempt == 1) {
            attempt = "الدور الاول"
          } else {
            attempt = "الدور الثاني"
          }
          if (this.course == 1) {
            course = "الكورس الاول"
          } else {
            course = "الكورس الثاني"
          }
          btns = "";
          if (this.user_id == $("#userId").val() && this.user_id > 0) {
            btns = `<button class = "btn btn-icon text-primary" onclick="editExam(${i})" data-toggle="modal" data-target="#editExam"> تعديل </button>
                    <button class="btn btn-icon text-dange" onclick="deleteExam(${this.timetableId})">حذف</button>`
          }

          timetable.rows.add([
            [
              this.name,
              this.department + ' / ' + this.subject,
              this.dat + `<br>` + this.time,
              `${course}-${attempt} <br> ${mood}`,
              type,
              stage,
              this.students,
              btns
            ]
          ]).draw();
          i++;
        });
      },
      error: function(e) {
        $("#timetable").removeClass("loading");
        console.log(e);
      },
    });
  }

  function saveChanges() {
    var myform = document.getElementById('addTimetableForm');
    var id = exam.timetableId;
    var fd = new FormData(myform);
    fd.append('id', id);
    $.ajax({
      url: "script/_updateTimetable.php",
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
          $("#addTimetableForm input").val("");
          $("#addTimetableForm select").val("");
          Toast.success('تم التحديث');
          alert("تم التحديث");
          getTimetable();
        } else {
          $("#date_err").text(res.error["date"]);
          $("#collage_err").text(res.error["collage"]);
          $("#subject_err").text(res.error["subject"]);
          $("#department_err").text(res.error["department"]);
          $("#students_err").text(res.error["students"]);
          $("#type_err").text(res.error["type"]);
          $("#mood_err").text(res.error["mood"]);
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

  function editExam(idx) {
    $("#addTimetableForm #timetableId").val(exam[idx].timetableId);
    $("#addTimetableForm #collage").val(exam[idx].collage_id);
    $("#addTimetableForm #students").val(exam[idx].students);
    $("#addTimetableForm #type").val(exam[idx].type);
    $("#addTimetableForm #date").val(exam[idx].dat);
    $("#addTimetableForm #time").val(exam[idx].time);
    $("#addTimetableForm #mood").val(exam[idx].mood);
    $("#addTimetableForm #stage").val(exam[idx].stage);
    $("#addTimetableForm #department").val(exam[idx].department);
    $("#addTimetableForm #subject").val(exam[idx].subject);
    $("#addTimetableForm #course").val(exam[idx].course);
    $("#addTimetableForm #attempt").val(exam[idx].attempt);
  }

  function deleteExam(id) {
    if (confirm("هل انت متاكد من الحذف ")) {
      $.ajax({
        url: "script/_deleteExam.php",
        type: "POST",
        data: {
          id: id
        },
        success: function(res) {
          if (res.success == 1) {
            alert('تم الحذف');
            getTimetable();
          } else {
            Toast.warning(res.msg);
          }
          console.log(res)
        },
        error: function(e) {
          console.log(e);
        }
      });
    }
  }
</script>
<?php require_once("bottom.php"); ?>