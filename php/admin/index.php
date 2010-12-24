<?php
define('is_admin_path', 'yes');
include('../common.inc.php');

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

//服务器环境
$serverinfo = PHP_OS.' / PHP v'.PHP_VERSION;
$serverinfo .= @ini_get('safe_mode') ? ' Safe Mode' : NULL;
$dbversion = $db->result_first("SELECT VERSION()");
$dbsize = 0;
$query = $db->query("SHOW TABLE STATUS LIKE '$DBprefix%'", 'SILENT');
while($table = $db->fetch_array($query)) {
	$dbsize += $table['Data_length'] + $table['Index_length'];
}
$dbsize = $dbsize ? sizecount($dbsize) : "未知大小";

if ($action=='edit') {
    $web_name = daddslashes($_POST["web_name"]);
    $web_name2 = daddslashes($_POST["web_name2"]);
    $web_miibeian = daddslashes($_POST["web_miibeian"]);
    $seokey = daddslashes($_POST["seokey"]);
    $description = daddslashes($_POST["description"]);
    $regclose = $_POST["userreg"];
    $webclose = $_POST["closeweb"];
	$bindmobile = daddslashes($_POST["bindmobile"]);
	$openqq = daddslashes($_POST["openqq"]);


    $db->query("UPDATE et_settings SET web_name ='$web_name',web_name2='$web_name2',web_miibeian='$web_miibeian',seokey='$seokey',
    description='$description',webclose='$webclose',closereg='$regclose',openqq='$openqq',bindmobile='$bindmobile'");

    @unlink(ET_ROOT."/include/cache/setting.cache.php");

    header("Location: index.php");
    exit;
}

include($template->getfile('index.htm'));
?>