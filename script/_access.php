<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once("dbconnection.php");

if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
  $link = "https";
} else {
  $link = "http";
}
// Here append the common URL characters.
$link .= "://";

// Append the host(domain name, ip) to the URL.
$link .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$link .= $_SERVER['REQUEST_URI'];

function access($access_roles = [])
{
  if (!empty($_COOKIE['username_timetable']) && !empty($_COOKIE['password_timetable'])) {
    $sql = "select * from users where username = ? and password =?";
    $result = getData($GLOBALS['con'], $sql, [$_COOKIE['username_timetable'], $_COOKIE['password_timetable']]);
  }
  if (count($result) > 0) {
    $_SESSION['login'] = 1;
    $_SESSION['username'] = $result[0]['username'];
    $_SESSION['userid'] = $result[0]['id'];
    $_SESSION['role'] = $result[0]['role_id'];
    $_SESSION['user_details'] = $result[0];
  }
  if (!in_array($_SESSION['user_details']['role_id'], $access_roles) || !isset($_SESSION['userid'])) {
    header("location: login.php");
    die("<h1>لاتمتلك صلاحيات الوصول لهذه الصفحة  (<a href='./login.php'>سجل الدخول</a>)</h1>");
  }
}
