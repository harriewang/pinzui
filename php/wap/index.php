<?php
error_reporting(7);
define('IN_ET', TRUE);
include('../include/etfunctions.func.php');
include('../include/db_mysql.class.php');
include('../config.inc.php');
$db = new dbstuff;
$db->connect($server,$db_username,$db_password,$db_name, $pconnect,true);
@mysql_query("set names utf8");
include('include/global.func.php');

//if(preg_match('/(mozilla|m3gate|winwap|openwave|Opera)/i', $_SERVER['HTTP_USER_AGENT']) && !preg_match('/(SymbianOS)/i', $_SERVER['HTTP_USER_AGENT'])) {
//	header("Location: ../index.php");
//}

$op=$_GET['op']?$_GET['op']:"index";
$addtime=time();
$action=$_POST['action'];
$act=$_GET['act'];
$page=$_GET['page']?$_GET['page']:1;

//login
$ulmtem=explode("\t",authcode($_COOKIE["wapcookie"],'DECODE'));
if ($ulmtem) {
	$query = $db->query("SELECT user_id,user_name,nickname,user_head FROM et_users where user_id='$ulmtem[0]' && password='$ulmtem[1]'");
	$user = $db->fetch_array($query);
    $user['user_head']=$user['user_head']?"$webaddr/attachments/head/".$user['user_head']:"$webaddr/images/noavatar.jpg";
}

if (!$user['user_id']) $head="贫嘴手机版";
else $head="欢迎您，".$user['nickname'];

if (!$user['user_id'] && $op=="index") $op="login";

include('include/'.$op.'.inc.php');

if ($user['user_id'] && $op!="logout") {
    echo "<div class=\"bottomline\">".
        "<a href='index.php?op=index'>首页</a> | ".
        "<a href='index.php?op=home'>空间</a> | ".
        "<a href='index.php?op=atreplies'>@我</a> | ".
        "<a href='index.php?op=myfriends'>动态</a> | ".
        "<a href='index.php?op=privatemsg'>私信</a><br/>".
        "<a href='index.php?op=privacy'>隐私信息</a> | ".
        "<a href='index.php?op=friends'>关注</a> | ".
        "<a href='index.php?op=sendphoto'>发照片</a> | ".
        "<a href='index.php?op=login&act=logout'>退出</a></div>";
}
wapfooter();
?>