<?PHP
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if ($act=="logout") {
    dsetcookie('authcookie', '', -31536000);
    dsetcookie('admin_login','', -1800);
    header("location: $webaddr");
    exit;
}

tohome();

if ($action=="login") {
    $loginname= daddslashes($_POST["loginname"]);
    $pass = md5(md5($_POST["password"]));
    $rememberMe = $_POST["rememberMe"];
	//harrie add 
	$query = $db->query("SELECT user_id,user_name,last_login,userlock,password,password2 FROM et_users WHERE (user_name='$loginname' || mailadres='$loginname') && password=''");
    if ($row = $db->fetch_array($query)){
    	$pass2 = md5($_POST["password"].$row['user_id']);
        if ($row["password2"]==$pass2) {
            $db->query('UPDATE  `et_users` SET  `password` =  \''.$pass.'\' WHERE  `user_id` ='.$row['user_id'].' LIMIT 1 ;');
        }
    }
    // harrie add end
    $query = $db->query("SELECT user_id,user_name,last_login,userlock FROM et_users WHERE (user_name='$loginname' || mailadres='$loginname') && password='$pass'");
    if ($row = $db->fetch_array($query)){
        dsetcookie('urlrefer',''); // 销毁登录跳转cookie
        if ($row["userlock"]==1) {
            dsetcookie('setok','login1');
            header("location:$webaddr/op/login");
            exit;
        } else {
            if ($rememberMe=="on") {
                dsetcookie('authcookie', authcode("$pass\t$row[user_name]\t$row[user_id]",'ENCODE'), 31536000);
            } else {
                dsetcookie('authcookie', authcode("$pass\t$row[user_name]\t$row[user_id]",'ENCODE'));
            }
            if ($urlrefer) {
                header("location: $urlrefer");
                exit;
            } else {
                header("location: $webaddr/{$row[user_name]}/profile");
                exit;
            }
        }
    } else {
        dsetcookie('setok','login2');
        header("location:$webaddr/op/login");
        exit;
    }
}

//模板和Foot
$web_name3="用户登录";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_login.htm'));
?>