<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("_sendEmail.php");

use Violin\Violin;

require_once('../validator/autoload.php');
$v = new Violin;

try {
  $success = 0;
  $error = [];
  $name    = $_REQUEST['name'];
  $username   = $_REQUEST['username'];
  $password   = $_REQUEST['password'];
  $role   = $_REQUEST['role'];
  $office  = $_REQUEST['office'];
  $v->addRuleMessage('unique', 'القيمة المدخلة مستخدمة بالفعل ');

  $v->addRule('unique', function ($value, $input, $args) {
    $value  = trim($value);
    $exists = getData($GLOBALS['con'], "SELECT * FROM users WHERE username  ='" . $value . "'");
    return !(bool) count($exists);
  });

  $v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'قيمة كبيرة جداً',
    'email'      => 'البريد الالكتروني غيز صحيح',
  ]);

  $v->validate([
    'name'     => [$name,     'required|min(4)|max(50)'],
    'username' => [$username, 'required|unique'],
    'password' => [$password, 'required|min(8)|max(20)'],
    'role'     => [$role,      'required|int'],
  ]);

  if ($v->passes() && $img_err == "") {
    $activation = sha1(uniqid());
    $pass = hashPass($password);
    $sql = 'insert into users (name,username,password,role_id,collage_id) values (?,?,?,?,?)';
    $result = setDataWithLastID($con, $sql, [$name, $username, $pass, $role, $office]);
    $success = 1;
  } else {
    $success = 0;
    $error = [
      'name_err' => $v->errors()->get('name')[0],
      'username_err' => $v->errors()->get('username')[0],
      'password_err' => $v->errors()->get('password')[0],
      'role_err' => $v->errors()->get('role')[0],
    ];
  }
} catch (PDOException $ex) {
  $error = $ex;
  $success = 0;
}
ob_end_clean();
echo json_encode(['success' => $success, 'error' => $error]);
