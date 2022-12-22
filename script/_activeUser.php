<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
access([1]);
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
    try {
        $sql = "update users set active=1 where id = ?";
        $result = setData($con, $sql, [$id]);
        if ($result > 0) {
            $success = 1;
        } else {
            $msg = "فشل التفعيل";
        }
    } catch (PDOException $ex) {
        $msg = $ex;
    }
} else {
    $msg = "فشل التفعيل";
    $success = 0;
}
ob_end_clean();
echo json_encode(['success' => $success, 'msg' => $msg]);
