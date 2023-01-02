<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1, 2]);
require_once("dbconnection.php");
require_once("_crpt.php");

use Violin\Violin;

require_once('../validator/autoload.php');
$v = new Violin;
$success = 0;
$error = [];
$id        = $_REQUEST['user_id'];
$name      = $_REQUEST['name'];
$username     = $_REQUEST['username'];
$password  = $_REQUEST['password'];
$role  = $_REQUEST['role'];

$v->addRuleMessage('unique', 'القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('unique', function ($value, $input, $args) {
  $exists = getData($GLOBALS['con'], "SELECT * FROM users WHERE username ='" . $value . "' and id !='" . $GLOBALS['id'] . "'");
  return  !(bool) count($exists);
});
$v->addRuleMessages([
  'required' => 'الحقل مطلوب',
  'int'      => 'فقط الارقام مسموع بها',
  'regex'      => 'فقط الارقام مسموح بها',
  'min'      => 'قصير جداً',
  'max'      => 'مسموح ب {value} رمز كحد اعلى ',
  'email'      => 'البريد الالكتروني غيز صحيح',
]);

$v->validate([
  'id'       => [$id,       'required|int'],
  'name'     => [$name,     'required|min(4)|max(200)'],
  'username' => [$username, 'required|unique'],
  'password' => [$password, "min(6)|max(18)"],
  'role'     => [$role,     "required|int"],
]);

if ($v->passes()) {
  try {
    if (empty($password)) {
      $sql = 'update users set name = ?, username=?, role_id=? where id=?';
      $result = setData($con, $sql, [$name, $username, $role, $id]);
    } else {
      $password = hashPass($password);
      $sql = 'update users set password=? , name = ?, username=?, role_id=? where id=?';
      $result = setData($con, $sql, [$password, $name, $username, $role, $id]);
    }
    if ($result > 0) {
      $success = 1;
    }
  } catch (PDOException $ex) {
    $error = $ex;
  }
} else {
  $success = 0;
  $error = [
    'name_err' =>  $v->errors()->get('name')[0],
    'id_err' =>  $v->errors()->get('id')[0],
    'username_err' =>  $v->errors()->get('username')[0],
    'password_err' => $v->errors()->get('password')[0],
    'role_err' => $v->errors()->get('role')[0],
  ];
}
ob_end_clean();
echo json_encode(['success' => $success, 'error' => $error, $_POST, $result]);
