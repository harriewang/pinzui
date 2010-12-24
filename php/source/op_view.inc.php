<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

$viewid=$_GET['id'];

$query = $db->query("SELECT * FROM et_content WHERE content_id='$viewid'");
$data = $db->fetch_array($query);
$content=ubb($data['content_body']);
if (!$data) {
	header("location: $webaddr/op/web/404");
    exit;
}

//模板和Foot
if ($data['privacy']==0) $web_name3=simplecontent($data['content_body']);
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_view.htm'));
?>