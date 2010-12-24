<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

//1小时更新一次缓存  丢入cron计划任务中
if (time()-@filemtime(ET_ROOT."/include/cache/users.cache.php")>3600) {
    @unlink(ET_ROOT."/include/cache/users.cache.php");
    @unlink(ET_ROOT."/include/cache/hottopics.cache.php");
    @unlink(ET_ROOT."/include/cache/hotmsg.cache.php");
}

@include(ET_ROOT."/include/cache/setting.cache.php");
@include(ET_ROOT."/include/cache/users.cache.php");
@include(ET_ROOT."/include/cache/hottopics.cache.php");
@include(ET_ROOT."/include/cache/ads.cache.php");
@include(ET_ROOT."/include/cache/announce.cache.php");
@include(ET_ROOT."/include/cache/hotmsg.cache.php");

//设置 缓存
if (!file_exists(ET_ROOT."/include/cache/setting.cache.php")) {
	$query = "SELECT * FROM et_settings";
	$result = $db->query($query);
	$data = $db->fetch_array($result);

	$fp=fopen(ET_ROOT."/include/cache/setting.cache.php","a");
	fputs($fp,"<?php\n");
    fputs($fp,"if(!defined('IN_ET')) {\n");
    fputs($fp,"   exit('Access Denied');\n");
    fputs($fp,"}\n\n");
    fputs($fp,"//设置信息缓存\n");
	fputs($fp,"\$webn1='$data[web_name]';\n");
	fputs($fp,"\$webn2='$data[web_name2]';\n");
	fputs($fp,"\$webm='$data[web_miibeian]';\n");
	fputs($fp,"\$seokey='$data[seokey]';\n");
	fputs($fp,"\$description='$data[description]';\n");
    fputs($fp,"\$replace='$data[replace_word]';\n");
    fputs($fp,"\$mail_server='$data[mail_server]';\n");
    fputs($fp,"\$mail_port='$data[mail_port]';\n");
    fputs($fp,"\$mail_name='$data[mail_name]';\n");
    fputs($fp,"\$mail_user='$data[mail_user]';\n");
    fputs($fp,"\$mail_pass='$data[mail_pass]';\n");
    fputs($fp,"\$webclose='$data[webclose]';\n");
    fputs($fp,"\$closereg='$data[closereg]';\n");
    fputs($fp,"\$openqq='$data[openqq]';\n");
	fputs($fp,"\$bindmobile='$data[bindmobile]';\n");
	fputs($fp,"?>");
    fclose($fp);
    @include(ET_ROOT."/include/cache/setting.cache.php");
}

//热门话题和搜索
if (!file_exists(ET_ROOT."/include/cache/hottopics.cache.php")) {
    $query = $db->query("SELECT * FROM et_topic WHERE topictimes>0 ORDER BY topictimes DESC LIMIT 10");
    while($data = $db->fetch_array($query)) {
        $topic1='<li><a href="'.$webaddr.'/keywords/'.$data['topicname'].'">'.$data['topicname'].'</a>('.$data['topictimes'].')</li>';
        $topic=$topic.$topic1;
    }
    $query = $db->query("SELECT * FROM et_search WHERE searchtimes>0 ORDER BY searchtimes DESC LIMIT 10");
    while($data = $db->fetch_array($query)) {
        $search1='<li><a href="'.$webaddr.'/search?q='.$data['searchcont'].'&act=search">'.$data['searchcont'].'</a></li>';
        $search=$search.$search1;
    }
    $fp=fopen(ET_ROOT."/include/cache/hottopics.cache.php","a");
    fputs($fp,"<?php\n");
    fputs($fp,"if(!defined('IN_ET')) {\n");
    fputs($fp,"   exit('Access Denied');\n");
    fputs($fp,"}\n\n");
    fputs($fp,"//热门话题和搜索\n");
    fputs($fp,"\$topics='$topic';\n");
    fputs($fp,"\$searchs='$search';\n");
    fputs($fp,"?>");
    fclose($fp);
    @include(ET_ROOT."/include/cache/hottopics.cache.php");
}

//十大热评
if (!file_exists(ET_ROOT."/include/cache/hotmsg.cache.php")) {
    $query = $db->query("SELECT content_id,content_body,replytimes FROM et_content WHERE replytimes>0 ORDER BY replytimes DESC LIMIT 10");
    while($data = $db->fetch_array($query)) {
        $hotmsg1='<li><a href="'.$webaddr.'/op/view/'.$data['content_id'].'">'.simplecontent($data['content_body'],15).'</a></li>';
        $hotmsg=$hotmsg.$hotmsg1;
    }
    $fp=fopen(ET_ROOT."/include/cache/hotmsg.cache.php","a");
    fputs($fp,"<?php\n");
    fputs($fp,"if(!defined('IN_ET')) {\n");
    fputs($fp,"   exit('Access Denied');\n");
    fputs($fp,"}\n\n");
    fputs($fp,"//十大热评\n");
    fputs($fp,"\$hotmsg='$hotmsg';\n");
    fputs($fp,"?>");
    fclose($fp);
    @include(ET_ROOT."/include/cache/hotmsg.cache.php");
}

//推荐，新用户缓存
if (!file_exists(ET_ROOT."/include/cache/users.cache.php")) {
    $query_tj = $db->query("SELECT user_id,user_name,nickname,user_head FROM et_users WHERE followme_num>0 && userlock='0' && user_head!='0' && home_city!='' && live_city!='' && user_gender!='' ORDER BY followme_num DESC LIMIT 8");
    while($data = $db->fetch_array($query_tj)) {
        $uhead=$data[user_head]?"$webaddr/attachments/head/".$data[user_head]:"$webaddr/images/noavatar.jpg";
        $tm1='<li><a href="'.$webaddr.'/'.$data[user_name].'"><img id="fu'.$data[user_id].'" class="followpreview" alt="'.$data[nickname].'" src="'.$uhead.'"/><span>'.$data[nickname].'</span></a></li>';
        $tm=$tm.$tm1;
    }
    $query_new = $db->query("SELECT user_id,user_name,nickname,user_head FROM et_users WHERE userlock!=1 ORDER BY user_id DESC LIMIT 8");
    while($data = $db->fetch_array($query_new)) {
        $uhead=$data[user_head]?"$webaddr/attachments/head/".$data[user_head]:"$webaddr/images/noavatar.jpg";
        $ttm1='<li><a href="'.$webaddr.'/'.$data[user_name].'"><img id="fu'.$data[user_id].'" class="followpreview" alt="'.$data[nickname].'" src="'.$uhead.'"/><span>'.$data[nickname].'</span></a></li>';
        $ttm=$ttm.$ttm1;
    }
    $fp=fopen(ET_ROOT."/include/cache/users.cache.php","a");
    fputs($fp,"<?php\n");
    fputs($fp,"if(!defined('IN_ET')) {\n");
    fputs($fp,"   exit('Access Denied');\n");
    fputs($fp,"}\n\n");
    fputs($fp,"//推荐，新用户\n");
    fputs($fp,"\$tuijian='$tm';\n");
    fputs($fp,"\$newcome='$ttm';\n");
    fputs($fp,"?>");
    fclose($fp);
    @include(ET_ROOT."/include/cache/users.cache.php");
}

if (!file_exists(ET_ROOT."/include/cache/announce.cache.php")) {
    $query = $db->query("SELECT announ_body FROM et_announ ORDER BY announ_id DESC");
    while($data = $db->fetch_array($query)) {
        $announ_body=$data['announ_body'];
        $temp1="<li>$announ_body</li>";
        $temp=$temp.$temp1;
    }
    $fp=fopen(ET_ROOT."/include/cache/announce.cache.php","a");
    fputs($fp,"<?php\n");
    fputs($fp,"if(!defined('IN_ET')) {\n");
    fputs($fp,"   exit('Access Denied');\n");
    fputs($fp,"}\n\n");
    fputs($fp,"//公告缓存\n");
    fputs($fp,"\$announce='$temp';\n");
    fputs($fp,"?>");
    fclose($fp);
    @include(ET_ROOT."/include/cache/announce.cache.php");
}

//广告 缓存
if (!file_exists(ET_ROOT."/include/cache/ads.cache.php")) {
    $fp=fopen(ET_ROOT."/include/cache/ads.cache.php","a");
	fputs($fp,"<?php\n");
    fputs($fp,"if(!defined('IN_ET')) {\n");
    fputs($fp,"   exit('Access Denied');\n");
    fputs($fp,"}\n\n");
    fputs($fp,"//广告缓存 \n");

    $i=$j=$k=$l=0;
    $query2 = $db->query("SELECT * FROM et_ads");
    while($data2= $db->fetch_array($query2)) {
        $ad_id=$data2['ad_id'];
        $position=$data2['position'];
        $adbody=$data2['adbody'];
        if ($position==1) {
            $i++;
            fputs($fp,"\$p1[$i]='".base64_encode($adbody)."';\n");
        } else if($position==2) {
            $j++;
            fputs($fp,"\$p2[$j]='".base64_encode($adbody)."';\n");
        } else if($position==3) {
            $k++;
            fputs($fp,"\$p3[$k]='".base64_encode($adbody)."';\n");
        } else if($position==4) {
            $l++;
            fputs($fp,"\$p4[$l]='".base64_encode($adbody)."';\n");
        }
    }
	fputs($fp,"?>");
    fclose($fp);
    @include(ET_ROOT."/include/cache/ads.cache.php");
}
?>