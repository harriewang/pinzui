<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

tologin();

$page=$_GET['page']?intval($_GET['page']):1;
$pm=(isset($_GET['pm']) && $_GET['pm']!="undefined")?$_GET['pm']:"my";

//我的信息
$my['old']=date(Y)-getsubstrutf8($my['birthday'],0,4);
if($my['home_city']=="选择省份 选择城市" || $my['home_city']=="" || $my['home_city']==" ") $my['home_city']="";
else $my['home_city']="<a href='$webaddr/op.php?op=finder&sname=&act=search&homesf=".$tem1[0]."&homecity=".$tem1[1]."'>".$tem1[0]." ".$tem1[1]."</a>";
if($my['live_city']=="选择省份 选择城市" || $my['live_city']=="" || $my['live_city']==" ") $my['live_city']="";
else $my['live_city']="<a href='$webaddr/op.php?op=finder&sname=&act=search&livesf=".$tem2[0]."&livecity=".$tem2[1]."'>".$tem2[0]." ".$tem2[1]."</a>";

if ($act=="delmsg") {
    tologin();
    $db->query("DELETE FROM et_messages WHERE (senduid ='$my[user_id]' || sendtouid ='$my[user_id]') && message_id='$_GET[mid]'");
    echo "success";
    exit;
}

$i=0;
$start= ($page-1)*$home_num;
if ($pm=="my") {
    $sql = "SELECT * FROM et_messages WHERE sendtouid='$my[user_id]' order by message_id desc limit $start,$home_num";
} elseif($pm=="send") {
    $sql = "SELECT * FROM et_messages WHERE senduid='$my[user_id]' order by message_id desc limit $start,$home_num";
}
$query = $db->query($sql);
while ($data=$db->fetch_array($query)) {
    $i++;
    $sendhead=$data['sendhead']?$data['sendhead']:"$webaddr/images/noavatar.jpg";
    $messagebody=ubb($data['messagebody']);
    $isread=$data['isread']?1:2;

    $mymsg[] = array("message_id"=>$data['message_id'],"senduid"=>$data['senduid'],"sendname"=>$data['sendname'],"sendnickname"=>$data['sendnickname'],
        "sendhead"=>$sendhead,"messagebody"=>$messagebody,"sendtouid"=>$data['sendtouid'],"sendtoname"=>$data['sendtoname'],
        "sendtonickname"=>$data['sendtonickname'],"sendtime"=>timeop($data['sendtime']),"isread"=>$isread);
}

if ($my['priread']!=0) {
    $db->query("UPDATE et_users SET priread = 0 WHERE user_id='$my[user_id]'");
    $db->query("UPDATE et_messages SET isread = 1 WHERE sendtouid='$my[user_id]'");
}

if ($pm=="my") {
    $total=getcount('et_messages',array('sendtouid'=>$my[user_id]));
} elseif($pm=="send") {
    $total=getcount('et_messages',array('senduid'=>$my[user_id]));
}

$pg_num=ceil($total/$home_num);

//模板和Foot
$web_name3='我的私信';
$menu='privatemsg';
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_privatemsg.htm'));
?>