<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

//读取talk信息
$sendnum=0;
$privacy=$_GET['privacy']==1?1:0;
$hometab=$privacy?"privacy":"home";
$start= ($page-1)*$home_num;
$query = $db->query("SELECT * FROM et_content WHERE user_id='$user[user_id]' && privacy='$privacy' && replyshow=1 ORDER BY content_id desc limit $start,$home_num");
while($data = $db->fetch_array($query)) {
    $sendnum++;
    $home[] = array('content_id'=>$data['content_id'],
        'user_id'=>$data['user_id'],'user_name'=>$data['user_name'],'user_nickname'=>$data['user_nickname'],'user_head'=>$data['user_head'],
        'content_body'=>ubb($data['content_body']),'posttime'=>timeop($data['posttime']),'type'=>$data['type'],'status_id'=>$data['status_id'],
        'status_uname'=>$data['status_uname'],'status_unickname'=>$data['status_unickname'],'replytimes'=>$data['replytimes'],'zftimes'=>$data['zftimes']);
}

include($template->getfile('hm_home.htm'));
?>