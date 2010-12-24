<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

tologin();

//模板和Foot
$menu="setting";
$web_name3="分享链接";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_share.htm'));
?>