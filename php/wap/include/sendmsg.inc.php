<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

$senduid=$_GET['uid'];
$fri=user_info("user_id='$senduid'");
if ($action=="post") {
    $msgbody=trim($_POST['msgbody']);
    $msgbody=replace($msgbody); //词语过滤
    $msgbody=daddslashes($msgbody);

    $db->query("UPDATE et_users SET priread = priread+1 WHERE user_id='$fri[user_id]'");
    $db->query("INSERT INTO et_messages (senduid,sendname,sendnickname,sendhead,sendtouid,sendtoname,sendtonickname,messagebody,sendtime) VALUES ('$user[user_id]','$user[user_name]','$user[nickname]','$user[user_head]','$fri[user_id]','$fri[user_name]','$fri[nickname]','$msgbody','$addtime')");

    showmessage("<div class='showmag'><p>给 ".$fri[nickname]." 的私信发送成功</p><p><a href='index.php'>返回主页</a></p></div>");
    exit;
}

wapheader();
echo "<h2>给 $fri[nickname] 发送私信</h2>".
"<form method='post' action='index.php?op=sendmsg&uid=$senduid'>".
"<p><input type='text' name='msgbody' value='' maxlength='140' /></p>".
"<p><input type='hidden' name='action' value='post' /><input type='submit' value='发送' /></p>".
"</form>";
?>