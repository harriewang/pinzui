<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

wapheader();
echo "<h2>@我 (<a href='index.php?op=atreplies'>刷新</a>)</h2><ul>";

//查询
$start= ($page-1)*10;
$query = $db->query("SELECT * FROM et_content AS c LEFT JOIN et_replyto AS r ON c.content_id=r.content_id WHERE r.user_id='$user[user_id]' && c.replyshow=1 ORDER BY c.content_id DESC LIMIT $start,10");
while($data = $db->fetch_array($query)) {
    echo wapli($data[content_id],$data[user_id],$data[user_nickname],$data['content_body'],$data['posttime'],$data[type],'index.php?op=atreplies',$data['status_id'],$data['status_uname'],$data['status_unickname'],1);
}
echo "</ul>";

//分页
$total=$db->result($db->query("SELECT count(*) FROM et_content AS c LEFT JOIN et_replyto AS r ON c.content_id=r.content_id WHERE r.user_id='$user[user_id]' && c.replyshow=1 LIMIT 1"), 0);
$pg_num=ceil($row['count']/10);
if ($pg_num>1) {
    echo "<div class='page'>";
    if ($page-1>0) echo "<a href='index.php?op=atreplies&page=".($page-1)."'>上页</a>&nbsp;";
    if ($page+1<=$pg_num) echo "<a href='index.php?op=atreplies&page=".($page+1)."'>下页</a>&nbsp;";
    echo "| ".$page."/".$pg_num;
    echo "</div>";
}
?>