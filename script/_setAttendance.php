<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1, 2]);
$id = $_REQUEST['id'];
$attendance = $_REQUEST['attendance'];
$success = 0;
$msg = "";
require_once("dbconnection.php");

use Violin\Violin;

require_once('../validator/autoload.php');
$v = new Violin;

$v->validate([
    'id'    => [$id, 'required|int'],
    'attendance'    => [$attendance, 'required|int'],
]);

if ($v->passes()) {
    if ($_SESSION['role'] == 1) {
        $sql = "update timetable set attendance = ? where id = ?";
        $result = setData($con, $sql, [$attendance, $id]);
    } else {
        $sql = "update timetable set attendance = ? where id = ? and user_id=?";
        $result = setData($con, $sql, [$attendance, $id, $_SESSION['userid']]);
    }
    if ($result > 0) {
        $success = 1;
    } else {
        $msg = "فشل تحديث عدد الحضور";
    }
} else {
    $msg = "فشل تحديث عدد الحضور";
    $success = 0;
}
ob_end_clean();
echo json_encode(['success' => $success, 'msg' => $msg]);
