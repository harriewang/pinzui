<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

//添加收藏
if ($act=='addfav') {
    tologin();
    $favid=$_GET['fid'];
    if (!getcount('et_favorite',array('content_id'=>$favid,"sc_uid"=>$my['user_id']))) {
        $queryc = $db->query("SELECT content_id,privacy FROM et_content WHERE content_id='$favid'");
        $datac = $db->fetch_array($queryc);
        if ($datac && $datac[privacy]==0) {
            $db->query("INSERT INTO et_favorite (content_id,sc_uid) VALUES ('$datac[content_id]','$my[user_id]')");
            updatefavnum("++");
            echo 'success';
        } else {
            echo '收藏的消息不存在或者不能被收藏!';
        }
    } else {
        echo '此消息已收藏过!';
    }
    exit;
}

//删除收藏
if ($act=='delfav') {
    tologin();
    $favid=$_GET['fid'];
    $db->query("DELETE FROM et_favorite WHERE fav_id='$favid' && sc_uid='$my[user_id]'");
    updatefavnum("all");
    echo 'success';
    exit;
}

//读取收藏信息
$favnum=0;
$start= ($page-1)*$home_num;
$query = $db->query("SELECT * FROM et_content AS c LEFT JOIN et_favorite AS f ON c.content_id=f.content_id WHERE f.sc_uid='$user[user_id]' && c.replyshow=1 ORDER BY c.content_id DESC LIMIT $start,$home_num");
while($data = $db->fetch_array($query)) {
    $favnum++;
    $favlist[] = array('content_id'=>$data['content_id'],
        'user_id'=>$data['user_id'],'user_name'=>$data['user_name'],'user_nickname'=>$data['user_nickname'],'user_head'=>$data['user_head'],
        'content_body'=>ubb($data['content_body']),'posttime'=>timeop($data['posttime']),'type'=>$data['type'],'status_id'=>$data['status_id'],
        'status_uname'=>$data['status_uname'],'status_unickname'=>$data['status_unickname'],'replytimes'=>$data['replytimes'],'zftimes'=>$data['zftimes'],
        'fav_id'=>$data['fav_id']);
}

include($template->getfile('hm_favorite.htm'));
?>