<?php
define('is_admin_path', 'yes');
include('../common.inc.php');;

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

if ($action=='replace') {
    $_replace=daddslashes(trim($_POST["replace"]));
    $db->query("UPDATE et_settings SET replace_word ='$_replace'");

    @unlink(ET_ROOT."/include/cache/setting.cache.php");
    header("location: replace.php");
}

include($template->getfile('replace.htm'));
?>