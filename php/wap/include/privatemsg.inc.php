<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

//删除确认
if($act=="delpmsg") {
    $mid = trim($_GET["mid"]);
    showmessage("<div class='showmag'><p>是否确认删除此条私信？</p><p><a href='index.php?op=privatemsg&act=delpmsgok&mid=$mid'>确认</a> <a href='index.php?op=privatemsg'>取消</a></p></div>");
    exit();
}

//删除OK
if($act=="delpmsgok") {
    $mid = trim($_GET["mid"]);
    $db->query("DELETE FROM et_messages WHERE (senduid ='$user[user_id]' || sendtouid ='$user[user_id]') && message_id='$mid'");

    showmessage("<div class='showmag'><p>恭喜您，私信删除成功！</p><p><a href='index.php?op=privatemsg'>返回私信页面</a></p></div>");
    exit();
}

$pmtp=$_GET['pmtp']?$_GET['pmtp']:"my";

wapheader();
if ($pmtp=="my") echo "<h2>我收到的私信 | <a href='index.php?op=privatemsg&pmtp=send'>我发出的私信</a></h2>";
else if ($pmtp=="send") echo "<h2><a href='index.php?op=privatemsg'>我收到的私信</a> | 我发出的私信</h2>";

//查询
$start= ($page-1)*10;
if ($pmtp=="my") {
    $sql = "SELECT * FROM et_messages WHERE sendtouid='$user[user_id]' order by message_id desc limit $start,10";
} else {
    $sql = "SELECT * FROM et_messages WHERE senduid='$user[user_id]' order by message_id desc limit $start,10";
}
$query = $db->query($sql);
while ($data=$db->fetch_array($query)) {
    $messagebody=wapreplace($data['messagebody']);
    if ($pmtp=="my") echo "<li>来自:";
    else echo "<li>发给:";
    echo "<a href='index.php?op=home&uid={$data[senduid]}'>{$data[sendnickname]}</a> $messagebody <span class='stamp'>".timeop($data['sendtime'])." <a href='index.php?op=privatemsg&act=delpmsg&mid={$data[message_id]}'>删除</a></span></li>";
}
echo "</ul>";

//分页
if ($pmtp=="my") {
    $total=getcount('et_messages',array('sendtouid'=>$user[user_id]));
} else {
    $total=getcount('et_messages',array('senduid'=>$user[user_id]));
}
$pg_num=ceil($total/10);
if ($pg_num>1) {
    echo "<div class='page'>";
    if ($page-1>0) echo "<a href='index.php?op=privatemsg&pmtp=$pmtp&page=".($page-1)."'>上页</a>&nbsp;";
    if ($page+1<=$pg_num) echo "<a href='index.php?op=privatemsg&pmtp=$pmtp&page=".($page+1)."'>下页</a>&nbsp;";
    echo "| ".$page."/".$pg_num;
    echo "</div>";
}
?>