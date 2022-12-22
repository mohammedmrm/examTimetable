<?php
ob_start();
session_start();
header('Content-Type: application/json');
$id = $_SESSION['userid'];
if(!empty($id)){
require_once("dbconnection.php");
try{
  $query = "select * from users where id=?";
  $data = getData($con,$query,[$id]);
  $success="1";
} catch(PDOException $ex) {
   $data=["error"=>$ex];
   $success="0";
}
}
ob_end_clean();
echo json_encode(array("success"=>$success,"data"=>$data));
?>