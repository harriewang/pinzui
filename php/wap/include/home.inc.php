<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

$uid=$_GET['uid']?$_GET['uid']:$user[user_id];
$refer=$_GET['refer'];

//添加关注
if ($act =="guanzhu") {
    $fri=user_info("user_id='$uid'");
    if(!$fri) {
        showmessage("<div class='showmag'><p>该用户不存在或者已经被管理员删除！</p><p><a href='$refer'>返回上一页</a></p></div>");
        exit;
    }
    $isfriend=isfriend($uid,$user[user_id]);
    if($isfriend==1) {
        showmessage("<div class='showmag'><p>您已经关注过此用户！</p><p><a href='$refer'>返回上一页</a></p></div>");
    } else {
        if (isfriend($user[user_id],$uid)==1) {
            $msg="$user[nickname] 关注了你！";
        } else {
            $msg="$user[nickname] 关注了你，你也去关注一下TA吧！";
        }
        $db->query("INSERT INTO et_messages (senduid,sendname,sendnickname,sendhead,sendtouid,sendtoname,sendtonickname,messagebody,sendtime) VALUES ('$user[user_id]','$user[user_name]','$user[nickname]','$user[user_head]','$fri[user_id]','$fri[user_name]','$fri[nickname]','$msg','$addtime')");

        $db->query("INSERT INTO et_friend  (fid_jieshou,fid_fasong) VALUES ('$uid','$user[user_id]')");
        frinum($user[user_id]);
        frinum($uid);

        showmessage("<div class='showmag'><p>关注好友成功！</p><p><a href='$refer'>返回上一页</a></p></div>");
    }
    exit;
}

//删除关注
if ($act =="jiechu") {
    $fri=user_info("user_id='$uid'");
    if(!$fri) {
        showmessage("<div class='showmag'><p>该用户不存在或者已经被管理员删除！</p><p><a href='$refer'>返回上一页</a></p></div>");
        exit;
    }
    $isfriend=isfriend($uid,$user[user_id]);
    if($isfriend==0) {
        showmessage("<div class='showmag'><p>您没有关注此用户！</p><p><a href='$refer'>返回上一页</a></p></div>");
    } else {
        $db->query("DELETE FROM et_friend WHERE fid_fasong='$user[user_id]' && fid_jieshou='$uid'");
        frinum($user[user_id]);
        frinum($uid);

        showmessage("<div class='showmag'><p>解除好友成功！</p><p><a href='$refer'>返回上一页</a></p></div>");
    }
    exit;
}

//删除提示
if ($act=="delmsg") {
    $sid=$_GET['sid'];
    $from=urlencode($_GET['from']);
    if (getcount("et_content",array('content_id'=>$sid,"user_id"=>$user['user_id']))) {
        showmessage("<div class='showmag'><p>是否确认删除此条消息！</p><p><a href='index.php?op=home&act=delmsgeok&sid=$sid&from=$from'>确认</a> <a href='$from'>取消</a></p></div>");
    } else {
        showmessage("<div class='showmag'><p>您无权删除此条消息！</p><p><a href='$from'>返回上一页</a></p></div>");
    }
    exit;
}

//删除确认
if ($act=="delmsgeok") {
    $sid=$_GET['sid'];
    $from=urldecode($_GET['from']);
    if (getcount("et_content",array('content_id'=>$sid,"user_id"=>$user['user_id']))) {
        $db->query("DELETE FROM et_content WHERE user_id='$user[user_id]' && content_id='$sid'");

        showmessage("<div class='showmag'><p>删除消息成功！</p><p><a href='$from'>返回上一页</a></p></div>");
    } else {
        showmessage("<div class='showmag'><p>您无权删除此条消息！</p><p><a href='$from'>返回上一页</a></p></div>");
    }
    exit;
}

wapheader();
//信息查询
$query = $db->query("SELECT user_name,nickname,home_city,live_city,user_gender,user_info,user_head FROM et_users WHERE user_id='$uid'");
$data = $db->fetch_array($query);
$username=$data['nickname'];
$home_city=$data['home_city']?$data['home_city']:"保密";
$live_city=$data['live_city']?$data['live_city']:"保密";
$user_gender=$data['user_gender']?$data['user_gender']:"保密";
$user_info=$data['user_info']?$data['user_info']:"保密";
$user_head=$data['user_head'];
$user_head=$user_head?"http://pinzui.com/attachments/head/".$user_head:"http://pinzui.com/images/noavatar.jpg";

echo "<div style='padding:2px'><p><img src='$user_head' width='96px'></p>";

if ($uid!=$user[user_id]) {
    $isfriend=isfriend($uid,$user[user_id]);
    if ($isfriend==1) {
        echo "<a href='index.php?op=sendmsg&uid=$uid'>发私信</a> | <a href='index.php?op=home&act=jiechu&uid=$uid&refer=".urlencode("index.php?op=home&uid=".$uid)."'>解除关注</a>";
    } else {
        echo "<a href='index.php?op=sendmsg&uid=$uid'>发私信</a> | <a href='index.php?op=home&act=guanzhu&uid=$uid&refer=".urlencode("index.php?op=home&uid=".$uid)."'>添加关注</a>";
    }
}
echo "</div><h2>".$username." 在做什么...</h2><ul>";

$i=0;
$start= ($page-1)*10;
$query = $db->query("SELECT * FROM et_content WHERE user_id='$uid' && privacy=0 && replyshow=1 ORDER BY content_id desc limit $start,10");
while($data = $db->fetch_array($query)) {
    $i++;
    echo wapli($data[content_id],$data[user_id],$data[user_nickname],"[".($i+($page-1)*10)."].".$data['content_body'],$data['posttime'],$data[type],'index.php?op=home',$data['status_id'],$data['status_uname'],$data['status_unickname'],0);
}
if ($i==0) echo $username." 还没有发布消息";
echo "</ul>";

//分页
$total=$total=getcount("et_content",array("user_id"=>$uid,"privacy"=>0,"replyshow"=>1));;
$pg_num=ceil($total/10);
if ($pg_num>1) {
    echo "<div class='page'>";
    if ($page-1>0) echo "<a href='index.php?op=home&uid=$uid&page=".($page-1)."'>上页</a>&nbsp;";
    if ($page+1<=$pg_num)  echo "<a href='index.php?op=home&uid=$uid&page=".($page+1)."'>下页</a>&nbsp;";
    echo "| ".$page."/".$pg_num;
    echo "</div>";
}

//资料
echo "<h2>$username 的资料</h2>
    <p>性别：$user_gender</p>
    <p>家乡：$home_city</p>
    <p>来自：$live_city</p>
    <p>签名：$user_info</p>";
?>
