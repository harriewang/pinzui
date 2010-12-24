<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

tologin();

if ($action=='follow') {
    $follow=$_POST['follow'];
    $follownew=array();
    for($i=0;$i<count($follow);$i++) {
        $isfriend=isfriend($follow[$i],$my[user_id]);
        if ($isfriend==0 && $follow[$i]!=$my[user_id]) $follownew[]=$follow[$i];
    }
    if($follownew) {
        for($j=0;$j<count($follownew);$j++) {
            $db->query("INSERT INTO et_friend  (fid_jieshou,fid_fasong) VALUES ('$follownew[$j]','$my[user_id]')");
            frinum($my[user_id]);
            frinum($follownew[$j]);
        }
    }
    header("location: $webaddr/op/setting");
    exit;
}

$query = $db->query("SELECT * FROM et_users WHERE user_id=1 || (followme_num>0 && lastconttime>0) ORDER BY followme_num DESC LIMIT 10");
while($data = $db->fetch_array($query)) {
    $uhead=$data['user_head']?"$webaddr/attachments/head/".$data['user_head']:"$webaddr/images/noavatar.jpg";
    $follows[] = array('user_id'=>$data['user_id'],'user_name'=>$data['user_name'],'nickname'=>$data['nickname'],
        'user_head'=>$uhead,'lastcontent'=>ubb($data['lastcontent']),'lastconttime'=>timeop($data['lastconttime']),'followme_num'=>$data['followme_num'],'msg_num'=>$data['msg_num']);
}

//模板和Foot
$web_name3="新来乍到";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_guide.htm'));
?>