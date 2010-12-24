<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if ($my['user_id']) {
    header("location: $webaddr/$my[user_name]/profile");
    exit;
}

if ($closereg==1) {
    header("location: $webaddr/op/web/closereg");
    exit;
}

$invitecode=trim($_GET['invitecode']);
$username=daddslashes(trim($_GET['uname']));
$nickname=daddslashes(clean_html(trim($_GET['unick'])));
$mailadres=daddslashes(trim($_GET['mail']));
$pass1=daddslashes(trim($_GET['pass1']));
$pass2=daddslashes(trim($_GET['pass2']));
$deniedname=array("admin","attachments","badge","images","include"."install","source","templates");

if ($act=="check") {
    if ($closereg==3) {
        $invitemsg=invitecodeauth($invitecode);
        if ($invitemsg!='ok') {
            echo $invitemsg;
            exit;
        }
    }
    if(!preg_match("/^[a-zA-Z\d]*$/i",$username)) {
        echo "账户名只能使用数字和字母组合!";
        exit;
    }
    if(in_array($username, $deniedname)) {
        echo "账户名不能使用!";
        exit;
    }
    if(!$username) {
        echo "请填写您的账户名!";
        exit;
    }
    if(!$nickname) {
        echo "请填写您的昵称!";
        exit;
    }
    if(StrLenW($username)>20 || StrLenW($username)<4) {
        echo "帐户名长度应该大于4个字符小于20个字符！";
        exit;
    }
    if(StrLenW($nickname)>20 || StrLenW($nickname)<4) {
        echo "昵称长度应该大于4个字符(2个汉字)小于20个字符(10个汉字)！";
        exit;
    }
    if (nametoid($username)) {
        echo "账户名已存在，不能使用!";
        exit;
    }
    $query = $db->query("SELECT user_id FROM et_users WHERE nickname='$nickname'");
    if ($db->fetch_array($query)) {
        echo "昵称已存在，不能使用!";
        exit;
    }
    if(!$mailadres) {
        echo "请填写电子邮件地址!";
        exit;
    }
    $t=explode("@",$mailadres);
    if(!$t[1]) {
        echo "电子邮件格式不正确！";
        exit;
    }
	$query = $db->query("SELECT user_id FROM et_users WHERE mailadres='$mailadres'");
    if ($db->fetch_array($query)) {
        echo "此电子邮件已存在，不能使用!";
        exit;
    }
    if (StrLenW($pass1)<6 || StrLenW($pass1)>20) {
        echo "密码长度应该大于6个字符小于20个字符!";
        exit;
    }
    if ($pass1!=$pass2) {
        echo "两次输入的密码不一致!";
        exit;
    }
    echo "check_ok";
    exit;
}

if ($act=="reg") {
    if ($username && $nickname && $mailadres && $pass1==$pass2) {
	$nickname = ($nickname!='')?$nickname:$username;
        $t=$db->query("INSERT INTO et_users (user_name,nickname,password,mailadres,signupdate) VALUES ('".strtolower($username)."','$nickname','".md5(md5($pass2))."','$mailadres','$addtime')");
        $regid=mysql_insert_id();
        if($t==1 && $regid) {
            dsetcookie('authcookie', authcode(md5(md5($pass2))."\t$username\t$regid",'ENCODE'));
            if ($closereg==3) {
                $db->query("UPDATE et_invitecode SET isused=1 WHERE invitecode='$invitecode'");
            }
            header('Content-Type:text/html;charset=utf-8');
            echo "<div style='background:url({$webaddr}/images/default/dialog_msgtype_ico_1.gif) no-repeat 0 0;height:40px;padding:10px 0 0 60px'>恭喜您，已经注册成功了，立即进入下一步！<script>top.location.href='$webaddr/op/guide'</script></div>";
            exit;
        } else {
            header('Content-Type:text/html;charset=utf-8');
            echo "<div style='background:url({$webaddr}/images/default/dialog_msgtype_ico_2.gif) no-repeat 0 0;height:40px;padding:2px 0 0 60px'>注册失败，可能因为您没有填写完整注册信息，请重新填写！</div>";
            exit;
        }
    } else {
        header('Content-Type:text/html;charset=utf-8');
        echo "<div style='background:url({$webaddr}/images/default/dialog_msgtype_ico_2.gif) no-repeat 0 0;height:40px;padding:2px 0 0 60px'>注册失败，可能因为您没有填写完整注册信息，请重新填写！</div>";
        exit;
    }
}

//模板和Foot
$web_name3="新用户注册";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_register.htm'));
?>
