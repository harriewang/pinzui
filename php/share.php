<?PHP
include('common.inc.php');

$url=$_GET['u'];
$title=$_GET['t'];
$des=$_GET['d'];
$error=$_GET['error'];
$shareok=$_GET['shareok'];
$allurl="u=$url&t=$title&d=$des";

if (!$my['user_id'] && $act!='login') {
    header("location: share.php?act=login&{$allurl}");
}

if ($action=='login') {
    $loginname= daddslashes($_POST["loginname"]);
    $pass = daddslashes(md5(md5($_POST["password"])));
    $rememberMe = $_POST["rememberMe"];

    $query = $db->query("SELECT user_id,user_name,userlock FROM et_users WHERE (user_id='$loginname' || user_name='$loginname' || mailadres='$loginname') && password='$pass'");
    if ($row = $db->fetch_array($query)){
        if ($row["userlock"]==1) {
            header("location:$webaddr/share.php?act=login&{$allurl}&error=用户被锁定，不能登陆");
            exit;
        } else {
            if ($rememberMe=="on") {
                dsetcookie('authcookie', authcode("$pass\t$row[user_name]\t$row[user_id]",'ENCODE'), 31536000);
            } else {
                dsetcookie('authcookie', authcode("$pass\t$row[user_name]\t$row[user_id]",'ENCODE'));
            }
            header("location:$webaddr/share.php?{$allurl}");
            exit;
        }
    } else {
        header("location:$webaddr/share.php?act=login&{$allurl}&error=用户名或密码错误");
        exit;
    }
}

if ($action =='share') {
    $_url=$_POST['url'];
    $_title=$_POST['title'];
    $_des=$_POST['des'];
    if ($_des) {
        $des="[desc]{$_des}[/desc]";
    } else {
        $des="<br/>";
    }
    $content="ET分享：{$_title}{$des}{$_url}";
    if (!empty($content)) {
        $content=replace($content); //词语过滤
        explodetopic($content); //专题
        $content=daddslashes($content);

        $db->query("INSERT INTO et_content (user_id,user_name,user_nickname,user_head,content_body,posttime) VALUES ('$my[user_id]','$my[user_name]','$my[nickname]','$my[user_head]','$content','$addtime')");

        $db->query("UPDATE et_users SET msg_num=msg_num+1,lastcontent='$content',lastconttime='$addtime' WHERE user_id='$my[user_id]'");
        header("location:$webaddr/share.php?shareok=1");
        exit;
    } else {
        header("location:$webaddr/share.php?shareok=0&{$allurl}&error=很抱歉，分享失败了");
        exit;
    }
}

include($template->getfile('share.htm'));
?>