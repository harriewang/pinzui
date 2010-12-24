<?php
include('common.inc.php');

tologin();

$page=$_GET['p']?intval($_GET['p']):1;

$q=daddslashes($_GET['q']);
$type=$_GET['t']?$_GET['t']:"s1";
if ($act=="search" && $q) {
    $searchnum=0;
    $start= ($page-1)*$index_num;
    if ($type=="s1") {
        $query = $db->query("SELECT * FROM et_content WHERE content_body LIKE '%$q%' && privacy=0 && replyshow=1 ORDER BY content_id DESC LIMIT $start,$index_num");
    } elseif ($type=="s2") {
        $query = $db->query("SELECT * FROM et_content WHERE content_body LIKE '%$q%' && user_id='$my[user_id]' && privacy=0 && replyshow=1 ORDER BY content_id DESC LIMIT $start,$index_num");
    }
    while($data = $db->fetch_array($query)) {
        $searchnum++;
        $content[] = array('content_id'=>$data['content_id'],
            'user_id'=>$data['user_id'],'user_name'=>$data['user_name'],'user_nickname'=>$data['user_nickname'],'user_head'=>$data['user_head'],
            'content_body'=>ubb($data['content_body']),'posttime'=>timeop($data['posttime']),'type'=>$data['type'],'status_id'=>$data['status_id'],
            'status_uname'=>$data['status_uname'],'status_unickname'=>$data['status_unickname'],'replytimes'=>$data['replytimes'],'zftimes'=>$data['zftimes']);
    }
    //搜索统计
    if ($q && $searchnum>0) {
        if (getcount('et_search',array('searchcont'=>$q))==0) {
            $db->query("INSERT INTO et_search (searchcont,searchtimes) VALUES ('$q','1')");
        } else {
            $db->query("UPDATE et_search SET searchtimes=searchtimes+1 WHERE searchcont='$q'");
        }
    }
}

//模板和Foot
$web_name3="站内搜索";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('search.htm'));
?>