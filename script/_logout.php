<?php
session_start();
session_destroy();
setcookie('username_timetable', '', time() + (86400 * 30), "/");
setcookie('password_timetable', '', time() + (86400 * 30), "/");
header("location: " . $_SERVER['HTTP_REFERER'] . "/workshops/?page=login.php");
