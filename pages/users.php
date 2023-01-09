<?php require_once("top.php"); ?>
<link rel="stylesheet" href="./assets/vendor/tom-select/dist/css/tom-select.bootstrap5.css">
<!-- End Col -->
<div class="col-lg-9">
  <!-- Card -->
  <div class="card">
    <div class="card-header">
      <h5 class="card-header-title">المستخدمون</h5>
    </div>
    <form id="UsersForm">
      <!-- Card -->
      <div class="card card-lg border shadow-none bg-dark">
        <div class="card-body">
          <div class="d-grid gap-4">
            <!-- Form -->
            <div class="row">
              <div class="col-sm-3 mb-4 mb-sm-0">
                <label class="form-label text-white" for="name">الاسم</label>
                <input type="text" class="form-control " name="name" id="name">
                <span class="text-danger" id="name_err"></span>
              </div>
              <div class="col-sm-3 mb-4 mb-sm-0">
                <label class="form-label text-white" for="role">الصلاحية</label>
                <select class="form-control " name="role" id="role">
                  <option value=""> -- اختر -- </option>
                  <option value="2"> مدير كلية</option>
                  <option value="1"> ادمن</option>
                </select>
                <span class="text-danger" id="role_err"></span>
              </div>

              <div class="col-sm-2 mb-4 mb-sm-0">
                <label class="form-label" for="office">&nbsp;</label>
                <button type="button" onclick="getUsers()" class="form-control btn btn-primary ">بحث</button>
              </div>
            </div>



          </div>

        </div>
      </div>
      <!-- End Card -->
      <!-- Table -->
      <div class="table-responsive">
        <table style="padding: 2px;" class="table  table-bordered table-nowrape" id="users_table">
          <thead class="thead-light">
            <tr>
              <th>الاسم</th>
              <th>الصلاحية</th>
              <th>تعديل</th>
            </tr>
          </thead>

          <tbody id="usersTable">

          </tbody>
        </table>
      </div>
      <!-- End Table -->

      <!-- Footer -->
      <div class="card-footer border-top">
        <div class="d-flex justify-content-end gap-3">
          <nav aria-label="...">
            <ul class="pagination" id="pagination">

            </ul>
            <input type="hidden" id="p" name="p" value="<?php if (!empty($_GET['p'])) {
                                                          echo $_GET['p'];
                                                        } else {
                                                          echo 1;
                                                        } ?>" />
          </nav>
        </div>
      </div>
    </form>
    <!-- End Footer -->
  </div>
  <!-- End Card -->
</div>
<!-- End Col -->

<!-- Modal -->
<div class="modal fade" id="editModal" style="position: fixed !important;z-index: 1200;" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <div class="modal-close">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <hr />
      </div>
      <!-- End Header -->

      <!-- Body -->
      <div class="modal-body">
        <form id="editUserForm">
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label" for="name">الاسم الكامل</label>
                <input type="name" autocomplete="new-password" class="form-control" name="name" id="ename" placeholder="" required="">
                <span class="invalid-feedback text-danger" id="name_err"></span>
              </div>
              <div class="mb-3">
                <label class="form-label" for="username">اسم المستخدم</label>
                <input type="email" autocomplete="new-password" class="form-control" name="username" id="username" placeholder="" required="">
                <span class="invalid-feedback text-danger" id="username_err"></span>
              </div>
              <div class="mb-3">
                <label class="form-label" for="name">كلمة المرور</label>
                <input type="password" autocomplete="new-password" class="form-control" name="password" id="password" autocomplete="new-password" autocomplete="false" />
                <span class="invalid-feedback text-danger" id="password_err"></span>
              </div>
              <div class="mb-3">
                <label class=" form-label" for="role">الصلاحية</label>
                <select class="form-control " name="role" id="erole">
                  <option value=""> -- اختر -- </option>
                  <option value="2"> مدير كلية</option>
                  <option value="1"> ادمن</option>
                </select>
                <span class="text-danger" id="role_err"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <button type="button" class="btn btn-info" onclick="updateUser()">حفظ</button>
              </div>
            </div>
          </div>
          <input type="hidden" value="" name="user_id" id="user_id">
        </form>
      </div>
      <!-- End Body -->
    </div>
  </div>
</div>
<!-- End Modal -->
<input type="hidden" value="<?php echo $_GET['id']; ?>" id="workshop_id">
<script src="datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script>
  users_table = $("#users_table").DataTable({
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

  function getUsers() {
    $.ajax({
      url: "script/_getUsers.php",
      type: "POST",
      data: $("#UsersForm").serialize(),
      beforeSent: function() {
        $("#usersTable").addClass("loading");
      },
      success: function(res) {
        $("#usersTable").removeClass("loading");
        $("#usersTable").html("");
        $("#pagination").html("");
        users_table.clear().draw();
        if (res.success == 1) {
          if (res.pages >= 1) {
            if (res.page > 1) {
              $("#pagination").append(
                '<li class="page-item"><a href="#" onclick="getPage(' + (Number(res.page) - 1) + ')" class="page-link">السابق</a></li>'
              );
            } else {
              $("#pagination").append(
                '<li class="page-item disabled"><a href="#" class="page-link">السابق</a></li>'
              );
            }
            if (Number(res.pages) <= 5) {
              i = 1;
            } else {
              i = Number(res.page) - 5;
            }
            if (i <= 0) {
              i = 1;
            }
            for (i; i <= res.pages; i++) {
              if (res.page != i) {
                $("#pagination").append(
                  '<li class="page-item"><a href="#" onclick="getPage(' + (i) + ')" class="page-link">' + i + '</a></li>'
                );
              } else {
                $("#pagination").append(
                  '<li class="page-item active"><span class="page-link">' + i + '</span></li>'
                );
              }
              if (i == Number(res.page) + 5) {
                break;
              }
            }
            if (res.page < res.pages) {
              $("#pagination").append(
                '<li class="page-item"><a href="#" onclick="getPage(' + (Number(res.page) + 1) + ')" class="page-link">التالي</a></li>'
              );
            } else {
              $("#pagination").append(
                '<li class="page-item disabled"><a href="#" class="page-link">التالي</a></li>'
              );
            }
          }
          $.each(res.data, function() {
            role = ""
            if (this.role_id == 1) {
              role = "ادمن";
            } else {
              role = "مدير كلية";
            }
            users_table.rows.add(
              [
                [`<div class="d-flex align-items-center">
                        <div class="flex-grow-1 ms-3">
                          <h6 class="text-hover-primary mb-0">${this.name}</h6>
                          <small class="d-block">${this.username}</small>
                        </div>
                      </div>`,
                  role,

                  `<td style="padding: 2px;">
                      <button type="button" class="text-body btn-link btn"  data-bs-toggle="modal" data-bs-target="#editModal" onclick="editUser(${this.id})" >
                        <i class="bi-pen"></i>
                      </button>
                      <button  type="button" class="text-body btn-link btn" onclick="deleteUser(${this.id})"  data-bs-toggle="tooltip" data-bs-placement="top" title="">
                        <i class="bi-trash"></i>
                      </button>
                    </td>`
                ]
              ]
            ).draw();
          });
        }

      },
      error: function(e) {
        $("#usersTable").removeClass("loading");
        console.log(e);
      },
    });
  }
  getUsers();

  function getPage(page) {
    $("#p").val(page);
    getUsers();
  }

  function editUser(id) {
    $(".text-danger").text("");
    $("#user_id").val(id);
    $.ajax({
      url: "script/_getUser.php",
      data: {
        id: id
      },
      beforeSend: function() {
        $("#editUserForm").addClass('loading');
      },
      success: function(res) {
        $("#editUserForm").removeClass('loading');
        if (res.success == 1) {
          $.each(res.data, function() {
            $('#erole').val(this.role_id);
            $('#ename').val(this.name);
            $('#username').val(this.username);
          });
        }
        console.log(res);
      },
      error: function(e) {
        $("#editUserForm").removeClass('loading');
        console.log(e);
      }
    });
  }

  function updateUser() {
    $(".text-danger").text("");
    $.ajax({
      url: "script/_updateUser.php",
      type: "POST",
      data: $("#editUserForm").serialize(),
      beforeSend: function() {
        $("#editUserForm").addClass('loading');
      },
      success: function(res) {
        $("#editUserForm").removeClass('loading');
        console.log(res);
        if (res.success == 1) {
          Toast.success('تم التحديث');
          alert('تم التحديث');
          getUsers();
        } else {
          $("#name_err").text(res.error["name_err"]);
          $("#email_err").text(res.error["email_err"]);
          $("#password_err").text(res.error["password_err"]);
          Toast.warning("هناك بعض المدخلات غير صالحة", 'خطأ');
        }
      },
      error: function(e) {
        $("#editUserForm").removeClass('loading');
        Toast.error('خطأ');
        console.log(e);
      }
    })
  }

  function deleteUser(id) {
    if (confirm("هل انت متاكد من الحذف")) {
      $.ajax({
        url: "script/_deleteUser.php",
        type: "POST",
        data: {
          id: id
        },
        success: function(res) {
          if (res.success == 1) {
            alert('تم الحذف');
            getUsers();
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

  function ActiveUser(id) {
    $.ajax({
      url: "script/_activeUser.php",
      type: "POST",
      data: {
        id: id
      },
      success: function(res) {
        if (res.success == 1) {
          Toast.success('تم الحذف');
          getUsers();
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
</script>
<?php require_once("bottom.php"); ?>