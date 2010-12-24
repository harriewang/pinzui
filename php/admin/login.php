<?PHP
define('is_admin_path', 'yes');
include('../common.inc.php');

if($act=="logout") {
    dsetcookie("admin_login","",-1800);
    header("Location: index.php");
    exit;
}

if ($admin_login =="yes" && $my[isadmin]==1)
    header("Location: index.php");

$password = daddslashes(md5(md5(trim($_POST["password"]))));

if ($action=="login") {
    if ($password==$my[password]) {
        dsetcookie('admin_login', authcode("$password\tyes\t$my[user_id]",'ENCODE'), 1800);
        header("Location: index.php");
    }
}

include($template->getfile('login.htm'));
?>