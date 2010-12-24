<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

if ($action=="upload") {
    $phototitle=daddslashes(trim($_POST['phototitle']));
    if(StrLenW($phototitle)>20) {
        showmessage("<div class='showmag'><p>相片名称要不能大于20字符！</p><p><a href='index.php?op=sendphoto'>重新上传</a></p></div>");
        exit;
    }
    if ($_FILES['photo']['name']) {
        include("include/uploadpic.func.php");
        $ptname=date(YmdHms);
        $upname=UploadImage("photo",1,200,0,"../attachments/photo/user_".$user[user_id]."/","../attachments/photo/user_".$user[user_id]."/",$ptname,$ptname."_thumb");
        $phototitle=$phototitle?$phototitle:"$ptname";
        $suffix=getsubstrutf8($upname,-3,3,false);

        $content="{$phototitle}<br/>[img link=".$webaddr."/attachments/photo/user_".$user[user_id]."/".$ptname.".".$suffix."]".$webaddr."/attachments/photo/user_".$user[user_id]."/".$upname."[/img]";

        $db->query("INSERT INTO et_content (user_id,user_name,user_nickname,user_head,content_body,posttime,type,conttype) VALUES ('$user[user_id]','$user[user_name]','$user[nickname]','$user[user_head]','$content','$addtime','手机','photo')");

        showmessage("<div class='showmag'><p>照片上传成功了！</p><p><a href='$refer'>返回上一页</a></p></div>");
        exit;
    } else {
        showmessage("<div class='showmag'><p>照片上传失败！</p><p><a href='index.php?op=sendphoto'>重新上传</a></p></div>");
        exit;
    }
}

wapheader();
echo "<h2>发照片</h2>".
"<form enctype='multipart/form-data' action='index.php?op=sendphoto' method='post'>".
"建议照片大小不超过500K。照片文件名不要包含中文。如果照片太大，建议压缩后再上传。".
"<p>相片名称：<input type='text' name='phototitle' value='我分享了照片'/></p>".
"<p>选择照片：<input type='file' name='photo'/></p>".
"<p><input type='hidden' name='action' value='upload' /><input type='submit' value='上传' /></p>".
"</form>";
?>