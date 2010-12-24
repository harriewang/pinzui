<?php
define('is_admin_path', 'yes');
include('../common.inc.php');
include("../include/backup.func.php");

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

$db->query("show table status from $db_name");
while($db->nextrecord()){
    $s1="<option value='".$db->f('Name')."'>".$db->f('Name')."</option>";
    $s=$s1.$s;
}

if ($action=="back") {
    $bftype=$_POST['bfzl'];
    if($bftype=="quanbubiao"){
        if(!$_POST['fenjuan']){ //不是分卷
            if(!$tables=$db->query("show table status from $db_name")) {
                $msgs="读数据库结构错误！";
                echo jsalert($msgs,"backup.php");
                exit;
            }
            $sql="";
            while($db->nextrecord($tables)) {
                $table=$db->f("Name");
                $sql.=make_header($table);
                $db->query("select * from $table");
                $num_fields=$db->nf();
                while($db->nextrecord()) {
                    $sql.=make_record($table,$num_fields);
                }
            }
            $filename=date("Ymd",time())."_all.sql";
            if($_POST['weizhi']=="localpc") down_file($sql,$filename);
            elseif($_POST['weizhi']=="server"){
                if(write_file($sql,$filename)) $msgs="全部数据表数据备份完成,生成备份文件./backup/$filename";
                else $msgs="备份全部数据表失败";
                echo jsalert($msgs,"backup.php");
                exit;
            }
        }else{  //分卷备份
            if(!$_POST['filesize']){
                $msgs="请填写备份文件分卷大小！";
                echo jsalert($msgs,"backup.php");
                exit;
            }
            if(!$tables=$db->query("show table status from $db_name")){
                $msgs="读数据库结构错误！";
                echo jsalert($msgs,"backup.php");
                exit;
            }
            $sql="";
            $p=1;
            $filename=date("Ymd",time())."_all";
            while($db->nextrecord($tables)){
                $table=$db->f("Name");
                $sql.=make_header($table);
                $db->query("select * from $table");
                $num_fields=$db->nf();
                while($db->nextrecord()){
                    $sql.=make_record($table,$num_fields);
                    if(strlen($sql)>=$_POST['filesize']*1000){
                        $filename.=("_v".$p.".sql");
                        if(write_file($sql,$filename)) $msgs="全部数据表-卷-".$p."-数据备份完成,生成备份文件./backup/$filename";
                        else $msgs="备份表-".$_POST['tablename']."-失败";
                        $p++;
                        $filename=date("Ymd",time())."_all";
                        $sql="";
                    }
                }
            }
            if($sql!=""){
                $filename.=("_v".$p.".sql");
                if(write_file($sql,$filename))$msgs="全部数据表-卷-".$p."-数据备份完成,生成备份文件./backup/$filename";
            }
            echo jsalert($msgs,"backup.php");
            exit;
        }
    } elseif($bftype=="danbiao") {
        if(!$_POST['tablename']) {
            $msgs="请选择要备份的数据表";
            echo jsalert($msgs,"backup.php");
            exit;
        }
        if(!$_POST['fenjuan']){ //不分卷
            $sql=make_header($_POST['tablename']);
            $db->query("select * from ".$_POST['tablename']);
            $num_fields=$db->nf();
            while($db->nextrecord()){
                $sql.=make_record($_POST['tablename'],$num_fields);
            }
            $filename=date("Ymd",time())."_".$_POST['tablename'].".sql";
            if($_POST['weizhi']=="localpc") down_file($sql,$filename);
            elseif($_POST['weizhi']=="server"){
                if(write_file($sql,$filename)) $msgs="表-".$_POST['tablename']."-数据备份完成,生成备份文件./backup/$filename";
                else $msgs="备份表-".$_POST['tablename']."-失败";
                echo jsalert($msgs,"backup.php");
                exit;
            }
        } else { //分卷备份
            if(!$_POST['filesize']){
                $msgs="请填写备份文件分卷大小";
                echo jsalert($msgs,"backup.php");
                exit;
            }
            $sql=make_header($_POST['tablename']);
            $p=1;
            $filename=date("Ymd",time())."_".$_POST['tablename'];
            $db->query("select * from ".$_POST['tablename']);
            $num_fields=$db->nf();
            while ($db->nextrecord()){
                $sql.=make_record($_POST['tablename'],$num_fields);
                if(strlen($sql)>=$_POST['filesize']*1000){
                    $filename.=("_v".$p.".sql");
                    if(write_file($sql,$filename)) $msgs="表-".$_POST['tablename']."-卷-".$p."-数据备份完成,生成备份文件./backup/$filename";
                    else $msgs="备份表-".$_POST['tablename']."-失败";
                    $p++;
                    $filename=date("Ymd",time())."_".$_POST['tablename'];
                    $sql="";
                }
           }
        }
        if($sql!="") {
            $filename.=("_v".$p.".sql");
            if(write_file($sql,$filename)) $msgs="表-".$_POST['tablename']."-卷-".$p."-数据备份完成,生成备份文件./backup/$filename";
        }
        echo jsalert($msgs,"backup.php");
        exit;
    }
    if($_POST['weizhi']=="localpc" && $_POST['fenjuan']=='yes') {
        $msgs="只有选择备份到服务器，才能使用分卷备份功能";
        echo jsalert($msgs,"backup.php");
        exit;
    }
    if($_POST['fenjuan']=="yes" && !$_POST['filesize']) {
        $msgs="您选择了分卷备份功能，但未填写分卷文件大小";
        echo jsalert($msgs,"backup.php");
        exit;
    }
    if($_POST['weizhi']=="server" && !writeable("./backup")) {
        $msgs="备份文件存放目录'./backup'不可写，请修改目录属性";
        echo jsalert($msgs,"backup.php");
        exit;
    }
}

include($template->getfile('backup.htm'));
?>
