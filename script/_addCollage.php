<?php
ob_start();
session_start();
error_reporting(0);
header('Content-Type: application/json');
require_once("_access.php");
//access([1]);
require_once("dbconnection.php");
require_once("_crpt.php");

use Violin\Violin;
require_once('../validator/autoload.php');
$v = new Violin;


$success = 0;
$error = [];
$name   = $_REQUEST['name'];

$v->addRuleMessages([
    'required' => 'الحقل مطلوب',
    'int'      => 'فقط الارقام مسموع بها',
    'min'      => 'قصير جداً',
    'max'      => 'مسموح ب {value} رمز كحد اعلى '
]);
$v->addRuleMessage('uniqueName', ' القيمة المدخلة مستخدمة بالفعل ');

$v->addRule('uniqueName', function($value, $input, $args) {
    $value  = trim($value);
    if(!empty($value)){
    $exists = getData($GLOBALS['con'],"SELECT * FROM categories WHERE name ='".$value."'");
    }else{
      $exists = 0;
    }
    return ! (bool) count($exists);
});
$v->validate([
    'name'   => [$name, 'required|max(200)|min(3)|uniqueName'],
]);

if($v->passes()) {
  $sql = 'insert into categories (name) values
                             (?)';
  $result = setData($con,$sql,[$name]);
  if($result > 0){
    $success = 1;
  }
}else{
  $error = [
           'name_err'=> implode($v->errors()->get('name')),
           ];
}
ob_end_clean();
echo json_encode(['success'=>$success, 'error'=>$error,$_POST]);
?>