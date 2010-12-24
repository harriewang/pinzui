<?php
define('is_admin_path', 'yes');
include('../common.inc.php');

if ($admin_login !="yes" || $my[isadmin]!=1) header("Location: login.php");

if($action=='addut') {
    $bgcolor=daddslashes($_POST['bgcolor']);
    $textcolor=daddslashes($_POST['textcolor']);
    $linkcolor=daddslashes($_POST['linkcolor']);
    $sidebar=daddslashes($_POST['sidebar']);
    $sidebox=daddslashes($_POST['sidebox']);
    $pictype=daddslashes($_POST['pictype']);
    $isupload=daddslashes($_POST['isupload']);

    if ($bgcolor && $textcolor && $linkcolor && $sidebar && $sidebox && $pictype) {
        $db->query("INSERT INTO et_usertemplates (theme_bgcolor,theme_pictype,theme_text,theme_link,theme_sidebar,theme_sidebox,theme_upload) VALUES ('$bgcolor','$pictype','$textcolor','$linkcolor','$sidebar','$sidebox','$isupload')");
        header("Location: usertemplate.php");
        exit;
    } else {
        echo jsalert("信息填写不全，模板添加失败，点击确定返回！","usertemplate.php");
        exit;
    }
}

if ($act=='usebtn') {
    $utid=$_GET['utid'];
    $isopen=$_GET['op']=='open'?1:0;

    $db->query("UPDATE et_usertemplates SET isopen='$isopen' WHERE ut_id ='$utid'");
    header("location:usertemplate.php");
    exit;
}

if ($act=='del') {
    $utid=$_GET['utid'];
    if ($utid==1) {
        echo jsalert("默认提供的模板不能删除，点击确定返回！","usertemplate.php");
        exit;
    } else {
        $db->query("DELETE FROM et_usertemplates WHERE ut_id='$utid'");
        header("location:usertemplate.php");
        exit;
    }
}

if ($action=='uploadtheme') {
    $zippack=$_FILES['zippack'];
    if (is_uploaded_file($zippack['tmp_name']) && $zippack["error"]==0) {
        move_uploaded_file($zippack['tmp_name'],'themetemp/'.$zippack["name"]);
        chmod('themetemp/'.$zippack["name"],0777);
    }
    $zip = zip_open(dirname(__FILE__)."/themetemp/".$zippack["name"]);
    if ($zip) {
        $filedata=array();
        while ($zip_entry = zip_read($zip)) {
            if (zip_entry_open($zip, $zip_entry, "r")) {
                $filedata[zip_entry_name($zip_entry)]=zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                zip_entry_close($zip_entry);
            }
        }
        zip_close($zip);
    }
    if (count($filedata)>0) {
        $db->query($filedata['theme.sql']);
        $id=mysql_insert_id();
        if ($id && count($filedata)>1) {
            $newdir=ET_ROOT.'/attachments/usertemplates/'.$id;
            mkdir($newdir,0777);
            $fp=fopen($newdir."/themebg.jpg","a");
	        fputs($fp,$filedata['themebg.jpg']);
            fclose($fp);
            $fp=fopen($newdir."/themebg_thumb.jpg","a");
	        fputs($fp,$filedata['themebg_thumb.jpg']);
            fclose($fp);
            @unlink('themetemp/'.$zippack["name"]);
        }
    }
    header("location: usertemplate.php");
    exit;
}

if ($action=='edit') {
    $utid=$_GET['utid'];
    $bgcolor=daddslashes($_POST['bgcolor']);
    $textcolor=daddslashes($_POST['textcolor']);
    $linkcolor=daddslashes($_POST['linkcolor']);
    $sidebar=daddslashes($_POST['sidebar']);
    $sidebox=daddslashes($_POST['sidebox']);
    $pictype=daddslashes($_POST['pictype']);
    $isupload=daddslashes($_POST['isupload']);
    if ($bgcolor && $textcolor && $linkcolor && $sidebar && $sidebox && $pictype) {
        $db->query("UPDATE et_usertemplates SET theme_bgcolor='$bgcolor',theme_pictype='$pictype',theme_text='$textcolor',theme_link='$linkcolor',theme_sidebar='$sidebar',theme_sidebox='$sidebox',theme_upload='$isupload' WHERE ut_id='$utid'");

        echo jsalert("模板编辑成功，点击确定返回！","usertemplate.php");
        exit;
    } else {
        echo jsalert("信息填写不全，模板编辑失败，点击确定返回！","usertemplate.php");
        exit;
    }
}

if ($act=='edit') {
    $utid=$_GET['utid'];
    $query = $db->query("SELECT * FROM et_usertemplates WHERE ut_id='$utid'");
    $data= $db->fetch_array($query);
    $edit_bgcolor=$data['theme_bgcolor'];
    $edit_pictype=$data['theme_pictype'];
    $edit_text=$data['theme_text'];
    $edit_link=$data['theme_link'];
    $edit_sidebar=$data['theme_sidebar'];
    $edit_sidebox=$data['theme_sidebox'];
    $edit_upload=$data['theme_upload'];
    $isopen=$data['isopen'];
}

$query = $db->query("SELECT * FROM et_usertemplates ORDER BY ut_id");
while ($data= $db->fetch_array($query)) {
    $ut[] = array("ut_id"=>$data['ut_id'],"theme_bgcolor"=>$data['theme_bgcolor'],"theme_pictype"=>$data['theme_pictype'],"theme_text"=>$data['theme_text']
        ,"theme_link"=>$data['theme_link'],"theme_sidebar"=>$data['theme_sidebar'],"theme_sidebox"=>$data['theme_sidebox'],"theme_upload"=>$data['theme_upload'],"isopen"=>$data['isopen']);
}

include($template->getfile('usertemplate.htm'));
?>