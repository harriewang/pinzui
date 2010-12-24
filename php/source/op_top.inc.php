<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

// 请大家将排行信息储存至memcache中
$i=0;
$query = $db->query("SELECT * FROM et_users WHERE followme_num>0 ORDER BY followme_num DESC LIMIT 10");
while($data = $db->fetch_array($query)) {
    $i++;
    $uhead=$data['user_head']?"$webaddr/attachments/head/".$data['user_head']:"$webaddr/images/noavatar.jpg";
    $followtop[] = array('i'=>$i,'user_name'=>$data['user_name'],'nickname'=>$data['nickname'],
        'user_head'=>$uhead,'followme_num'=>$data['followme_num']);
}

$j=0;
$query = $db->query("SELECT * FROM et_users WHERE msg_num>0 ORDER BY msg_num DESC LIMIT 10");
while($data = $db->fetch_array($query)) {
    $j++;
    $uhead=$data['user_head']?"$webaddr/attachments/head/".$data['user_head']:"$webaddr/images/noavatar.jpg";
    $msgtop[] = array('j'=>$j,'user_name'=>$data['user_name'],'nickname'=>$data['nickname'],
        'user_head'=>$uhead,'msg_num'=>$data['msg_num']);
}

$k=0;
$query = $db->query("SELECT * FROM et_users WHERE fav_num>0 ORDER BY fav_num DESC LIMIT 10");
while($data = $db->fetch_array($query)) {
    $k++;
    $uhead=$data['user_head']?"$webaddr/attachments/head/".$data['user_head']:"$webaddr/images/noavatar.jpg";
    $favtop[] = array('k'=>$k,'user_name'=>$data['user_name'],'nickname'=>$data['nickname'],
        'user_head'=>$uhead,'fav_num'=>$data['fav_num']);
}

//模板和Foot
$web_name3="达人排行";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_top.htm'));
?>