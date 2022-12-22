<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("dbconnection.php");
require_once("_crpt.php");
require_once("_sendEmail.php");
require_once("_vaildImg.php");

use Violin\Violin;

require_once('../validator/autoload.php');
$v = new Violin;

try {
  $success = 0;
  $error = [];
  $workshopId    = $_REQUEST['id'];
  $name    = $_REQUEST['name'];
  $sub_office   = $_REQUEST['sub_office'];
  $url   = $_REQUEST['url'];
  $des   = $_REQUEST['desc'];

  $sig1   = $_FILES['sig1'];
  $sig2  = $_FILES['sig2'];
  $cer_bg   = $_FILES['cer_bg'];
  $name1   = $_REQUEST['name1'];
  $name2   = $_REQUEST['name2'];
  $job1   = $_REQUEST['job1'];
  $job2   = $_REQUEST['job2'];

  $space  = $_REQUEST['space'];
  $paddingTop   = $_REQUEST['paddingTop'];
  $textSize  = $_REQUEST['textSize'];

  $start   = $_REQUEST['start'];
  $end   = $_REQUEST['end'];
  $seat   = $_REQUEST['seat'];
  if (empty($seat) || $seat == 0) {
    $seat = 1000;
  }
  $cat   = $_REQUEST['cat'];
  $with   = $_REQUEST['with'];
  if (empty($with)) {
    $with = 1;
  }
  $result = 0;
  //------------------==datetime validation-------------------------------
  $now = date("Y-m-d H:i:s");
  function validateDate($date, $format = 'Y-m-d H:i:s')
  {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
  }
  $start_err = "";
  $end_err = "";
  if (!validateDate($start)) {
    $start_err = "الوقت و التاريخ غير صالح";
  }
  if (!validateDate($end)) {
    $end_err = "الوقت و التاريخ غير صالح";
  }


  if ($start_err == "" && $start < $end) {
    $end_err = "";
  } else {
    $end_err = "تاريخ النهاية يجب ان يكون بعد تاريخ البدأ";
  }
  //------------------------------------------------------
  $v->addRuleMessage('isImg', 'صوره غير صالحه');
  $v->addRule('isImg', function ($value, $input, $args) {
    $x = image($value);
    return   $x;
  });

  $v->addRuleMessage('isUrl', 'الرابط المدخل غير صالح');

  $v->addRule('isUrl', function ($value, $input, $args) {
    if (filter_var($value, FILTER_VALIDATE_URL)) {
      $x = 1;
    } else {
      $x = 0;
    }
    return   $x;
  });
  $v->addRuleMessage('isPrice', 'المبلغ غير صحيح');

  $v->addRule('isPrice', function ($value, $input, $args) {
    if (preg_match("/^(0|\d*)(\.\d{2})?$/", $value)) {
      $x = (bool) 1;
    }
    return   $x;
  });
  $v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'regex'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى ',
    'email'      => 'البريد الالكتروني غيز صحيح',
  ]);

  $v->validate([
    'id'         => [$workshopId,    'required|int'],
    'name'       => [$name,    'required|min(4)|max(1000)'],
    'sub_office' => [$sub_office, 'max(1000)'],
    'des'        => [$des,   'max(3000)'],
    'url'        => [$url,   'isUrl|max(2000)'],
    'seat'       => [$seat,  'int|min(1)|max(4)'],
    'cat'        => [$cat,  'required|int'],
    'with'       => [$with,  'required|int'],
    'name1'      => [$name1,  'min(5|max(100)'],
    'name2'      => [$name2,  'min(5|max(100)'],
    'sig1'       => [$sig1,  'isImg'],
    'sig2'       => [$sig2,  'isImg'],
    'cer_bg'     => [$cer_bg, 'isImg'],
    'job1'       => [$job1,  'min(5)|max(100)'],
    'job2'       => [$job2,  'min(5)|max(100)'],
    'space'      => [$space,  'int'],
    'textSize'   => [$textSize,  'int'],
    'paddingTop' => [$paddingTop,  'int'],
  ]);

  if ($v->passes() && $start_err == "" && $end_err == "") {
    $sql = "select * from users where id=?";
    $res = getData($con, $sql, [$_SESSION['userid']]);
    $sql2 = "select * from workshops where id=?";
    $workshop = getData($con, $sql, [$id])[0];
    if ($sig1['size'] !== 0) {
      $id = uniqid() . Date('Y-m-d') .
        '-sig1' . '.' . end((explode(".", $sig1["name"])));
      $destination = "../img/" . $id;
      $up[] = move_uploaded_file($sig1["tmp_name"], $destination);
      $sql = "update workshops set sig1=? where id=?";
      unlink("../img/" . $workshop['sig1']);
      setData($con, $sql, [$id, $workshopId]);
    }
    if ($sig2['size'] !== 0) {
      $id = uniqid() . Date('Y-m-d') .
        '-sig2' . '.' . end((explode(".", $sig2["name"])));
      $destination = "../img/" . $id;
      $up[] = move_uploaded_file($sig2["tmp_name"], $destination);
      $sql = "update workshops set sig2=? where id=?";
      unlink("../img/" . $workshop['sig2']);
      setData($con, $sql, [$id, $workshopId]);
    }
    if ($cer_bg['size'] !== 0) {
      $id = uniqid() . Date('Y-m-d') .
        '-cer_bg' . '.' . end((explode(".", $cer_bg["name"])));
      $destination = "../img/" . $id;
      $up[] = move_uploaded_file($cer_bg["tmp_name"], $destination);
      unlink("../img/" . $workshop['cer_bg']);
      $sql = "update workshops set cer_bg=? where id=?";
      setData($con, $sql, [$id, $workshopId]);
    }
    if (count($res)) {
      $sql = 'update workshops set name=?, sub_office=?,with_office=?, des=?, category_id=?,
                               start_date=?, end_date=?, link=?, seat=?,
                               name1=?,name2=?,job1=?,job2=?,
                               space=?,paddingTop=?,textSize=?
                               where user_id=? and id = ?';
      $result = setDataWithLastID($con, $sql, [
        $name, $sub_office, $with, $des, $cat,
        $start, $end, $url, $seat,
        $name1, $name2, $job1, $job2,
        $space, $paddingTop, $textSize,
        $_SESSION['userid'], $workshopId
      ]);
      $success = 1;
    } else {
      $success = 0;
    }
  } else {
    $error = [
      'id_err'  => $v->errors()->get('id'),
      'name_err' => $v->errors()->get('name'),
      'des_err' => $v->errors()->get('des'),
      'url_err' => $v->errors()->get('url'),
      'cat_err' => $v->errors()->get('cat'),
      'with_err' => $v->errors()->get('with'),
      'sub_office_err' => $v->errors()->get('sub_office'),
      'seat_err' => $v->errors()->get('seat'),
      'start_err' => $start_err,
      'end_err' => $end_err,
    ];
  }
} catch (PDOException $ex) {
  $error = $ex;
  $success = 0;
}
ob_end_clean();
echo json_encode(['UP' => $up, $_FILES, $_REQUEST, 'success' => $success, "workshop" => $result, 'error' => $error]);
