<?php
define('is_admin_path', 'yes');
include('../common.inc.php');
include("../include/backup.func.php");

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

session_start();

$handle=opendir('./backup');
while ($file = readdir($handle)) {
    if(eregi("^[0-9]{8,8}([0-9a-z_]+)(\.sql)$",$file))
        $t1="<option value='$file'>$file</option>";
    $t=$t.$t1;
}
closedir($handle);

if ($action=="restore") {
    if($_POST['restorefrom']=="server"){
        if(!$_POST['serverfile']) {
            $msgs[]="您选择从服务器文件恢复备份，但没有指定备份文件";
            $show=show_msg($msgs);
            include($template->getfile('restore.htm'));
            pageend();
        }
        if(!eregi("_v[0-9]+",$_POST['serverfile'])){
            $filename="./backup/".$_POST['serverfile'];
            if(import($filename))
                $msgs[]="备份文件".$_POST['serverfile']."成功导入数据库";
            else
                $msgs[]="备份文件".$_POST['serverfile']."导入失败";
            $show=show_msg($msgs);
            include($template->getfile('restore.htm'));
            pageend();
        }else{
            $filename="./backup/".$_POST['serverfile'];
            if(import($filename))
                $msgs[]="备份文件".$_POST['serverfile']."成功导入数据库";
            else {
                $msgs[]="备份文件".$_POST['serverfile']."导入失败";
                $show=show_msg($msgs);
                include($template->getfile('restore.htm'));
                pageend();
            }
            $voltmp=explode("_v",$_POST['serverfile']);
            $volname=$voltmp[0];
            $volnum=explode(".sq",$voltmp[1]);
            $volnum=intval($volnum[0])+1;
            $tmpfile=$volname."_v".$volnum.".sql";
            if(file_exists("./backup/".$tmpfile)){
                $msgs[]="程序将在3秒钟后自动开始导入此分卷备份的下一部份：文件".$tmpfile."，请勿手动中止程序的运行，以免数据库结构受损";
                $_SESSION['data_file']=$tmpfile;
                $show=show_msg($msgs);
                sleep(3);
                echo "<script language='javascript'>";
                echo "location='restore.php';";
                echo "</script>";
            }else{
                $msgs[]="此分卷备份全部导入成功";
                $show=show_msg($msgs);
            }
        }
    }


    if($_POST['restorefrom']=="localpc"){
        switch ($_FILES['myfile']['error']){
            case 1:
            case 2:
            $msgs[]="您上传的文件大于服务器限定值，上传未成功";
            break;
            case 3:
            $msgs[]="未能从本地完整上传备份文件";
            break;
            case 4:
            $msgs[]="从本地上传备份文件失败";
            break;
            case 0:
            break;
        }
        if($msgs){
            $show=show_msg($msgs);
            include($template->getfile('restore.htm'));
            pageend();
        }
        $fname=date("Ymd",time())."_".sjs(5).".sql";
        if (is_uploaded_file($_FILES['myfile']['tmp_name'])) {
            copy($_FILES['myfile']['tmp_name'], "./backup/".$fname);
        }
        if (file_exists("./backup/".$fname)){
            $msgs[]="本地备份文件上传成功";
            if(import("./backup/".$fname)) {
                $msgs[]="本地备份文件成功导入数据库";
                unlink("./backup/".$fname);
            }else {
                $msgs[]="本地备份文件导入数据库失败";
            }
        } else {
            $msgs[]="从本地上传备份文件失败";
        }
        $show=show_msg($msgs);
    }

    if(!$_POST['act'] && $_SESSION['data_file']) {
        $filename="./backup/".$_SESSION['data_file'];
        if(import($filename))
            $msgs[]="备份文件".$_SESSION['data_file']."成功导入数据库";
        else {
            $msgs[]="备份文件".$_SESSION['data_file']."导入失败";
            $show=show_msg($msgs);
            include($template->getfile('restore.htm'));
            pageend();
        }
        $voltmp=explode("_v",$_SESSION['data_file']);
        $volname=$voltmp[0];
        $volnum=explode(".sq",$voltmp[1]);
        $volnum=intval($volnum[0])+1;
        $tmpfile=$volname."_v".$volnum.".sql";
        if(file_exists("./backup/".$tmpfile)){
            $msgs[]="程序将在3秒钟后自动开始导入此分卷备份的下一部份：文件".$tmpfile."，请勿手动中止程序的运行，以免数据库结构受损";
            $_SESSION['data_file']=$tmpfile;
            $show=show_msg($msgs);
            sleep(3);
            echo "<script language='javascript'>";
            echo "location='restore.php';";
            echo "</script>";
        }else{
            $msgs[]="此分卷备份全部导入成功";
            unset($_SESSION['data_file']);
            $show=show_msg($msgs);
        }
    }
} else {
    $msgs[]="本功能在恢复备份数据的同时，将全部覆盖原有数据";
    $msgs[]="数据恢复只能恢复由本系统导出的数据文件，其他软件导出格式无法识别";
    $msgs[]="从本地恢复数据最大数据2m";
    $msgs[]="如果您使用了分卷备份，只需手工导入文件卷1，其他数据文件会由系统导入";
    $show=show_msg($msgs);
}

include($template->getfile('restore.htm'));
?>