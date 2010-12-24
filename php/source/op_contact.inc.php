<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

//模板和Foot
$web_name3="联系我们";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_contact.htm'));
?>