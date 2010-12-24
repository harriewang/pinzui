<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

tologin();

if ($action=="auth") {
    $send=randStr(20);
    $send2=base64_encode("$my[user_id]:$send");
    $send="这是贫嘴邮箱验证邮件：
    请将该地址复制到浏览器地址栏：
    $webaddr/op/mailauth&act=authmail&auth=$send2";
    $send=iconv("utf-8", "gbk",$send);
    $title=iconv("utf-8", "gbk","贫嘴 邮箱验证");

    $db->query("UPDATE et_users SET auth_email='$send2' where user_id='$my[user_id]'");

    include("include/mail.class.php");
    sendmail($my['mailadres'],$title,$send);

    dsetcookie('setok','mail1');
    header("location:$webaddr/op/mailauth");
    exit;
}

if ($action=="edit") {
    $new_email= daddslashes(trim($_POST["email"]));
    $t=explode("@",$new_email);
    if(!$t[1]) {
        dsetcookie('setok','mail2');
        header("location:$webaddr/op/mailauth");
        exit;
    } else {
        if ($new_email && $new_email!=$my[mailadres]) {
            $query = $db->query("SELECT mailadres FROM et_users WHERE mailadres='$new_email'");
            $row = $db->fetch_array($query);
            if ($row) {
                dsetcookie('setok','mail3');
                header("location:$webaddr/op/mailauth");
                exit;
            } else {
                $db->query("UPDATE et_users SET mailadres='$new_email',auth_email='0' WHERE user_id='$my[user_id]'");
                dsetcookie('urlrefer',"$webaddr/op/mailauth");
                dsetcookie('setok','mail8');
                header("location:$webaddr/op/mailauth");
                exit;
            }
        } elseif ($new_email==$my[mailadres]){
            dsetcookie('setok','mail4');
            header("location:$webaddr/op/mailauth");
            exit;
        } else {
            dsetcookie('setok','mail5');
            header("location:$webaddr/op/mailauth");
            exit;
        }
    }
}

if ($act=="authmail") {
    $msg1=daddslashes($_GET['auth']);
    $msg=base64_decode($msg1);
    $tem=explode(":",$msg);
    $send_id=$tem[0];

    $query = $db->query("SELECT auth_email FROM et_users WHERE user_id='$send_id'");
    $row = $db->fetch_array($query);
    $auth_email=$row['auth_email'];

    if ($msg1==$auth_email) {
        $db->query("UPDATE et_users SET auth_email='1' where user_id='$send_id'");
        dsetcookie('setok','mail6');
        header("location:$webaddr/op/mailauth");
        exit;
    } else {
        dsetcookie('setok','mail7');
        header("location:$webaddr/op/mailauth");
        exit;
    }
}

//模板和Foot
$menu="setting";
$web_name3="邮箱验证";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_mailauth.htm'));
?>