<?PHP
if(!defined('IN_ET')) {
	exit('Access Denied');
}

$user_name=$_GET['user_name']?$_GET['user_name']:$my[user_name];
$user=user_info("user_name='".$user_name."'");
$page=$_GET['page']?$_GET['page']:1;
$act=$act?$act:"follow";
$start=($page-1)*20;

//用户信息
$user['user_head']=$user['user_head']?"$webaddr/attachments/head/".$user['user_head']:"$webaddr/images/noavatar.jpg";
$user['old']=date(Y)-getsubstrutf8($user['birthday'],0,4);
if($user['home_city']=="选择省份 选择城市" || $user['home_city']=="" || $user['home_city']==" ") $user['home_city']="";
else $user['home_city']="<a href='$webaddr/op.php?op=finder&sname=&act=search&homesf=".$tem1[0]."&homecity=".$tem1[1]."'>".$tem1[0]." ".$tem1[1]."</a>";
if($user['live_city']=="选择省份 选择城市" || $user['live_city']=="" || $user['live_city']==" ") $user['live_city']="";
else $user['live_city']="<a href='$webaddr/op.php?op=finder&sname=&act=search&livesf=".$tem2[0]."&livecity=".$tem2[1]."'>".$tem2[0]." ".$tem2[1]."</a>";

if ($act=='follow') {
    $query= $db->query("SELECT u.user_name,u.nickname,u.user_head,u.user_gender,u.live_city,u.msg_num,u.followme_num,u.follow_num FROM et_friend AS f LEFT JOIN et_users AS u ON f.fid_jieshou = u.user_id WHERE f.fid_fasong ='$user[user_id]' ORDER BY f.fri_id DESC LIMIT $start,20");
    while ($data=$db->fetch_array($query)){
        $ushead=$data['user_head']?"$webaddr/attachments/head/".$data['user_head']:"$webaddr/images/noavatar.jpg";
        $myfri[] = array("usname"=>$data['user_name'],"usnickname"=>$data['nickname'],"ushead"=>$ushead,"usgender"=>$data['user_gender'],
            "uslivecity"=>$data['live_city'],"usfolme"=>$data['followme_num'],"usfol"=>$data['follow_num'],"usmsgnum"=>$data['msg_num']);
    }
    $total=$user['follow_num'];
    $pg_num=ceil($total/20);
}

if ($act=="followme") {
    $myfrilist=array();
    $ismyfri=array();
    $query= $db->query("SELECT u.user_id,u.user_name,u.nickname,u.user_head,u.user_gender,u.live_city,u.msg_num,u.followme_num,u.follow_num FROM et_friend AS f LEFT JOIN et_users AS u ON f.fid_fasong = u.user_id WHERE f.fid_jieshou ='$user[user_id]' ORDER BY f.fri_id DESC LIMIT $start,20");
    while ($data=$db->fetch_array($query)){
        $ushead=$data['user_head']?"$webaddr/attachments/head/".$data['user_head']:"$webaddr/images/noavatar.jpg";
        $myfrilist[]=$data['user_id'];
        $myfri[] = array("usid"=>$data['user_id'],"usname"=>$data['user_name'],"usnickname"=>$data['nickname'],"ushead"=>$ushead,
            "usgender"=>$data['user_gender'],"uslivecity"=>$data['live_city'],"usfolme"=>$data['followme_num'],"usfol"=>$data['follow_num'],"usmsgnum"=>$data['msg_num']);
    }
    if (count($myfrilist)>0) {
        $myfriids=implode(",",$myfrilist);
        $query= $db->query("SELECT fid_jieshou,fid_fasong FROM et_friend WHERE fid_jieshou in ($myfriids) && fid_fasong='$my[user_id]'");
        while($data = $db->fetch_array($query)) {
            $ismyfri[$data['fid_jieshou']]=1;
        }
    }
    $total=$user['followme_num'];
    $pg_num=ceil($total/20);
}

//模板和Foot
$web_name3=$user_name."关注的";
$sqlnum=$db->querynum;
$mtime = explode(' ', microtime());
$loadtime=$mtime[1] + $mtime[0] - $starttime;
include($template->getfile('op_follows.htm'));
?>
