<?PHP
if(!defined('IN_ET')) {
	exit('Access Denied');
}

tologin();

if ($action=="upload") {
    $syshead= daddslashes($_POST["syshead"]);

    $sysphoto = array("$webaddr/attachments/head/syshead/01.jpg","$webaddr/attachments/head/syshead/02.jpg","$webaddr/attachments/head/syshead/03.jpg","$webaddr/attachments/head/syshead/04.jpg","$webaddr/attachments/head/syshead/05.jpg","$webaddr/attachments/head/syshead/06.jpg","$webaddr/attachments/head/syshead/07.jpg","$webaddr/attachments/head/syshead/08.jpg","$webaddr/attachments/head/syshead/09.jpg","$webaddr/attachments/head/syshead/10.jpg");

    if ($_FILES['picture']['name']) {
        $refer=$webaddr."/op/setting";
        include(ET_ROOT."/include/uploadpic.func.php");
        $upname=UploadImage("picture",1,96,96,ET_ROOT."/attachments/head/",ET_ROOT."/attachments/head/",$my['user_id']);
        $db->query("UPDATE et_users SET user_head = '$upname' WHERE  user_id='$my[user_id]'");
    }

    if (in_array($syshead, $sysphoto) && !$_FILES['picture']['name']) {
        $user_syshead=getsubstrutf8($syshead,-14,14,false);
        $db->query("UPDATE et_users SET user_head = '$user_syshead' WHERE user_id='$my[user_id]'");
    }
    dsetcookie('setok','setting1');
    header("location:$webaddr/op/setting");
    exit;
}

if ($action=="setting") {
    $nickname= daddslashes(clean_html(trim($_POST["nickname"])));
    $gender= $_POST["gender"];
    $musicaddr= daddslashes(clean_html(trim($_POST["musicaddr"])));
    $homesf= $_POST["homesf"];
    $homecity= $_POST["homecity"];
    $livesf= $_POST["livesf"];
    $livecity= $_POST["livecity"];
    $homeprovince="$homesf $homecity";
    $liveprovince="$livesf $livecity";
    $birthyear= $_POST["birthyear"];
    $birthmonth= $_POST["birthmonth"];
    $birthday= $_POST["birthday"];
    if ($birthyear && $birthmonth && $birthday) $birth=$birthyear."-".$birthmonth."-".$birthday;
    else $birth="";
    $info= daddslashes(replace(trim($_POST["info"])));

    if (trim($homeprovince) && $homeprovince!=$my['home_sf']." ".$my['home_city'] && $homesf!="选择省份" && $homecity!="选择城市"){
        $para="home_city = '{$homeprovince}'";
    }
    if (trim($liveprovince) && $liveprovince!=$my['live_sf']." ".$my['live_city'] && $livesf!="选择省份" && $livecity!="选择城市"){
        $para="live_city = '{$liveprovince}',".$para;
    }
    if ($birth!=$my[birthday] && $birth){
        $para="birthday = '{$birth}',".$para;
    }
    if ($gender!=$my[user_gender]){
        $para="user_gender = '{$gender}',".$para;
    }
    if ($info!=$my[user_info]){
        $para="user_info = '{$info}',".$para;
    }
    if ($musicaddr!=$my[musicaddr]){
        $para="musicaddr = '{$musicaddr}',".$para;
    }
    if ($nickname && $nickname!=$my[nickname]) {
        $query = $db->query("select user_id from et_users where nickname='$nickname'");
        if (StrLenW($nickname)<=20 && StrLenW($nickname)>=4 && !$db->fetch_array($query)) {
            $para="nickname = '{$nickname}',".$para;
        } else {
            dsetcookie('setok','setting2');
            header("location:$webaddr/op/setting");
            exit;
        }
    }
    if ($para) {
        $para=trim($para);
        if (getsubstrutf8($para,0,1,false)==',') {
            $para=getsubstrutf8($para,1,null,false);
        }
        if (getsubstrutf8($para,-1,1,false)==',') {
            $para=getsubstrutf8($para,0,-1,false);
        }
        $db->query("UPDATE et_users SET $para WHERE user_id='$my[user_id]'");
        dsetcookie('setok','setting3');
        header("location:$webaddr/op/setting");
        exit;
    }
}

//模板和Foot
$menu="setting";
$web_name3="基本信息设置";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_setting.htm'));
?>