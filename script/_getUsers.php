<?php
ob_start();
session_start();
error_reporting(0);
header("Content-Type: application/json; charset=UTF-8");
require_once("_access.php");
access([1, 2]);
ob_end_clean();
require_once("dbconnection.php");
$name = $_REQUEST["name"];
$role = $_REQUEST["role"];
$limit = 10;
$page = trim($_REQUEST['p']);
if (empty($page) || $page <= 0) {
  $page = 1;
}

try {
  $query = "select * from users ";
  $count = "select count(*) as count from users ";
  $where = " where ";
  $f = "";
  if (!empty($name)) {
    $f .= " and users.name like '%" . $name . "%' ";
  }
  if (!empty($role)) {
    $f .= " and users.role_id =" . $role;
  }
  if ($f != "") {
    $f = preg_replace('/^ and/', '', $f);
    $f = $where . " " . $f;
    $query .= " " . $f;
    $count .= " " . $f;
  }
  $res = getData($con, $count);
  $pages = ceil($res[0]['count'] / $limit);
  $lim = " limit " . (($page - 1) * $limit) . "," . $limit;
  $data = getData($con, $query . $lim);
  $success = "1";
} catch (PDOException $ex) {
  $data = ["error" => $ex];
  $success = "0";
}

echo json_encode(["success" => $success, "data" => $data, "pages" => $pages, "page" => $page]);
