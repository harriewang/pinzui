<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

//模板和Foot
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_web.htm'));
?>