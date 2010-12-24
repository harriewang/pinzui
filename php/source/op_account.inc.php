<?PHP
if(!defined('IN_ET')) {
	exit('Access Denied');
}

tologin();

if ($action=="account") {
    $pass=md5(md5($_POST["pass"]));
    $newpass1= md5(md5($_POST["newpass1"]));
    $newpass2= md5(md5($_POST["newpass2"]));
    if ($pass==$my['password']) {
        if ($newpass1!=$newpass2 || !trim($_POST["newpass1"])) {
            dsetcookie('setok','account1');
            header("location:$webaddr/op/account");
            exit;
        } else {
            $db->query("UPDATE et_users  SET password = '$newpass1' WHERE user_id='$my[user_id]'");
            dsetcookie('setok','account2');
            header("location:$webaddr/op/account");
            exit;
        }
    } else {
        dsetcookie('setok','account3');
        header("location:$webaddr/op/account");
        exit;
    }
}

//模板和Foot
$menu="setting";
$web_name3="修改密码";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_account.htm'));
?>