<?php
$API=1;
include('../common.inc.php');

//发送私信
if($action=='send') {
	$content = trim($_POST["content"]);
    $funame = $_POST["funame"];
    $user=user_info("user_name='$funame'");
    if (!$user['user_id']) {
        echo '您发送的用户不存在';
        exit;
    }
	if (!empty($content)) {
        $content=getsubstrutf8($content,0,140,false);
        $content=replace($content);
        $content=daddslashes($content);

        $db->query("UPDATE et_users SET priread = priread+1 WHERE user_id='$user[user_id]'");
        $db->query("INSERT INTO et_messages (senduid,sendname,sendnickname,sendhead,sendtouid,sendtoname,sendtonickname,messagebody,sendtime) VALUES ('$my[user_id]','$my[user_name]','$my[nickname]','$my[user_head]','$user[user_id]','$user[user_name]','$user[nickname]','$content','$addtime')");
        echo 'success';
        exit;
    } else {
        echo '您没有填写发送的内容，返回重新填写';
        exit;
    }
}

if ($act=='getuserinfo') {
    $uid=$_GET['uid'];
    $class=$_GET['class'];
    $userquery = $db->query("SELECT nickname,user_head,lastcontent,lastconttime FROM et_users WHERE user_id='$uid'");
    $user=$db->fetch_array($userquery);
    $head=$user['user_head']?"$webaddr/attachments/head/".$user['user_head']:"$webaddr/images/noavatar.jpg";
    $content=simplecontent($user[lastcontent]);

    $time=$user[lastconttime]?timeop($user[lastconttime]):"";
    echo '<div class="'.$class.'"></div><table width="200" border="0" cellpadding="0" cellspacing="0"><tr><td width="53" rowspan="2" align="left" valign="top"><img src="'.$head.'" width="48px" /></td><td><strong>'.$user[nickname].'：</strong>'.emotionrp($content).'</td></tr><tr><td class="followtime">'.$time."</td></tr></table>";
    exit;
}

if ($act=='getreplycontent') {
    $contid=$_GET['contid'];
    $contdata=getReply($contid);
    if ($contdata) {
        $contents=ubb($contdata['content_body']);
        echo '<div class="status_reply_list">
            <div class="top"></div>
            <div class="cont">
            <h1 class="line">以下是原文：<a href="'.$webaddr.'/op/view/'.$contid.'">原文回复('.$contdata['replytimes'].')</a></h1>
            <div class="replyajaxbox"><a href="'.$webaddr.'/'.$contdata['user_name'].'">'.$contdata['user_nickname'].'</a>：'.$contents.'</div>
            </div>
            <div class="bottom"></div>
            </div>';
    }
}
?>