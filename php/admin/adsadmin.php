<?PHP
define('is_admin_path', 'yes');
include('../common.inc.php');

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

if ($action=='addads') {
    $addbody=daddslashes(trim($_POST['addbody']));
    $position=$_POST['position'];
    if ($addbody) {
        $db->query("INSERT INTO et_ads (position,adbody) VALUES ('$position','$addbody')");

        @unlink(ET_ROOT."/include/cache/ads.cache.php");
        header("Location: adsadmin.php");
        exit;
    } else {
        echo jsalert("您没有填写广告内容，返回重新填写！","adsadmin.php");
        exit;
    }
}

if ($action=='edit') {
    $aid=$_POST['aid'];
    $adsbody=daddslashes(trim($_POST['editadsbody']));
    $position=$_POST['editposition'];
    if ($adsbody) {
        $db->query("UPDATE et_ads SET position='$position',adbody='$adsbody' WHERE ad_id='$aid'");

        @unlink(ET_ROOT."/include/cache/ads.cache.php");
        echo jsalert("广告位更新成功！","adsadmin.php");
        exit;
    } else {
        echo jsalert("您没有填写广告内容，返回重新填写！","adsadmin.php");
        exit;
    }
}

if ($act=='del') {
    $adid=$_GET['adid'];
    $db->query("DELETE FROM et_ads WHERE ad_id='$adid'");

    @unlink(ET_ROOT."/include/cache/ads.cache.php");
    header("Location: adsadmin.php");
    exit;
}

$query = $db->query("SELECT * FROM et_ads ORDER BY ad_id DESC");
while ($data= $db->fetch_array($query)) {
    $ads[] = array("ad_id"=>$data['ad_id'],"position"=>$data['position'],"adbody"=>$data['adbody']);
}

include($template->getfile('adsadmin.htm'));
?>