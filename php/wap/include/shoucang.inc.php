<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

$favid=$_GET['sid'];
if ($favid) {
    if (!getcount('et_favorite',array('content_id'=>$favid,"sc_uid"=>$user['user_id']))) {
        $query = $db->query("SELECT content_id FROM et_content WHERE content_id='$favid'");
        $data = $db->fetch_array($query);
        if ($data['content_id']) {
            $db->query("INSERT INTO et_favorite (content_id,sc_uid) VALUES ('$data[content_id]','$user[user_id]')");
            $db->query("UPDATE et_users SET fav_num=fav_num+1 WHERE user_id='$user[user_id]'");

            showmessage("<div class='showmag'><p>话题收藏成功！</p><p><a href='index.php'>返回主页</a></p></div>");
            exit;
        } else {
            showmessage("<div class='showmag'><p>话题收藏失败！</p><p><a href='index.php'>返回主页</a></p></div>");
            exit;
        }
    } else {
        showmessage("<div class='showmag'><p>此消息已经收藏！</p><p><a href='index.php'>返回主页</a></p></div>");
        exit;
    }
} else {
    showmessage("<div class='showmag'><p>很抱歉，数据传输错误！</p><p><a href='index.php'>返回主页</a></p></div>");
    exit;
}
?>