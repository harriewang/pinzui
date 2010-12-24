<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

if($action=="reply") {
    if ($user[user_id]) {
        $replybody=trim($_POST['replybody']);
        $replybody=replace($replybody); //词语过滤
        explodetopic($replybody); //专题
        $back=atsend($replybody); //@
        $replybody=$back['content'];
        $uids=$back['uids'];
        $replybody=daddslashes($replybody);
        array_push($uids,$_POST['suid']);
        $uids=array_unique($uids);

        $status_id=$_POST['status_id'];
        if ($replybody && $status_id) {
            $db->query("INSERT INTO et_content (user_id,user_name,user_nickname,user_head,content_body,posttime,type,status_id) VALUES ('$user[user_id]','$user[user_name]','$user[nickname]','$user[user_head]','$replybody','$addtime','手机','$status_id')");
            $insertid=mysql_insert_id();
            if ($insertid) {
                for($i=0;$i<count($uids);$i++) {
                    $db->query("UPDATE et_users SET replyread = replyread+1 WHERE user_id='$uids[$i]'");
                    $db->query("INSERT INTO et_replyto (user_id,content_id) VALUES ('$uids[$i]','$insertid')");
                }
                $db->query("UPDATE et_users SET msg_num=msg_num+1,lastcontent='$replybody',lastconttime='$addtime' where user_id='$user[user_id]'");
                $db->query("UPDATE et_content SET replytimes=replytimes+1 where content_id='$status_id'");
            }
            showmessage("<div class='showmag'><p>恭喜您，回复成功！</p><p><a href='index.php'>返回主页</a></p></div>");
            exit;
        } else {
            showmessage("<div class='showmag'><p>回复失败，您没有填写回复的内容！</p><p><a href='index.php'>返回主页</a></p></div>");
            exit;
        }
    } else {
        showmessage("<div class='showmag'><p>回复失败，可能没有登陆成功或者浏览器不支持！</p><p><a href='index.php'>返回主页</a></p></div>");
        exit;
    }
}

$status_id=$_GET['status_id'];
$query = $db->query("SELECT * FROM et_content WHERE content_id='$status_id'");
$data = $db->fetch_array($query);
wapheader();
echo "<h2>给 $data[user_nickname] 回复</h2>".
"<form method='post' action='index.php?op=reply'>".
"<p>@{$data[user_nickname]}<br/><input type='text' name='replybody' value='' maxlength='140' /></p>".
"<p><input type='hidden' name='suid' value='$data[user_id]' /><input type='hidden' name='status_id' value='$status_id' /><input type='hidden' name='action' value='reply' /><input type='submit' value='发送' /> or <a href='index.php'>返回</a></p>".
"</form>";
?>