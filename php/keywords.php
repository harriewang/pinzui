<?php
include('common.inc.php');

tologin();

$p=$_GET['p']?intval($_GET['p']):1;
$q=daddslashes($_GET['q']);

if ($q) {
    $searchnum=0;
    $start= ($p-1)*$index_num;
    $query = $db->query("SELECT * FROM et_content WHERE content_body LIKE '%#$q#%' && privacy=0 && replyshow=1 ORDER BY content_id DESC LIMIT $start,$index_num");
    while($data = $db->fetch_array($query)) {
        $searchnum++;
        $content[] = array('content_id'=>$data['content_id'],
            'user_id'=>$data['user_id'],'user_name'=>$data['user_name'],'user_nickname'=>$data['user_nickname'],'user_head'=>$data['user_head'],
            'content_body'=>ubb($data['content_body']),'posttime'=>timeop($data['posttime']),'type'=>$data['type'],'status_id'=>$data['status_id'],
            'status_uname'=>$data['status_uname'],'status_unickname'=>$data['status_unickname'],'replytimes'=>$data['replytimes'],'zftimes'=>$data['zftimes']);
    }
} else {
    $query = $db->query("SELECT * FROM et_topic WHERE topictimes>0 ORDER BY topictimes DESC LIMIT 30");
    while($data = $db->fetch_array($query)) {
        $topiclist[]=array("topic"=>$data['topicname'],"num"=>$data['topictimes']);
    }
}

//模板和Foot
if ($q) {
    $web_name3="#".$q."#";
} else {
    $web_name3='热门关键词';
}
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('keywords.htm'));
?>