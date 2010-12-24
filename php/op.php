<?php
include('common.inc.php');

$op = $_GET['op']?$_GET['op']:'login';

$allowviewarray=array("view","login","register","reset","faq","web","contact","top","bindmobile");
$allop=array("account","badge","faq","finder","follows","login","mailauth","bindmobile","register","reset","sendmsg","setting","share","theme","view","web","feedback","contact","im","top","guide","privatemsg");
if (!in_array($op, $allowviewarray)) {
    tologin();
}
if (in_array($op, $allop)) {
    require('source/op_'.$op.'.inc.php');
} else {
    header("location: $webaddr/op/web/404");
}
?>