<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

wapheader();
echo "<h2>我的隐私消息</h2><ul>";

$i=0;
$start= ($page-1)*10;
$query = $db->query("SELECT * FROM et_content WHERE user_id='$user[user_id]' && privacy=1 ORDER BY content_id DESC LIMIT $start,10");
while($data = $db->fetch_array($query)) {
    $i++;
    echo wapli($data[content_id],$data[user_id],$data[user_nickname],"[".($i+($page-1)*10)."].".$data['content_body'],$data['posttime'],$data[type],'index.php?op=privacy',$data['status_id'],$data['status_uname'],$data['status_unickname'],0,1);
}
if($i==0) {
    echo "暂时还没有隐私信息！";
}
echo "</ul>";

//分页
$total=getcount("et_content",array("user_id"=>$user[user_id],"privacy"=>1));
$pg_num=ceil($total/10);
if ($pg_num>1) {
    echo "<div class='page'>";
    if ($page-1>0) echo "<a href='index.php?op=privacy&page=".($page-1)."'>上页</a>&nbsp;";
    if ($page+1<=$pg_num) echo "<a href='index.php?op=privacy&page=".($page+1)."'>下页</a>&nbsp;";
    echo "| ".$page."/".$pg_num;
    echo "</div>";
}
?>