<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

function get_ip() {
    if ($_SERVER) {
        if ( $_SERVER[HTTP_X_FORWARDED_FOR] ) {
            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif ( $_SERVER["HTTP_CLIENT_ip"] ) {
            $realip = $_SERVER["HTTP_CLIENT_ip"];
        } else {
            $realip = $_SERVER["REMOTE_ADDR"];
        }
    } else {
        if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
            $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
        } elseif ( getenv( 'HTTP_CLIENT_ip' ) ) {
            $realip = getenv( 'HTTP_CLIENT_ip' );
        } else {
            $realip = getenv( 'REMOTE_ADDR' );
        }
    }
    return $realip;
}

tologin();

$page=$_GET['page']?$_GET['page']:1;

if ($action=='feedback') {
    $fbtype=$_POST['fbtype'];
    $fbbody=daddslashes(clean_html($_POST['feedbody']));
    $contect=daddslashes(clean_html($_POST['contect']));

    if ($fbtype && $fbbody && $contect) {
        $db->query("INSERT INTO et_feedback (uid,uname,unickname,uhead,fbtype,fbbody,contect,dataline) VALUES ('$my[user_id]','$my[user_name]','$my[nickname]','$my[user_head]','$fbtype','$fbbody','$contect','$addtime')");

        dsetcookie('setok','feedback1');
        header("location: {$webaddr}/op/feedback");
        exit;
    } else {
        dsetcookie('setok','feedback2');
        header("location: {$webaddr}/op/feedback");
        exit;
    }
}

if ($my['isadmin']==1) {
    if ($act=='del') {
        $id=$_GET['id'];
        $db->query("DELETE FROM et_feedback WHERE id='$id'");
        echo 'success';
        exit;
    }

    $i=0;
    $start= ($page-1)*10;
    $query = $db->query("SELECT * FROM et_feedback ORDER BY dataline DESC LIMIT $start,10");
    while($data = $db->fetch_array($query)) {
        $i=$i+1;
        $uhead=$data['uhead']?$data['uhead']:"$webaddr/images/noavatar.jpg";
        if ($data['fbtype']==1) {
            $fbtype="注册问题";
        } else if($data['fbtype']==2) {
            $fbtype="密码问题";
        } else if($data['fbtype']==3) {
            $fbtype="登陆问题";
        } else if($data['fbtype']==4) {
            $fbtype="修改昵称";
        } else if($data['fbtype']==5) {
            $fbtype="错误报告";
        } else if($data['fbtype']==6) {
            $fbtype="建 议";
        } else if($data['fbtype']==7) {
            $fbtype="其它问题";
        }
        $feedback[] = array("id"=>$data['id'],"fbuname"=>$data['uname'],"fbunickname"=>$data['unickname'],"fbuhead"=>$uhead,"fbtype"=>$fbtype,"fbbody"=>$data['fbbody'],"fbcontect"=>$data['contect'],"dataline"=>timeop($data['dataline']));
    }

    $query = $db->query("SELECT count(*) AS count FROM et_feedback");
    $row = $db->fetch_array($query);
    $pg_num=ceil($row['count']/10);
}

//模板和Foot
$web_name3="意见反馈";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_feedback.htm'));
?>