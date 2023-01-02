<?php
ob_start();
session_start();
header('Content-Type: application/json');
require_once("_access.php");
$collage = $_REQUEST['collage'];
$date = $_REQUEST['date'];
$type = $_REQUEST['type'];
$mood = $_REQUEST['mood'];
require_once("dbconnection.php");
try {

  $query = "select *,timetable.id as timetableId,
    DATE_FORMAT(timetable.date,'%Y-%m-%d') as dat,
    DATE_FORMAT(timetable.time,'%h:%i') as time
    from timetable inner join collages on collages.id = timetable.collage_id  ";
  $where = " where ";
  $filter = '';
  if (!empty($date)) {
    $filter .= " and timetable.date = '" . $date . "'";
  }
  if (!empty($collage)) {
    $filter .= " and collage_id = " . $collage;
  }
  if (!empty($type)) {
    $filter .= " and type = " . $type;
  }
  if (!empty($mood)) {
    $filter .= " and mood = " . $mood;
  }
  if ($filter !== '') {
    $filter = preg_replace('/^ and/', '', $filter);
    $query = $query . $where . $filter;
  }

  $query .= " order by collage_id";
  $data = getData($con, $query);
  $success = "1";
} catch (PDOException $ex) {
  $data = ["error" => $ex];
  $success = "0";
}
ob_end_clean();
echo json_encode(["success" => $success, "data" => $data]);
