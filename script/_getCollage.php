<?php
ob_start();
session_start();
header('Content-Type: application/json');
require_once("_access.php");
//access([1,2,3,4,5,6,7,8,9,10,11,12,15]);
require_once("dbconnection.php");
try {
  $query = "select * from collages";
  $data = getData($con, $query);
  $success = "1";
} catch (PDOException $ex) {
  $data = ["error" => $ex];
  $success = "0";
}
ob_end_clean();
echo (json_encode(array("success" => $success, "data" => $data)));
