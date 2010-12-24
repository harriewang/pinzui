<?PHP
include('common.inc.php');

$hmarray=array('home','favorite','friend','privatemsg','replies','profile');
$hmsarray=array('privatemsg','replies');
$user_name=$_GET['user_name']?$_GET['user_name']:$my['user_name'];
$page=$_GET['page']?$_GET['page']:1;
$hm=$_GET['hm'];
$profile=$_GET['profile'];
$hms=$_GET['hms'];
if ($hms && !in_array($hms,$hmsarray)) header("Location: $webaddr/$my[user_name]/profile");
if($profile) $hms=$hms?$hms:'friend';
else $hms='home';

$tplhm="template \"hm_".$hm.".htm\"";

if (!$user_name) header("Location: $webaddr/op/login");
$user=homeuser($user_name);
if ($profile && $user[user_id]!=$my[user_id]) header("Location: $webaddr/$my[user_name]/profile");

//添加关注
if ($act =='addfollow') {
    tologin();
    if(!$user[user_id]) {
        echo '该用户不存在或者已经被管理员删除！';
        exit;
    }
    $isfriend=isfriend($user[user_id],$my[user_id]);
    if($isfriend==1) {
        echo '您已经关注过此用户！';
        exit;
    } else {
        $msg="$my[nickname] 关注了你！";
        $db->query("UPDATE et_users SET priread = priread+1 WHERE user_id='$user[user_id]'");
        $db->query("INSERT INTO et_messages (senduid,sendname,sendnickname,sendhead,sendtouid,sendtoname,sendtonickname,messagebody,sendtime) VALUES ('$my[user_id]','$my[user_name]','$my[nickname]','$my[user_head]','$user[user_id]','$user[user_name]','$user[nickname]','$msg','$addtime')");
        $db->query("INSERT INTO et_friend  (fid_jieshou,fid_fasong) VALUES ('$user[user_id]','$my[user_id]')");
        frinum($my[user_id]);
        frinum($user[user_id]);
        echo 'success';
        exit;
    }
}

//解除关注
if ($act =='delfollow') {
    tologin();
    if(!$user[user_id]) {
        echo '该用户不存在或者已经被管理员删除！';
        exit;
    }
    $isfriend=isfriend($user[user_id],$my[user_id]);//第二个参数是我的id
    if($isfriend==0) {
        echo '您没有关注此用户！';
        exit;
    } else {
        $db->query("DELETE FROM et_friend WHERE fid_fasong='$my[user_id]' && fid_jieshou='$user[user_id]'");
        frinum($my[user_id]);
        frinum($user[user_id]);
        echo 'success';
        exit;
    }
}

//转发
if ($act=='zhuanfa') {
    tologin();
    $cid=$_GET['cid'];
    $query = $db->query("SELECT user_id,user_name,user_nickname,content_body,privacy,status_id FROM et_content WHERE content_id='$cid'");
    $data = $db->fetch_array($query);
    if($data && $data[privacy]==0 && !$data[status_id]) {
        $content=$data['content_body'];
        $contentmetion="转发自[url={$webaddr}/{$data[user_name]}]{$data[user_nickname]}[/url]：";
        if(is_numeric(strpos($content,$contentmetion))) {
            $content=str_replace($contentmetion,"",$content); //如果有则替换空前置
        }
        if(!is_numeric(strpos($content,$contentmetion))) {
            $content=daddslashes($contentmetion.$content);
        }
        $db->query("INSERT INTO et_content (user_id,user_name,user_nickname,user_head,content_body,posttime) VALUES ('$my[user_id]','$my[user_name]','$my[nickname]','$my[user_head]','$content','$addtime')");
        $insertid=mysql_insert_id();
        if ($data[user_id]!=$my[user_id]) {
            $msg=daddslashes("[url={$webaddr}/{$my[user_name]}]{$my[nickname]}[/url] 转发了您的消息，[url={$webaddr}/op/view/{$insertid}]点击查看[/url]");
            $db->query("INSERT INTO et_messages (senduid,sendname,sendnickname,sendhead,sendtouid,sendtoname,sendtonickname,messagebody,sendtime) VALUES ('$my[user_id]','$my[user_name]','$my[nickname]','$my[user_head]','$data[user_id]','$data[user_name]','$data[user_nickname]','$msg','$addtime')");
            $db->query("UPDATE et_users SET priread = priread+1 WHERE user_id='$data[user_id]'");
        }
        $db->query("UPDATE et_users SET msg_num=msg_num+1,lastcontent='$content',lastconttime='$addtime' WHERE user_id='$my[user_id]'");
        $db->query("UPDATE et_content SET zftimes = zftimes+1 WHERE content_id='$cid'");
        echo 'success';
        exit;
    } else {
        echo 'error';
        exit;
    }
}

//以下是 发送 代码
if ($action =='msgsend') {
    tologin();
    $content=getsubstrutf8($_POST["content"],0,140,false);
    $morecontent = trim($_POST["morecontent"]);//不计入140字符之内
    $privacy = $_POST["privacy"];
    if (!empty($content) && $content!='#请在这里输入自定义话题#') {
        $content=replace($content); //词语过滤
        explodetopic($content); //专题
        $back=atsend($content); //@
        $content=$back['content'];
        $uids=$back['uids'];
        $content=daddslashes($content);
        $content=$content.$morecontent;

        $db->query("INSERT INTO et_content (user_id,user_name,user_nickname,user_head,content_body,posttime,privacy) VALUES ('$my[user_id]','$my[user_name]','$my[nickname]','$my[user_head]','$content','$addtime','$privacy')");
        $insertid=mysql_insert_id();
        if ($insertid) {
            for($i=0;$i<count($uids);$i++) {
                $db->query("UPDATE et_users SET replyread = replyread+1 WHERE user_id='$uids[$i]'");
                $db->query("INSERT INTO et_replyto (user_id,content_id) VALUES ('$uids[$i]','$insertid')");
            }
            if ($privacy==0) {
                $db->query("UPDATE et_users SET msg_num=msg_num+1,lastcontent='$content',lastconttime='$addtime' WHERE user_id='$my[user_id]'");
            }
        }
        echo loadoneli($insertid,$my[user_name],$my[user_id],$my[nickname],$my[user_head],ubb($content),'刚才','网页',0,0,$privacy,0,0,0,$privacy);
        exit;
    } else {
        echo 'error';
        exit;
    }
}

//上传照片
if ($action=='uploadphoto') {
    tologin();
    if ($_FILES['photo']['name']) {
        include(ET_ROOT."/include/uploadpic.func.php");
        $ptname=date(YmdHms);
        $upname=UploadImage("photo",1,200,0,ET_ROOT."/attachments/photo/user_".$my[user_id]."/",ET_ROOT."/attachments/photo/user_".$my[user_id]."/",$ptname,$ptname."_thumb");
        $phototitle=$phototitle?$phototitle:"$ptname";
        $suffix=getfiletype($upname);
        $content="[img link=".urlop($webaddr."/attachments/photo/user_".$my[user_id]."/".$ptname.".".$suffix,'e')."]".urlop($webaddr."/attachments/photo/user_".$my[user_id]."/".$upname,'e')."[/img]";

        echo '{"ret":"success","img":"'.$webaddr.'/attachments/photo/user_'.$my[user_id].'/'.$upname.'","name":"'.$ptname.'.'.$suffix.'","content":"'.$content.'"}';
        exit;
    } else {
        echo '{"ret":"您没有选择照片"}';
        exit;
    }
}

//分享
if ($action=='share') {
    tologin();
    $linkdata = array();
    $link = htmlspecialchars(trim($_POST['link']));
    $describe=clean_html($_POST['describe']);
    if (!preg_match("/^http\:\/\/.{4,300}$/i", $link) || !$link) {
        dsetcookie('setok','home4');
        header("location: $webaddr/$my[user_name]/profile");
        exit;
    } elseif (StrLenW($describe)>100) {
        dsetcookie('setok','home5');
        header("location: $webaddr/$my[user_name]/profile");
        exit;
    } else {
        // 判断是否视频
        $parseLink = parse_url($link);
        $suffix=mediasuffix($link);
        if(preg_match("/(tudou.com|youku.com|ku6.com)$/i", strtolower($parseLink['host']), $hosts) && $suffix!="swf") {
            $flashvar = getFlash($link, strtolower($hosts[1]));
            if(!empty($flashvar)) {
                $type = 'video';
                $htmls=getVideoHtml($link,strtolower($hosts[1]));
                $videotitle=$htmls[0];
                $videopic=$htmls[1];
            }
        } else if (in_array($suffix,array("mp3","wma"))) {
            $type = 'music';
        } else if($suffix=='swf') {
            $type = 'flash';
        } else {
            $type = 'website';
        }
        $linkdt=base64_encode(serialize($linkdata));
        if ($type) {
            if ($describe) {
                $describe="[desc]".$describe."[/desc]";
            }
            if ($videotitle) {
                $describe=$videotitle.$describe;
            }
            if ($type=='video') {
                $content=$describe."[video host=".urlop($hosts[1],'e')." pic=".urlop($videopic,'e')."]{$flashvar}[/video]";
            } else if($type=='music') {
                $content="<p>我分享了音乐</p>".$describe."[music]".urlop($link,'e')."[/music]";
            } else if($type=='flash') {
                $content="<p>我分享了Flash</p>".$describe."[flash]".urlop($link,'e')."[/flash]";
            } else if($type=='website') {
                $content="<p>我分享了网址</p>".$describe."{$link}";
            }
            $content=replace($content); //词语过滤
            $content=daddslashes($content);
            $db->query("INSERT INTO et_content (user_id,user_name,user_nickname,user_head,content_body,posttime,conttype) VALUES ('$my[user_id]','$my[user_name]','$my[nickname]','$my[user_head]','$content','$addtime','media')");
            updatemsgnum('++',$my[user_id]);//更新消息数

            dsetcookie('setok','home6');
            header("location: $webaddr/$my[user_name]/profile");
            exit;
        } else {
            dsetcookie('setok','home7');
            header("location: $webaddr/$my[user_name]/profile");
            exit;
        }
    }
}

//好友判断
if ($user['user_id']!=$my['user_id']) $isfriend=isfriend($user['user_id'],$my['user_id']);

//粉丝
$folownum=0;
$query= $db->query("SELECT u.user_id,u.user_name,u.nickname,u.user_head FROM et_friend AS f LEFT JOIN et_users AS u ON f.fid_fasong = u.user_id WHERE f.fid_jieshou ='$user[user_id]' ORDER BY f.fri_id DESC LIMIT 35");
while ($data=$db->fetch_array($query)){
    $folownum++;
    $ushead=$data['user_head']?"$webaddr/attachments/head/".$data['user_head']:"$webaddr/images/noavatar.jpg";
    $myfri[] = array("uid"=>$data['user_id'],"usname"=>$data['user_name'],"usnickname"=>$data['nickname'],"ushead"=>$ushead);
}

if ($hm) {
    if (in_array($hm,$hmarray)) {
        include('source/hm_'.$hm.'.inc.php');
        exit;
    } else {
        header("Location: $webaddr/$my[user_name]/profile");
    }
}

//模板和Foot
if ($user['user_id']==$my['user_id']) $menu="home";
if ($profile==1) $menu="profile";
$web_name3=$user[nickname];
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('home.htm'));
?>