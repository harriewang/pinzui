<?PHP
define('is_admin_path', 'yes');
include('../common.inc.php');

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

if ($action=='del') {
    $rpid = $_POST["rpid"];
    $db->query("DELETE FROM et_report WHERE id='$rpid'");
    header("location: report.php");
}

$query = $db->query("SELECT * FROM et_report ORDER BY id DESC");
while($data = $db->fetch_array($query)) {
    if ($data['reporttype']==1) {
        $type="涉及黄色和暴力";
    } else if($data['reporttype']==2) {
        $type="政治反动";
    } else if($data['reporttype']==3) {
        $type="内容侵权";
    } else if($data['reporttype']==4) {
        $type="其他不良信息";
    }
    $rept[] = array('id'=>$data['id'],'user_name'=>$data['user_name'],'reporttype'=>$type,'reportbody'=>$data['reportbody'],
        'dateline'=>timeop($data['dateline']));
}

include($template->getfile('report.htm'));
?>