<?php
define('is_admin_path', 'yes');
include('../common.inc.php');

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

function removeDir( $dirName ) {
  if ( $handle = @opendir( "$dirName" ) ) {
   while ( false !== ( $item = @readdir( $handle ) ) ) {
     if ( $item != "." && $item != ".." ) {
       if ( is_dir( "$dirName/$item" ) ) {
         removeDir( "$dirName/$item" );
       } else {
         @unlink( "$dirName/$item" );
       }
     }
   }
   return 1;
   closedir( $handle );
  }
}

$ok=removeDir(ET_ROOT."/templates/cache");

include($template->getfile('reload.htm'));
?>
