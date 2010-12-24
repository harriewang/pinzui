<?PHP
define('is_admin_path', 'yes');
include('../common.inc.php');

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

if ($act=='delkeyword') {
    $kid = $_GET["kid"];
    $db->query("DELETE FROM et_topic WHERE id='$kid'");
    header("location: keyword.php");
    exit;
}

if ($act=='delsearch') {
    $sid = $_GET["sid"];
    $db->query("DELETE FROM et_search WHERE id='$sid'");
    header("location: keyword.php");
    exit;
}

$query = $db->query("SELECT * FROM et_topic ORDER BY topictimes DESC LIMIT 30");
while($data = $db->fetch_array($query)) {
    $topiclist[]=array("id"=>$data['id'],"topic"=>$data['topicname'],"num"=>$data['topictimes']);
}

$query = $db->query("SELECT * FROM et_search ORDER BY searchtimes DESC LIMIT 30");
while($data = $db->fetch_array($query)) {
    $searchlist[]=array("id"=>$data['id'],"searchcont"=>$data['searchcont'],"num"=>$data['searchtimes']);
}

include($template->getfile('keyword.htm'));
?>