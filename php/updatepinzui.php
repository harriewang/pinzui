<?PHP
header('Content-Type: text/html; charset=utf-8');
define('ET_ROOT', dirname(__FILE__));
define('IN_ET', TRUE);
error_reporting(7);

include(ET_ROOT."/include/db_mysql.class.php");
include(ET_ROOT.'/config.inc.php');

$db = new dbstuff;
$db->connect($server,$db_username,$db_password,$db_name, $pconnect,true);
@mysql_query("set names utf8");

//更新用户关系
if($_GET['id']==1){
	$db->query("TRUNCATE TABLE  `et_friend`");
	$queryfriend = $db->query("select * from subscription");
	while($data = $db->fetch_array($queryfriend)) {
		$sql = "INSERT INTO et_friend (fid_jieshou,fid_fasong) VALUES ('" . addslashes($data['subscribed'])."','".$data['subscriber']."')";
		$query = $db->query($sql);
	    $regid=mysql_insert_id();
	}
}

//更新用户信息
if($_GET['id']==2){
	$db->query("TRUNCATE TABLE  `et_users`");
	$queryuser = $db->query("SELECT * 
	FROM  `profile` 
	LEFT JOIN user ON user.id = profile.id
	LIMIT 0 , 10000000");
	while($data = $db->fetch_array($queryuser)) {
		$sqlhead = 'SELECT * FROM  `avatar` WHERE  `profile_id` ='.$data['id'].' AND  `width` =96 ';
		$queryhead = $db->query($sqlhead);
	    if ($row = $db->fetch_array($queryhead)){
	    	$data['user_head'] = $row['filename'];
	    }else{
	    	$data['user_head'] = '0';
	    }
	    $data['fullname']=($data['fullname']!='')?($data['fullname']):($data['nickname']);
		$sql = "INSERT INTO et_users (user_id,user_name,nickname,password2,mailadres,signupdate,user_head,user_info,qq) VALUES ('".$data['id']."','" . addslashes($data['nickname'])."','".addslashes($data['fullname'])."','".$data['password']."','".$data['email']."','".strtotime($data['created'])."','".$data['user_head']."','".addslashes($data['bio'])."','".$data['qq']."')";
		$query = $db->query($sql);
	    $regid=mysql_insert_id();
	}
}
//更新微博信息
if($_GET['id']==3){
	$db->query("TRUNCATE TABLE  `et_content`");
	$querynotice = $db->query("SELECT notice. * , nickname, fullname
	FROM  `notice` 
	LEFT JOIN profile ON profile.id = notice.profile_id
	ORDER BY notice.id ASC ");
	while($data = $db->fetch_array($querynotice)) {
		$sqlhead = 'SELECT * FROM  `avatar` WHERE  `profile_id` ='.$data['profile_id'].' AND  `width` =96 ';
		$queryhead = $db->query($sqlhead);
	    if ($row = $db->fetch_array($queryhead)){
	    	$data['user_head'] = 'http://pinzui.com/attachments/head/'.$row['filename'];
	    }else{
	    	$data['user_head'] = 'http://pinzui.com/images/noavatar.jpg';
	    }
	    
	    if ($data['reply_to'] !=0){
	    	$queryhead = $db->query('select profile.nickname,profile.fullname from notice left join profile on notice.profile_id=profile.id where notice.id='.$data['reply_to']);
	    	$row = $db->fetch_array($queryhead);
	    	$data['status_uname'] = $row['nickname'];
	    	$data['status_unickname'] =($row['fullname']!='')?$row['fullname']:$row['nickname'];
	    }else{
	    	$data['status_uname'] = 0;
	    	$data['status_unickname'] = 0;
	    }
	    $data['fullname'] = ($data['fullname']!='')?$data['fullname']:$data['nickname'];
		$sql = "INSERT INTO et_content (content_id,user_id,user_name,user_nickname,content_body,posttime,status_id,user_head,status_uname,status_unickname) VALUES ('".$data['id']."','".$data['profile_id']."','".addslashes($data['nickname'])."','".addslashes($data['fullname'])."','".addslashes($data['content'])."','".strtotime($data['created'])."','".$data['reply_to']."','".$data['user_head']."','".$data['status_uname']."','".$data['status_unickname']."')";
		$query = $db->query($sql);
	    $regid=mysql_insert_id();
	}
}

if($_GET['id']==4){
	$db->query("TRUNCATE TABLE  `et_favorite`");
	$queryfriend = $db->query("SELECT *
FROM `fave`");
	while($data = $db->fetch_array($queryfriend)) {
		$sql = "INSERT INTO et_favorite (content_id,sc_uid) VALUES ('" . addslashes($data['notice_id'])."','".$data['user_id']."')";
		$query = $db->query($sql);
	    $regid=mysql_insert_id();
	}
}

if($_GET['id']==5){
	$queryuser = $db->query("SELECT * 
	FROM  `et_users` ");
	while($data = $db->fetch_array($queryuser)) {
		$sqlhead = 'SELECT count(*) as cnt FROM  `et_friend` WHERE  `fid_jieshou` ='.$data['user_id'].' ';
		$queryhead = $db->query($sqlhead);
	    $data['followme_num'] = ($row = $db->fetch_array($queryhead))?$row['cnt']:0;
	    $sqlhead = 'SELECT count(*) as cnt FROM  `et_friend` WHERE  `fid_fasong` ='.$data['user_id'].' ';
		$queryhead = $db->query($sqlhead);
	    $data['follow_num'] = ($row = $db->fetch_array($queryhead))?$row['cnt']:0;
	    $sqlhead = 'SELECT count(*) as cnt FROM  `et_content` WHERE  `user_id` ='.$data['user_id'].' ';
		$queryhead = $db->query($sqlhead);
	    $data['msg_num'] = ($row = $db->fetch_array($queryhead))?$row['cnt']:0;
	    $sqlhead = 'SELECT count(*) as cnt FROM  `et_favorite` WHERE  `sc_uid` ='.$data['user_id'].' ';
		$queryhead = $db->query($sqlhead);
	    $data['fav_num'] = ($row = $db->fetch_array($queryhead))?$row['cnt']:0;
	    
		$sql = "update et_users set msg_num = '".$data['msg_num']."',follow_num = '" . ($data['follow_num'])."',followme_num='".$data['followme_num']."',fav_num='".$data['fav_num']."' where user_id=".$data['user_id']."";
		$query = $db->query($sql);
	    $regid=mysql_insert_id();
	}
}

if($_GET['id']==6){
	$db->query("TRUNCATE TABLE  `et_replyto`");
	$queryuser = $db->query("SELECT a.content_id AS oid, b.content_id, b.user_id
FROM `et_content` a
LEFT JOIN et_content b ON a.status_id = b.content_id
WHERE a.status_id != ''");
	while($data = $db->fetch_array($queryuser)) {
    	$sql = "INSERT INTO et_replyto (content_id,user_id) VALUES ('" . ($data['oid'])."','".$data['user_id']."')";
    	$query = $db->query($sql);
    	$regid=mysql_insert_id();
	}
}
//var_dump($arruser);

//$query1=$db->query("ALTER TABLE `et_settings` CHANGE `replace_word` `replace_word` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
//$query2=$db->query("ALTER TABLE `et_content` CHANGE `content_body` `content_body` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");

//$query3 = $db->query("Describe `et_content` `replyshow`");
//$fetch1 = $db->fetch_array($query3);
//if (!$fetch1['Field']) {
//    $query4=$db->query("ALTER TABLE `et_content` ADD COLUMN `replyshow` tinyint(1) NOT NULL DEFAULT '1';");
//}
//echo $query1*$query2*$query3?"升级完成，请删除此文件":"升级出现问题，请重新运行";
?>