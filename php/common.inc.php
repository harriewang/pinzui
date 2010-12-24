<?PHP
define('ET_ROOT', dirname(__FILE__));
define('IN_ET', TRUE);
error_reporting(7);
$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];

$prev=$_SERVER['HTTP_REFERER'];
$addtime=time();
$action=$_POST['action'];
$act=$_GET['act'];
$refer=$_POST['refer']?$_POST['refer']:$_GET['refer']; //返回地址
$backto=$_POST['backto']?$_POST['backto']:$_GET['backto']; //ajax 回调
$urlrefer=$_COOKIE["urlrefer"];

include(ET_ROOT."/include/db_mysql.class.php");
include(ET_ROOT.'/config.inc.php');

$db = new dbstuff;
$db->connect($server,$db_username,$db_password,$db_name, $pconnect,true);
@mysql_query("set names utf8");

include(ET_ROOT."/include/template.class.php");
include(ET_ROOT.'/include/etfunctions.func.php');
include(ET_ROOT.'/include/cache.inc.php');

$setok=trim($_COOKIE["setok"]);
dsetcookie('setok',-1);

if (!$API) {
    if (is_admin_path=="yes") {
        $options = array('template_dir' => '../admin/templates','cache_dir' => '../admin/templates/cache','auto_update' => true,'cache_lifetime' => 0);
    } else {
        $options = array('template_dir' => './templates','cache_dir' => './templates/cache','auto_update' => true,'cache_lifetime' => 0);
    }
    $template = Template::getInstance();
    $template->setOptions($options);
}

//后台
$admin_login_temp= $_COOKIE["admin_login"];
$admin_exp=authcode($admin_login_temp,'DECODE');
$admin_tem=explode("\t",$admin_exp);
$admin_login=$admin_tem['1'];
//前台
$authcookie = $_COOKIE["authcookie"];
$exp=authcode($authcookie,'DECODE');
$tem=explode("\t",$exp);
if ($tem || $admin_tem) {
    $userquery = $db->query("SELECT * FROM et_users WHERE user_name='$tem[1]' && password='$tem[0]'");
    $my=$db->fetch_array($userquery);
    $my['user_head']=$my['user_head']?"$webaddr/attachments/head/".$my['user_head']:"$webaddr/images/noavatar.jpg";
    $tem1=explode(" ",$my['home_city']);
    $my['home_sf']=$tem1[0];
    $my['home_city']=$tem1[1];
    $tem2=explode(" ",$my['live_city']);
    $my['live_sf']=$tem2[0];
    $my['live_city']=$tem2[1];
    $tem3=explode("-",$my['birthday']);
    $my['birth_year']=$tem3[0];
    $my['birth_month']=$tem3[1];
    $my['birth_day']=$tem3[2];
    $tem4=explode(" ",$my['gtalk']);
    $my['gtalk']=$tem4[0]?$tem4[0]:"";
    $my['gtalkauthcode']=$tem4[1];
    if ($my[user_id] && $addtime-$my[last_login]>600) { //最后登陆时间
        $db->query("UPDATE et_users  SET last_login = '$addtime' where user_id='$my[user_id]'");
    }
}
if ($webclose==1 && !$API && is_admin_path!="yes" && $_GET['op']!="web" && $_GET['op']!="login" && !$my['isadmin']) {
   header("location: $webaddr/op/web/close");
   exit;
}

$issetcookie=is_numeric(strpos($prev,"op/login"))*!is_numeric(strpos($prev,"op/register"))*!is_numeric(strpos($prev,"op/web"));
if (!$my['user_id'] && !$issetcookie) {
    dsetcookie('urlrefer',$prev); //跳转cookie
}
?>