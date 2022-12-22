<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1]);
require_once("dbconnection.php");
require_once("_crpt.php");

use Violin\Violin;

require_once('../validator/autoload.php');
$v = new Violin;
$success = 0;
$error = [];
$id        = $_SESSION['userid'];
$name      = $_REQUEST['name'];
$username     = $_REQUEST['username'];
$password  = $_REQUEST['password'];

$v->addRuleMessage('unique', 'القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('unique', function ($value, $input, $args) {
  $exists = getData($GLOBALS['con'], "SELECT * FROM users WHERE username ='" . $value . "' and id !='" .  $_SESSION['userid'] . "'");
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
  'id'      => [$id,      'required|int'],
  'username' => [$username,   'required|unique'],
  'password' => [$password, "min(6)|max(18)"],
]);

if ($v->passes()) {
  try {
    if (empty($password)) {
      $sql = 'update users set username=? where id=?';
      $result = setData($con, $sql, [$username, $id]);
    } else {
      $password = hashPass($password);
      $sql = 'update users set password=?, username=? where id=?';
      $result = setData($con, $sql, [$password, $username, $id]);
    }
    if ($result > 0) {
      $success = 1;
      $_SESSION['user_details']['username'] = $username;
    }
  } catch (PDOException $ex) {
    $error = $ex;
  }
} else {
  $error = [
    'id' => $v->errors()->get('id')[0],
    'username_err' => $v->errors()->get('username')[0],
    'password_err' => $v->errors()->get('password')[0],
  ];
}
ob_end_clean();
echo json_encode(['success' => $success, 'error' => $error, $_POST]);
