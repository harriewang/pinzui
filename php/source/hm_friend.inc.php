<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

//好友数据
$frilist=array();
$getfri= $db->query("SELECT fid_jieshou FROM et_friend WHERE fid_fasong='$my[user_id]'");
while($data = $db->fetch_array($getfri)) $frilist[]=$data['fid_jieshou'];
array_push($frilist,$my[user_id]);
$frilist=implode(",",$frilist);

if ($act=='getupdate') {
    $lastid=$_GET['lastid'];
    if ($lastid>0) {
        $query = $db->query("SELECT * FROM et_content WHERE user_id in ($frilist) && privacy=0 && replyshow=1 && content_id>'$lastid'");
        while($data = $db->fetch_array($query)) {
            $fricontentnew.=loadoneli($data[content_id],$data[user_name],$data[user_id],$data[user_nickname],$data[user_head],ubb($data[content_body]),timeop($data[posttime]),$data[type],$data[zftimes],$data[replytimes],0,$data[status_id],$data[status_uname],$data[status_unickname]);
        }
    }
    echo $fricontentnew;
    exit;
}

//读取信息
$fcontnum=0;
$start= ($page-1)*$home_num;
$query = $db->query("SELECT * FROM et_content WHERE user_id in ($frilist) && privacy=0 && replyshow=1 ORDER BY content_id DESC LIMIT $start,$home_num");
while($data = $db->fetch_array($query)) {
    $fcontnum++;
    $fricontent[] = array('content_id'=>$data['content_id'],
        'user_id'=>$data['user_id'],'user_name'=>$data['user_name'],'user_nickname'=>$data['user_nickname'],'user_head'=>$data['user_head'],
        'content_body'=>ubb($data['content_body']),'posttime'=>timeop($data['posttime']),'type'=>$data['type'],'status_id'=>$data['status_id'],
        'status_uname'=>$data['status_uname'],'status_unickname'=>$data['status_unickname'],'replytimes'=>$data['replytimes'],'zftimes'=>$data['zftimes'],
        'fav_id'=>$data['fav_id']);
}

include($template->getfile('hm_friend.htm'));
?>