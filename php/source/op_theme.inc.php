<?PHP
if(!defined('IN_ET')) {
	exit('Access Denied');
}

tologin();

if ($act=='dltheme') {
    include("include/zip.func.php");
    $theme_bgcolor=$my[theme_bgcolor]?$my[theme_bgcolor]:"#acdae5";
    $theme_pictype=$my[theme_pictype]?$my[theme_pictype]:"left";
    $theme_text=$my[theme_text]?$my[theme_text]:"#000000";
    $theme_link=$my[theme_link]?$my[theme_link]:"#0066cc";
    $theme_sidebar=$my[theme_sidebar]?$my[theme_sidebar]:"#e2f2da";
    $theme_sidebox=$my[theme_sidebox]?$my[theme_sidebox]:"#b2d1a3";
    $isimg=$my[theme_bgurl]?1:0;

    $filecont="INSERT INTO et_usertemplates (theme_bgcolor,theme_pictype,theme_text,theme_link,theme_sidebar,theme_sidebox,theme_upload) VALUES ('$theme_bgcolor','$theme_pictype','$theme_text','$theme_link','$theme_sidebar','$theme_sidebox','$isimg')";
    $sqlfile=ET_ROOT."/attachments/photo/user_{$my[user_id]}/theme.sql";
    @unlink($sqlfile);
    $fp=fopen($sqlfile,"a");
    fputs($fp,$filecont);
    fclose($fp);

    if ($isimg) {
        $bgimg=ET_ROOT."/".$my['theme_bgurl']."/themebg.jpg";
        $bgimgthumb=ET_ROOT."/".$my['theme_bgurl']."/themebg_thumb.jpg";
        $files=array($bgimg,$bgimgthumb,$sqlfile);
    } else {
        $files=array($sqlfile);
    }

    function listfiles($dir="."){
        global $faisunZIP;
        $sub_file_num = 0;
        if(is_file("$dir")){
            if(realpath($faisunZIP ->gzfilename)!=realpath("$dir")){
                $faisunZIP -> addfile(implode('',file("$dir")),basename($dir));
                return 1;
            }
            return 0;
        }
        return $sub_file_num;
    }

    $flname="attachments/photo/user_{$my[user_id]}/theme.zip";
    if(is_array($files)){
        $faisunZIP = new PHPzip;
        if($faisunZIP -> startfile($flname)){
            $filenum = 0;
            foreach($files as $file) $filenum += listfiles($file);
            $faisunZIP -> createfile();
            if ($filenum>0) header("location: {$webaddr}/{$flname}");
            else header("location: {$webaddr}/op/theme");
        }
    }
    exit;
}

if ($action=="theme") {
    $bgcolor=trim($_POST['bg']);
    $textcolor=trim($_POST['text']);
    $links=trim($_POST['links']);
    $sidebarcl=trim($_POST['sidebarcl']);
    $sidebox=trim($_POST['sidebox']);
    $pictype=$_POST['pictype'];
    $newbgurl=$_POST['newbgurl'];

    $uppictype = array("image/jpg","image/pjpeg","image/jpeg","image/gif","image/png","image/x-png","image/bmp");
    if ($_FILES['bgpicture']['name']) {
        if (!in_array($_FILES['bgpicture']['type'], $uppictype)) {
            echo "<script>alert('很抱歉，您上传的图片过大或者类型不正确！');location.href='$webaddr/op/theme'</script>";
            exit;
        }
        @unlink(ET_ROOT."/attachments/photo/user_".$my[user_id]."/themebg.jpg");
        @unlink(ET_ROOT."/attachments/photo/user_".$my[user_id]."/themebg_thumb.jpg");
        include(ET_ROOT."/include/uploadpic.func.php");
        UploadImage("bgpicture",1,112,72,ET_ROOT."/attachments/photo/user_".$my[user_id]."/",ET_ROOT."/attachments/photo/user_".$my[user_id]."/","themebg","themebg_thumb","jpg");

        $pictype=$pictype?$pictype:"center";
        $bgurl="attachments/photo/user_".$my[user_id]; //不需要添加 $webaddr
    }
    $newbgurl=$bgurl?$bgurl:$newbgurl;
    $newbgurl=daddslashes($newbgurl);

    $db->query("UPDATE et_users SET theme_bgcolor='$bgcolor',theme_pictype = '$pictype',theme_text='$textcolor',
    theme_link='$links',theme_sidebar='$sidebarcl',theme_sidebox='$sidebox',theme_bgurl='$newbgurl' WHERE  user_id='$my[user_id]'");

    dsetcookie('setok','theme1');
    header("location:$webaddr/op/theme");
    exit;
}

$query = $db->query("SELECT * FROM et_usertemplates WHERE isopen='1' ORDER BY ut_id");
while ($data= $db->fetch_array($query)) {
    $ut_id=$data['ut_id'];
    $theme_bgcolor=$data['theme_bgcolor'];
    $theme_pictype=$data['theme_pictype'];
    $theme_text=$data['theme_text'];
    $theme_link=$data['theme_link'];
    $theme_sidebar=$data['theme_sidebar'];
    $theme_sidebox=$data['theme_sidebox'];
    $theme_upload=$data['theme_upload'];
    $element=$theme_bgcolor.",".$theme_text.",".$theme_link.",".$theme_sidebar.",".$theme_sidebox.",".$theme_upload.",".$theme_pictype.",".$ut_id;

    $ut[] = array("ut_id"=>$ut_id,"theme_bgcolor"=>$theme_bgcolor,"theme_pictype"=>$theme_pictype,"theme_text"=>$theme_text
        ,"theme_link"=>$theme_link,"theme_sidebar"=>$theme_sidebar,"theme_sidebox"=>$theme_sidebox,"theme_upload"=>$theme_upload,"element"=>$element);
}

//模板和Foot
$menu="theme";
$web_name3="模板设置";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_theme.htm'));
?>