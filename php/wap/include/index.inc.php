<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

//发送消息
if($action=="post") {
	$cbody=trim($_POST['cbody']);
    $privacy = $_POST["privacy"]?1:0;
    $cbody=replace($cbody); //词语过滤
    explodetopic($cbody); //专题
    $back=atsend($cbody); //@
    $cbody=$back['content'];
    $uids=$back['uids'];
    $cbody=daddslashes($cbody);

    if ($user['user_id']) {
        if (!$cbody) {
            showmessage("<div class='showmag'><p>您没有填写发表的内容</p><a href='index.php'>返回首页</a></p></div>");
            exit;
        } else {
            $db->query("INSERT INTO et_content (user_id,user_name,user_nickname,user_head,content_body,posttime,type,privacy) VALUES ('$user[user_id]','$user[user_name]','$user[nickname]','$user[user_head]','$cbody','$addtime','手机','$privacy')");
            $insertid=mysql_insert_id();
            if ($insertid) {
                for($i=0;$i<count($uids);$i++) {
                    $db->query("UPDATE et_users SET replyread = replyread+1 WHERE user_id='$uids[$i]'");
                    $db->query("INSERT INTO et_replyto (user_id,content_id) VALUES ('$uids[$i]','$insertid')");
                }
                if ($privacy==1) {
                    $db->query("UPDATE et_users SET msg_num=msg_num+1,lastcontent='$cbody',lastconttime='$addtime' WHERE user_id='$user[user_id]'");
                }
            }
            showmessage("<div class='showmag'><p>恭喜您，发表成功！</p><p><a href='index.php'>返回首页</a></p></div>");
            exit;
        }
	} else {
        showmessage("<div class='showmag'><p>发表失败，可能没有登陆成功或者浏览器不支持！</p><p><a href='index.php'>返回首页</a></p></div>");
        exit;
	}
}

wapheader();
echo "<h2>你在做什么？</h2><form method='post' action='index.php'><p><input type='text' name='cbody' value='' maxlength='140' /></p>".
"<p><input type='checkbox' id='privacy' name='privacy' value='1'><label for='privacy'>只自己看</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type='hidden' name='action' value='post' /><input type='submit' value='发送' /></p></form><h2>最新消息(<a href='index.php'>刷新</a>) | <a href='index.php?op=myfriends'>关注动态</a></h2><ul>";

$start= ($page-1)*10;
$query = $db->query("SELECT * FROM et_content WHERE privacy=0 && replyshow=1 ORDER BY content_id DESC LIMIT $start,10");
while($data = $db->fetch_array($query)) {
    echo wapli($data[content_id],$data[user_id],$data[user_nickname],$data['content_body'],$data['posttime'],$data[type],'index.php',$data['status_id'],$data['status_uname'],$data['status_unickname'],1);
}
echo "</ul>";

//分页
$total=getcount("et_content",array("privacy"=>0,"replyshow"=>1));
$pg_num=ceil($total/10);
if ($pg_num>1) {
    echo "<div class='page'>";
    if ($page-1>0) echo "<a href='index.php?op=index&page=".($page-1)."'>上页</a>&nbsp;";
    if ($page+1<=$pg_num) echo "<a href='index.php?op=index&page=".($page+1)."'>下页</a>&nbsp;";
    echo "| ".$page."/".$pg_num;
    echo "</div>";
}
?>