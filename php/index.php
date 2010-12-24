<?php
include('common.inc.php');

$page=$_GET['page']?intval($_GET['page']):1;

$S = parse_url($webaddr);
if ($_SERVER["HTTP_HOST"]!=$S['host']) {
    header("location: $webaddr");
}

//删除talk 管理员和自己的信息
if ($act=="del") {
    tologin();
	$contentid=$_GET['cid'];

    $query = $db->query("SELECT user_id FROM et_content WHERE content_id='$contentid'");
    $data = $db->fetch_array($query);
    if ($my[isadmin]>0 || $data[user_id]==$my[user_id]) {
        updatereplynum($contentid); //更新回复数和消息数
        $db->query("DELETE FROM et_content WHERE content_id='$contentid'");
        $db->query("DELETE FROM et_replyto WHERE content_id='$contentid'");
        echo 'success';
    } else {
        echo '删除失败，可能您没有删除此条信息的权限！';
    }
    exit;
}

//举报
if ($action=='reportsubmit') {
    $reporttp=$_POST['reporttp'];
    $reportbd=clean_html(trim($_POST['describe']));
    $reportbd=daddslashes($reportbd);
    if ($reporttp && $reportbd) {
        $db->query("INSERT INTO et_report (user_id,user_name,reporttype,reportbody,dateline) VALUES ('$my[user_id]','$my[user_name]','$reporttp','$reportbd','$addtime')");

        dsetcookie('setok','report1');
        header("location: $webaddr/index");
        exit;
    } else {
        dsetcookie('setok','report2');
        header("location: $webaddr/index");
        exit;
    }
}

//上榜操作
if ($act=='indextop' && $my[isadmin]>0) {
    $option=$_GET['op'];
    $uname=$_GET['uname'];
    if($option=="up") {
        $db->query("UPDATE et_users SET indextop=1 WHERE user_name='$uname'");
    } else {
        $db->query("UPDATE et_users SET indextop=0 WHERE user_name='$uname'");
    }
    header("location: {$webaddr}/$uname");
    exit;
}

//大家再说什么
if ($act=='loadindex') {
    $indexnum=0;
    $start= ($page-1)*$index_num;
    $query = $db->query("SELECT * FROM et_content WHERE privacy=0 && replyshow=1 ORDER BY posttime DESC LIMIT $start,$index_num");
    while($data = $db->fetch_array($query)) {
        $indexnum++;
        $content[] = array('content_id'=>$data['content_id'],
            'user_id'=>$data['user_id'],'user_name'=>$data['user_name'],'user_nickname'=>$data['user_nickname'],'user_head'=>$data['user_head'],
            'content_body'=>ubb($data['content_body']),'posttime'=>timeop($data['posttime']),'type'=>$data['type'],'status_id'=>$data['status_id'],
            'status_uname'=>$data['status_uname'],'status_unickname'=>$data['status_unickname'],'replytimes'=>$data['replytimes'],'zftimes'=>$data['zftimes']);
    }
    echo loadindex($content);
    exit;
}

//新信息
if ($act=='getupdate') {
    $lastid=$_GET['lastid'];
    if ($lastid>0) {
        $query = $db->query("SELECT * FROM et_content WHERE privacy=0 && replyshow=1 && content_id>'$lastid'");
        while($data = $db->fetch_array($query)) {
            $content[] = array('content_id'=>$data['content_id'],
                'user_id'=>$data['user_id'],'user_name'=>$data['user_name'],'user_nickname'=>$data['user_nickname'],'user_head'=>$data['user_head'],
                'content_body'=>ubb($data['content_body']),'posttime'=>timeop($data['posttime']),'type'=>$data['type'],'status_id'=>$data['status_id'],
                'status_uname'=>$data['status_uname'],'status_unickname'=>$data['status_unickname'],'replytimes'=>$data['replytimes'],'zftimes'=>$data['zftimes']);
        }
    }
    echo loadindex($content);
    exit;
}

//上榜
$query = $db->query("SELECT user_name,nickname,user_head FROM et_users WHERE indextop=1 ORDER BY rand() LIMIT 9");
while($data = $db->fetch_array($query)) {
    $data['user_head']=$data['user_head']?"$webaddr/attachments/head/".$data['user_head']:"$webaddr/images/noavatar.jpg";
    $indextop[] = array('user_name'=>$data['user_name'],'nickname'=>$data['nickname'],'user_head'=>$data['user_head']);
}

//在线用户 放入memcache 半小时更新
$query = $db->query("SELECT user_id,user_name,nickname,user_head FROM et_users WHERE last_login>='".($addtime-36000)."' ORDER BY last_login DESC LIMIT 12");
while($data = $db->fetch_array($query)) {
    $uhead=$data[user_head]?"$webaddr/attachments/head/".$data[user_head]:"$webaddr/images/noavatar.jpg";
    $online[] = array("user_id"=>$data['user_id'],"user_name"=>$data['user_name'],"nickname"=>$data['nickname'],"user_head"=>$uhead);
}

//css文件
if (!file_exists(ET_ROOT.'/templates/cache/style.css') && is_admin_path!="yes") {
    ob_start();
    include($template->getfile('style.css.htm'));
    $cssfile = ob_get_contents();
    $cssfile = preg_replace("/([\r\n])/", '', $cssfile);
    ob_end_clean();
    $fp = fopen(ET_ROOT."/templates/cache/style.css",'w');
    fwrite($fp,$cssfile);
    fclose($fp);
}

//模板和Foot
$menu="index";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
if (!$my[user_id]) include($template->getfile('index.htm'));
else include($template->getfile('index.htm'));
?>
