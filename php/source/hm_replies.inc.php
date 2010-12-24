<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if ($user[user_id]!=$my[user_id]) header("Location: $webaddr/$my[user_name]");

//读取信息
$atnum=0;
$start= ($page-1)*$home_num;
$query = $db->query("SELECT * FROM et_content AS c LEFT JOIN et_replyto AS r ON c.content_id=r.content_id WHERE r.user_id='$my[user_id]' ORDER BY c.content_id DESC LIMIT $start,$home_num");
while($data = $db->fetch_array($query)) {
    $atnum++;
    $replies[] = array('content_id'=>$data['content_id'],
    'user_id'=>$data['user_id'],'user_name'=>$data['user_name'],'user_nickname'=>$data['user_nickname'],'user_head'=>$data['user_head'],
    'content_body'=>ubb($data['content_body']),'posttime'=>timeop($data['posttime']),'type'=>$data['type'],'status_id'=>$data['status_id'],
    'status_uname'=>$data['status_uname'],'status_unickname'=>$data['status_unickname'],'replytimes'=>$data['replytimes'],'zftimes'=>$data['zftimes'],
    'fav_id'=>$data['fav_id']);
}

if ($my['replyread']!=0) {
    $db->query("UPDATE et_users SET replyread = 0 WHERE user_id='$my[user_id]'");
}

include($template->getfile('hm_replies.htm'));
?>