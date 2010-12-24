<?PHP
define('is_admin_path', 'yes');
include('../common.inc.php');

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

if ($action=='add') {
    $annbody =daddslashes(trim($_POST["annbody"]));
    if ($annbody==""){
        echo jsalert("添加失败，请填写公告内容！","announce.php");
        exit;
    } else {
        $db->query("INSERT INTO et_announ (announ_body,announ_time) VALUES ('$annbody','$addtime')");
    }

    @unlink(ET_ROOT."/include/cache/announce.cache.php");
    header("Location: announce.php");
    exit;
}

if ($action=='edit'){
    $addid = $_POST["addid"];
    $new_body =daddslashes(trim($_POST["new_body"]));
    if ($new_body ==""){
        echo jsalert("修改失败，您没有填写公告内容！","announce.php");
        exit;
    } else {
        $db->query("UPDATE et_announ SET announ_body='$new_body' where announ_id='$addid'");

        @unlink(ET_ROOT."/include/cache/announce.cache.php");
        echo jsalert("公告修改成功！","announce.php");
        exit;
    }
}

if ($action=='del'){
    $addid = $_POST["addid"];
    $db->query("DELETE FROM et_announ WHERE announ_id='$addid'");
    @unlink(ET_ROOT."/include/cache/announce.cache.php");
    header("Location: announce.php");
    exit;
}

$query = $db->query("SELECT announ_id,announ_body FROM et_announ ORDER BY announ_id DESC");
while ($data= $db->fetch_array($query)) {
    $id=$data['announ_id'];
    $body=$data['announ_body'];
    $anounc[] = array("id"=>$id,"body"=>$body);
}

include($template->getfile('announce.htm'));
?>