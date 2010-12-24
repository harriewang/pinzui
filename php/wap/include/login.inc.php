<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if ($act=="logout") {
    dsetcookie("wapcookie","",-2592000);
    showmessage("<div class='showmag'>您已经成功退出，<a href='index.php?op=login'>返回首页</a></div>");
    exit;
}

if($user['user_id']) {
    showmessage("<div class='showmag'>您已经登录，<a href='index.php'>返回主页</a></div>");
    exit;
}

if($action=="login") {
    $loginaccount=daddslashes($_POST['loginaccount']);
    $loginpass=daddslashes($_POST['loginpass']);
    $auto_login=$_POST['auto_login'];
    $md5_password = md5(md5($loginpass));

	//harrie add 
	$query = $db->query("SELECT user_id,user_name,last_login,userlock,password,password2 FROM et_users WHERE (user_name='$loginaccount' || mailadres='$loginaccount') && password=''");
    if ($row = $db->fetch_array($query)){
    	$pass2 = md5($_POST["loginpass"].$row['user_id']);
        if ($row["password2"]==$pass2) {
            $db->query('UPDATE  `et_users` SET  `password` =  \''.$md5_password.'\' WHERE  `user_id` ='.$row['user_id'].' LIMIT 1 ;');
        }
    }
    // harrie add end
    $query = $db->query("SELECT user_id,password FROM et_users where user_name='$loginaccount' || mailadres='$loginaccount'");
    $data = $db->fetch_array($query);
    $upass=$data['password'];
    $uid=$data['user_id'];
    if ($upass==$md5_password) {
        if ($auto_login=="on") dsetcookie('wapcookie', authcode("$uid\t$upass",'ENCODE'), 2592000);
        else dsetcookie('wapcookie', authcode("$uid\t$upass",'ENCODE'));
        showmessage("<div class='showmag'>登陆成功，<a href='index.php'>返回主页</a></div>");
        exit;
    } else {
        showmessage("<div class='showmag'><p>登陆失败，用户名或密码错误</p><p><a href='index.php?op=login'>返回主页</a></p></div>");
        exit;
    }
}

wapheader();
echo "<form method='post' action='index.php?op=login' >".
"<h3>Email / 用户账户：</h3><p><input type='text' name='loginaccount' /></p>".
"<h3>登录密码：</h3><p><input type='password' name='loginpass' /></p>".
"<p><input type='checkbox' name='auto_login' value='on' checked='checked' /> 下次自动登录</p>".
"<p><input type='hidden' name='action' value='login' />".
"<input type='submit' value='登录' /></p>".
"</form>".
"<p>贫嘴是一个微博。</p><p>随时随地发消息</p><p>时时刻刻看朋友</p><p>手机、网页、短信、QQ</p>";
?>
