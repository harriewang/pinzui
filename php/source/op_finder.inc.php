<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

$page=$_GET['page']?intval($_GET['page']):1;
$oc=$_GET['oc']?$_GET['oc']:"search";

//发送邀请
if ($action=="invite") {
    tologin();
    $send_body=trim($_POST['textarea']);
    $s_mail=trim($_POST['email']);
    $email_message_title="$my[nickname] 邀请您加入贫嘴";
    $send_body="您好!
    $send_body
    记得来看看我的空间：
    $webaddr/$my[user_name]

    贫嘴,是一个迷你博客，您可以：
    ——随时随地发布消息，分享您的心情
    ——时时刻刻关注朋友的生活
    ——通过手机、网页、MSN、QQ、Gtalk更多......

    你的好友 $my[nickname]";

    $email_message_title=iconv("utf-8", "gbk",$email_message_title);
    $send_body=iconv("utf-8", "gbk",$send_body);
    if ($s_mail) {
        include("include/mail.class.php");
        sendmail($s_mail,$email_message_title,$send_body);
        dsetcookie('setok','finder1');
        header("location:$webaddr/op/finder&oc=invite");
        exit;
    } else {
        dsetcookie('setok','finder2');
        header("location:$webaddr/op/finder&oc=invite");
        exit;
    }
}

//搜索查询
if ($act=="search")  {
    $sname=daddslashes($_GET['sname']);
    $gender= $_GET["gender"];
    if ($_GET["homesf"] && $_GET["homecity"]) $homepro=$_GET["homesf"]." ".$_GET["homecity"];
    else $homepro="";

    if ($_GET["livesf"] && $_GET["livecity"]) $livepro=$_GET["livesf"]." ".$_GET["livecity"];
    else $livepro="";

    if ($gender) $ext1=" && user_gender='$gender' ";
    if ($homepro) $ext2=" && home_city='$homepro' ";
    if ($livepro) $ext3=" && live_city='$livepro' ";
    $ext=$ext1.$ext2.$ext3;

    if (!$sname && !$gender && !$homepro && !$livepro) {
        $findnum=-1;
    } else {
        $findnum=0;
        $start= ($page-1)*10;
        $uidarray=array();
        $query = $db->query("SELECT user_id,user_name,nickname,user_head,user_gender,home_city,live_city FROM et_users WHERE nickname LIKE '%$sname%' $ext order by user_id LIMIT $start,10");
        while($data = $db->fetch_array($query)) {
            $findnum++;
            $f_uid=$data['user_id'];
            $uidarray[]=$f_uid;
            $f_uname=$data['user_name'];
            $f_nickname=$data['nickname'];
            $f_ugender=$data['user_gender']?$data['user_gender']:"未填写";
            $f_homepro=$data['home_city']?$data['home_city']:"未填写";
            $f_livepro=$data['live_city']?$data['live_city']:"未填写";
            $f_uhead=$data['user_head']?"$webaddr/attachments/head/".$data['user_head']:"$webaddr/images/noavatar.jpg";

            $find[] = array("f_uid"=>$f_uid,"f_uname"=>$f_uname,"f_nickname"=>$f_nickname,"f_ugender"=>$f_ugender,"f_homepro"=>$f_homepro,"f_livepro"=>$f_livepro,"f_uhead"=>$f_uhead,"isfriend"=>0);
        }
        $uids=implode(",",$uidarray);
        if ($uids) {
            $query = $db->query("SELECT fid_jieshou FROM et_friend WHERE fid_jieshou in ($uids) && fid_fasong='$my[user_id]'");
            while($data = $db->fetch_array($query)) {
                $i=0;
                foreach ($find as $key=>$value) {
                    $i++;
                    if($value['f_uid']==$data['fid_jieshou']) {
                        $find[$i-1]['isfriend']=1;
                    }
                }
            }
        }
    }
}

//模板和Foot
$menu="finder";
$web_name3=$oc=="search"?"找朋友":"邀请";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_finder.htm'));
?>