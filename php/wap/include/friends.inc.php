<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

if (!$user['user_id']) {
    showmessage("<div class='showmag'><p>您还没有登录，不能执行此操作！</p><p><a href='index.php?op=login'>现在登陆</a></p></div>");
    exit;
}

$fop=$_GET['fop']?$_GET['fop']:"fri";

//删除提示
if($act=="delfri") {
    $uid=$_GET['uid'];
    $fri=user_info("user_id='$uid'");
    if(!$fri) {
        showmessage("<div class='showmag'><p>该用户不存在或者已经被管理员删除！</p><p><a href='$refer'>返回上一页</a></p></div>");
        exit;
    }
    $isfriend=isfriend($uid,$user[user_id]);
    if($isfriend==0) {
        showmessage("<div class='showmag'><p>您没有关注此用户！</p><p><a href='$refer'>返回上一页</a></p></div>");
        exit;
    } else {
        showmessage("<div class='showmag'><p>是否确认解除对 ".$fri[nickname]." 的关注？</p><p><a href='index.php?op=friends&act=delfriok&uid=$uid'>确认</a> <a href='index.php?op=friends'>取消</a></p></div>");
        exit;
    }
}

//删除关注
if ($act =="delfriok") {
    $uid=$_GET['uid'];
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

wapheader();
//导航
if ($fop=="fri") echo "<h2>我关注 | <a href='index.php?op=friends&fop=fol'>关注我</a></h2>";
else if ($fop=="fol") echo "<h2><a href='index.php?op=friends&fop=fri'>我关注</a> | 关注我</h2>";

if ($fop=="fri") {
    echo "<ul>";
    $start= ($page-1)*10;
    $query= $db->query("SELECT u.user_id,u.user_name,u.nickname,u.user_info FROM et_friend AS f LEFT JOIN et_users AS u ON f.fid_jieshou = u.user_id WHERE f.fid_fasong ='$user[user_id]' ORDER BY f.fri_id DESC LIMIT $start,10");
    while ($data=$db->fetch_array($query)){
        echo "<li><a href='index.php?op=home&uid=$data[user_id]'>$data[nickname]</a> $data[user_info] <span class='stamp'><a href='index.php?op=sendmsg&uid=$data[user_id]'>私信</a> <a href='index.php?op=friends&act=delfri&uid=$data[user_id]'>解除</a></span></li>";
    }
    echo "</ul>";

    $total = $db->result($db->query("SELECT count(*) FROM et_friend AS f LEFT JOIN et_users AS u ON f.fid_jieshou = u.user_id WHERE f.fid_fasong ='$user[user_id]'"),0);
    $pg_num=ceil($total/10);
    if ($pg_num>1) {
        echo "<div class='page'>";
        if ($page-1>0) echo "<a href='index.php?op=friends&fop=fri&page=".($page-1)."'>上页</a>&nbsp;";
        if ($page+1<=$pg_num) echo "<a href='index.php?op=friends&fop=fri&page=".($page+1)."'>下页</a>&nbsp;";
        echo "| ".$page."/".$pg_num;
        echo "</div>";
    }
} else if ($fop=="fol"){
    echo "<ul>";
    $start= ($page-1)*10;
    $query= $db->query("SELECT u.user_id,u.user_name,u.nickname,u.user_info FROM et_friend AS f LEFT JOIN et_users AS u ON f.fid_fasong = u.user_id WHERE f.fid_jieshou ='$user[user_id]' ORDER BY f.fri_id DESC LIMIT $start,10");
    while ($data=$db->fetch_array($query)){
        echo "<li><a href='index.php?op=home&uid=$data[user_id]'>$data[nickname]</a> $data[user_info] <span class='stamp'><a href='index.php?op=sendmsg&uid=$data[user_id]'>私信</a></span></li>";
    }
    echo "</ul>";

    $total = $db->result($db->query("SELECT count(*) FROM et_friend AS f LEFT JOIN et_users AS u ON f.fid_fasong = u.user_id WHERE f.fid_jieshou ='$user[user_id]'"),0);
    $pg_num=ceil($total/10);
    if ($pg_num>1) {
        echo "<div class='page'>";
        if ($page-1>0) echo "<a href='index.php?op=friends&fop=fol&page=".($page-1)."'>上页</a>&nbsp;";
        if ($page+1<=$pg_num) echo "<a href='index.php?op=friends&fop=fol&page=".($page+1)."'>下页</a>&nbsp;";
        echo "| ".$page."/".$pg_num;
        echo "</div>";
    }
}
?>