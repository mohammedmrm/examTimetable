<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1, 2]);
$id = $_REQUEST['id'];
$success = 0;
$msg = "";
require_once("dbconnection.php");

use Violin\Violin;

require_once('../validator/autoload.php');
$v = new Violin;

$v->validate([
   'id'    => [$id, 'required|int']
]);

if ($v->passes()) {
   if ($_SESSION['role'] == 1) {
      $sql = "delete from timetable where id = ?";
      $result = setData($con, $sql, [$id]);
   } else {
      $sql = "delete from timetable where id = ? and user_id=?";
      $result = setData($con, $sql, [$id, $_SESSION['userid']]);
   }

   if ($result > 0) {
      $success = 1;
   } else {
      $msg = "فشل الحذف";
   }
} else {
   $msg = "فشل الحذف";
   $success = 0;
}
ob_end_clean();
echo json_encode(['success' => $success, 'msg' => $msg]);
