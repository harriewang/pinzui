<?php
define('is_admin_path', 'yes');
include('../common.inc.php');

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

if ($act=="search") {
    $u_name = trim($_GET["u_name"]);
    $u_id = trim($_GET["u_id"]);
    $query = $db->query("SELECT user_id,user_name,nickname,mailadres,isadmin,userlock FROM et_users WHERE user_name='$u_name' || user_id='$u_id'");
    $user = $db->fetch_array($query);
    if (!$user) {
        echo jsalert("提示：该会员不存在！","useradmin.php");
        exit;
    }
}

if ($action=="adduser") {
    $add_uname = daddslashes(trim($_POST["add_uname"]));
    $add_nickname = daddslashes(trim($_POST["add_nickname"]));
    $add_admin = daddslashes(trim($_POST["add_admin"]));
    $add_pass = daddslashes(trim($_POST["add_pass"]));
    $add_email = daddslashes(trim($_POST["add_email"]));

    $deniedname=array("admin","attachments","badge","images","include"."install","source","templates");
    if(!preg_match("/^[a-zA-Z\d]*$/i",$add_uname)) {
        echo jsalert("账户名只能使用数字和字母组合！","useradmin.php?act=adduser");
        exit;
    }
    if(in_array($add_uname, $deniedname) || !$add_uname) {
        echo jsalert("账户名为空或不被使用！","useradmin.php?act=adduser");
        exit;
    }
    if(StrLenW($add_uname)>20 || StrLenW($add_uname)<4) {
        echo jsalert("帐户名长度应该大于4个字符小于20个字符！","useradmin.php?act=adduser");
        exit;
    }
    if(StrLenW($add_nickname)>20 || StrLenW($add_nickname)<4) {
        echo jsalert("昵称长度应该大于4个字符(2个汉字)小于20个字符(10个汉字)！","useradmin.php?act=adduser");
        exit;
    }
    if(!$add_nickname) {
        echo jsalert("请填写昵称！","useradmin.php?act=adduser");
        exit;
    }
    if (nametoid($add_uname)) {
        echo jsalert("账户名已存在，不能使用!","useradmin.php?act=adduser");
        exit;
    }
    $query = $db->query("SELECT user_id FROM et_users WHERE nickname='$add_nickname'");
    if ($db->fetch_array($query)) {
        echo jsalert("昵称已存在，不能使用!","useradmin.php?act=adduser");
        exit;
    }
    if(!$add_email) {
        echo jsalert("请填写电子邮件地址!","useradmin.php?act=adduser");
        exit;
    }
    $t=explode("@",$add_email);
    if(!$t[1]) {
        echo jsalert("电子邮件格式不正确！","useradmin.php?act=adduser");
        exit;
    }
	$query = $db->query("SELECT user_id FROM et_users WHERE mailadres='$add_email'");
    if ($db->fetch_array($query)) {
        echo jsalert("此电子邮件已存在，不能使用!","useradmin.php?act=adduser");
        exit;
    }
    if (StrLenW($add_pass)<6 || StrLenW($add_pass)>20) {
        echo jsalert("密码长度应该大于6个字符小于20个字符!","useradmin.php?act=adduser");
        exit;
    }
    $db->query("INSERT INTO et_users (user_name,nickname,password,mailadres,signupdate,isadmin) VALUES ('$add_uname','$add_nickname','".md5(md5($add_pass))."','$add_email','$addtime','$add_admin')");

    echo jsalert("提示：会员添加成功！","useradmin.php");
    exit;
}

if ($action=="user_edit") {
    $edit_id = $_POST["edit_id"];
    $edit_pass = $_POST["edit_pass"];
    $edit_email = daddslashes(trim($_POST["edit_email"]));
    $edit_admin = $_POST["edit_admin"];
    $edit_nickname = daddslashes(trim($_POST["edit_nickname"]));
    $edit_close = $_POST["edit_close"];

    if (!empty($edit_pass)) {
        $db->query("UPDATE et_users SET nickname='$edit_nickname',password='".md5(md5($edit_pass))."',mailadres='$edit_email',isadmin='$edit_admin',userlock='$edit_close' WHERE user_id='$edit_id'");
    } else {
        $db->query("UPDATE et_users SET nickname='$edit_nickname',mailadres='$edit_email',isadmin='$edit_admin',userlock='$edit_close' WHERE user_id='$edit_id'");
    }
    echo jsalert("提示：会员资料修改成功！","useradmin.php?u_id=$edit_id&act=search");
    exit;
}

include($template->getfile('useradmin.htm'));
?>


