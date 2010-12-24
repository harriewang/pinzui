<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

function UploadImage($upname,$smallmark=1,$dstsw,$dstsh=0,$path_dim,$path_xim,$newname,$smallname=0) {
    global $_FILES,$tsid;
    $phpv=str_replace('.', '', PHP_VERSION);
    $filename=$upname;
    $max_file_size = 2147483648;        //上传文件大小限制, 单位BYTE 2m
    $path_im = $path_dim;               //生成大图保存文件夹路径
    $path_sim = $path_xim;              //缩略图保存文件夹路径
    $simclearly=75;
    $simclearlypng =$phpv>=512?7:75;        //缩略图清晰度0-100，数字越大越清晰，文件尺寸越大
    $smallmark = $smallmark;            //是否生成缩略图(1为加生成,其他为不);
    $dst_sw =$dstsw;                   //定义缩略图宽度，高度我采用等比例缩放，所以只要比较宽度就可以了
    $uptypes=array(
        'image/jpg',
        'image/jpeg',
        'image/png',
        'image/pjpeg',
        'image/gif',
        'image/bmp',
        'image/x-png'
    );

    if (!is_uploaded_file($_FILES[$filename][tmp_name])) {
        showmessage("<div class='showmag'><p>上传失败，文件过大或者文件不存在！</p><p><a href='index.php?op=sendphoto'>重新上传</a></p></div>");
        exit;
    }
    $file = $_FILES[$filename];

    if($max_file_size < $file["size"]) { //检查文件大小
        showmessage("<div class='showmag'><p>上传图片过大，请控制在2M之内！</p><p><a href='index.php?op=sendphoto'>重新上传</a></p></div>");
        exit;
    }
    if(!in_array($file["type"],$uptypes)) { //检查文件类型
        showmessage("<div class='showmag'><p>上传失败，图片格式不正确！</p><p><a href='index.php?op=sendphoto'>重新上传</a></p></div>");
        exit;
    }
    if(!file_exists($path_im)) {    //检查上传目录是否存在，不存在创建
        mkdir($path_im);
    }

    $filename = $file["tmp_name"];
    $im_size = getimagesize($filename);

    $src_w = $im_size[0];
    $src_h = $im_size[1];
    $src_type = $im_size[2];

    $pinfo = pathinfo($file["name"]);
    $filetype = $pinfo['extension'];
    $all_path = $path_im.$newname.".".$filetype;   //路径+文件名,目前以上传时间命名
    if (file_exists($all_path)) {
        @unlink($all_path);
    }
    if(!move_uploaded_file ($filename,$all_path)) {
        showmessage("<div class='showmag'><p>上传失败，附件文件不存在！</p><p><a href='index.php?op=sendphoto'>重新上传</a></p></div>");
        exit;
    }
    $pinfo = pathinfo($all_path);
    $fname = $pinfo[basename];

    switch($src_type)//判断源图片文件类型
    {
         case 1://gif
         $src_im = @imagecreatefromgif($all_path);//从源图片文件取得图像
         break;
         case 2://jpg
         $src_im = @imagecreatefromjpeg($all_path);
         break;
         case 3://png
         $src_im = @imagecreatefrompng($all_path);
         break;
         //case 6:
         //$src_im=imagecreatefromwbmp($all_path);
         //break;
         default:
         showmessage("<div class='showmag'><p>上传失败，图片格式不正确！</p><p><a href='index.php?op=sendphoto'>重新上传</a></p></div>");
         exit;
    }

   if($smallmark == 1) {
       if(!file_exists($path_sim)) {   //检查缩略图目录是否存在，不存在创建
           mkdir($path_sim);
       }
       if ($smallname) $newname=$smallname;
       $sall_path = $path_sim.$newname.".".$filetype;
       if (file_exists($sall_path)) {
           @unlink($sall_path);
       }
       if($src_w <= $dst_sw) { // 原图尺寸 <= 缩略图尺寸
           if ($dstsh==0)  {
                $dst_sim = @imagecreatetruecolor($src_w,$src_h); //新建缩略图真彩位图
                $sx=$sy=0;
           } else {
                $dst_sim = @imagecreatetruecolor($dstsw,$dstsh); //新建缩略图真彩位图
                $sx=($dstsw-$src_w)/2;
                $sy=($dstsh-$src_h)/2;
           }
           $img = @imagecreatefrompng("images/phbg.png");
           @imagecopymerge($dst_sim,$img,0,0,0,0,$dstsw,$dstsh,100); //原图图像写入新建真彩位图中
           @imagecopymerge($dst_sim,$src_im,$sx,$sy,0,0,$src_w,$src_h,100); //原图图像写入新建真彩位图中
       }

       if($src_w > $dst_sw) { // 原图尺寸 > 缩略图尺寸
           $dst_sh = $dst_sw/$src_w*$src_h;
           if ($dst_sh<$dstsh) {
               $dst_sh=$dstsh;
               $dst_sw=$dst_sh/$src_h*$src_w;
           }
           if ($dstsh==0) {
                $dst_sim = @imagecreatetruecolor($dst_sw,$dst_sh); //新建缩略图真彩位图（等比例缩小原图尺寸）
           } else {
                $dst_sim = @imagecreatetruecolor($dstsw,$dstsh); //新建缩略图真彩位图（等比例缩小原图尺寸）
           }
           @imagecopyresampled($dst_sim,$src_im,0,0,0,0,$dst_sw,$dst_sh,$src_w,$src_h); //原图图像写入新建真彩位图中
       }

       switch($src_type) {
            case 1:@imagegif($dst_sim,$sall_path,$simclearly);//生成gif文件，图片清晰度0-100
            break;
            case 2:@imagejpeg($dst_sim,$sall_path,$simclearly);//生成jpg文件，图片清晰度0-100
            break;
            case 3:@imagepng($dst_sim,$sall_path,$simclearlypng);//生成png文件，图片清晰度0-100
            break;
            //case 6:
            //imagewbmp($dst_sim,$sall_path);
            break;
       }
       //释放缓存
       @imagedestroy($dst_sim);
}
    @imagedestroy($src_im);
    return $newname.".".$filetype;
}
?>