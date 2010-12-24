<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

wapheader();
echo "<h2>你在做什么？</h2>".
"<form method='post' action='index.php'>".
"<p><input type='text' name='cbody' value='' maxlength='140' /></p>".
"<p><input type='checkbox' name='privacy' value='1'><font size='2'>只自己看</font>&nbsp;&nbsp;&nbsp;&nbsp;<input type='hidden' name='action' value='post' /><input type='submit' value='发送' /></p>".
"</form>".
"<h2><a href='index.php'>最新消息</a> | 关注动态(<a href='index.php?op=myfriends'>刷新</a>)</h2>".
"<ul>";

$start= ($page-1)*10;
$query = $db->query("SELECT * FROM et_content AS c LEFT JOIN et_friend AS f ON c.user_id=f.fid_jieshou WHERE f.fid_fasong='$user[user_id]' && c.privacy=0  && c.replyshow=1 ORDER BY c.content_id DESC LIMIT $start,10");
while($data = $db->fetch_array($query)) {
    echo wapli($data[content_id],$data[user_id],$data[user_nickname],$data['content_body'],$data['posttime'],$data[type],'index.php?op=myfriends',$data['status_id'],$data['status_uname'],$data['status_unickname'],1);
}
echo "</ul>";

//分页
$total = $db->result($db->query("SELECT count(*) FROM et_content AS c LEFT JOIN et_friend AS f ON c.user_id=f.fid_jieshou WHERE f.fid_fasong='$user[user_id]' && c.privacy=0 && c.replyshow=1"),0);
$pg_num=ceil($total/10);
if ($pg_num>1) {
    echo "<div class='page'>";
    if ($page-1>0) echo "<a href='index.php?op=myfriends&page=".($page-1)."'>上页</a> | ";
    if ($page+1<=$pg_num) echo "<a href='index.php?op=myfriends&page=".($page+1)."'>下页</a>&nbsp;";
    echo "| ".$page."/".$pg_num;
    echo "</div>";
}
?>