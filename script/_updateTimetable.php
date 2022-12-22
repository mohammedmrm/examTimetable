<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("dbconnection.php");
require_once('../validator/autoload.php');

use Violin\Violin;

$v = new Violin;

try {
    $success = 0;
    $error = [];
    $id    = $_REQUEST['timetableId'];
    $collage    = $_SESSION['role'] == 1 ? $_REQUEST['collage'] : $_SESSION['user_details']['collage_id'];
    $department = $_REQUEST['department'];
    $students   = $_REQUEST['students'];
    $date   = $_REQUEST['date'];
    $time   = $_REQUEST['time'];
    $subject = $_REQUEST['subject'];
    $type = $_REQUEST['type'];
    $stage = $type == 4 ? $_REQUEST['stage'] : 0;
    $mood = $_REQUEST['mood'];
    $course = $_REQUEST['course'];
    $attempt = $_REQUEST['attempt'];

    $result = 0;
    //------------------==datetime validation-------------------------------
    function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    $date_err = "";
    if (!validateDate($date)) {
        $start_err = "التاريخ غير صالح";
    }

    $v->addRuleMessages([
        'required' => 'الحقل مطلوب',
        'int'      => 'فقط الارقام مسموع بها',
        'regex'    => 'فقط الارقام مسموع بها',
        'min'      => 'قصير جداً',
        'max'      => 'كبير جدأً',
        'email'    => 'البريد الالكتروني غيز صحيح',
    ]);

    $v->validate([
        'id'         => [$id,    'required|int'],
        'collage'    => [$collage,    'required|int'],
        'department' => [$department, 'required|max(1000)'],
        'subject'    => [$subject,    'required|max(500)'],
        'students'   => [$students,   'required|int'],
        'type'       => [$type,       'required|int'],
        'mood'       => [$mood,       'required|int'],
        'stage'      => [$stage,      'int'],
        'course'     => [$course,     'required|int'],
        'attempt'    => [$attempt,    'required|int'],
    ]);

    if ($v->passes() && $start_err == "" && $end_err == "") {
        $sql = "select * from users where id=?";
        $res = getData($con, $sql, [$_SESSION['userid']]);
        if (count($res)) {
            $sql = 'update timetable set 
            collage_id = ?,
            department = ?,
            subject = ?,
            students = ?,
            date = ? ,
            time = ? ,
            type = ? ,
            stage = ? ,
            course = ? ,
            attempt = ?,
            mood = ?
            where user_id =? and id=?';
            $result = setDataWithLastID(
                $con,
                $sql,
                [$collage, $department, $subject, $students, $date, $time, $type, $stage, $course, $attempt, $mood, $_SESSION['userid'], $id]
            );
            $success = 1;
        } else {
            $success = 0;
        }
    } else {
        $error = [
            "id" => $v->errors()->get('id'),
            "collage" => $v->errors()->get('collage'),
            "department" => $v->errors()->get('department'),
            "subject" => $v->errors()->get('subject'),
            "type" => $v->errors()->get('type'),
            "students" => $v->errors()->get('studnts'),
            "mood" => $v->errors()->get('mood'),
            "stage" => $v->errors()->get('stage'),
            "course" => $v->errors()->get('course'),
            "attempt" => $v->errors()->get('attempt'),
            "date" => $date_err,

        ];
    }
} catch (PDOException $ex) {
    $error = $ex;
    $success = 0;
}
ob_end_clean();
echo json_encode(['date_err' => $date_err, $_REQUEST, 'success' => $success, "timetable" => $result, 'error' => $error]);
