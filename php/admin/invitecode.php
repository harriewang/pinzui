<?php
define('is_admin_path', 'yes');
include('../common.inc.php');

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

$page=$_GET['page']?$_GET['page']:1;
$op=$_GET['op']?$_GET['op']:"nouserd";

if ($action=='create') {
    $num=intval($_POST['cnum']);
    $num=$num>0?$num:1;
    $num=$num>10?10:$num;
    $ctime=intval($_POST['ctime']);
    $ctime=$ctime?$addtime+$ctime*86400:0;
    for($i=0;$i<$num;$i++) {
        $randStr=randStr(15);
        $db->query("INSERT INTO et_invitecode (invitecode,timeline) VALUES ('$randStr','$ctime')");
    }
    header("location: invitecode.php");
    exit;
}

if ($action=='del') {
    $codeid=$_POST['codeid'];
    $db->query("DELETE FROM et_invitecode WHERE id='$codeid'");
    header("location: invitecode.php");
    exit;
}

$start=($page-1)*20;
if ($op=='nouserd') {
    $sql="SELECT * FROM et_invitecode WHERE isused=0 ORDER BY id DESC LIMIT $start,20";
    $total=getcount('et_invitecode',array('isused'=>0));
} else {
    $sql="SELECT * FROM et_invitecode WHERE isused=1 ORDER BY id DESC LIMIT $start,20";
    $total=getcount('et_invitecode',array('isused'=>1));
}
$query = $db->query($sql);
while ($data= $db->fetch_array($query)) {
    if ($data['timeline']) {
        $timeline=gmdate("Y-m-d H:i:s",$data['timeline']+8*3600);
    } else {
        $timeline="无限制";
    }
    $isused=$data['isused']?"是":"否";
    $ivcode[] = array("id"=>$data['id'],"invitecode"=>$data['invitecode'],"timeline"=>$timeline,"isused"=>$isused);
}
$pg_num=ceil($total/20);

include($template->getfile('invitecode.htm'));
?>
