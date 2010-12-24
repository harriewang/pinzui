<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

//cookie处理
function dsetcookie($var, $value, $life = 0, $prefix = 1) {
	global $cookiedomain, $cookiepath, $addtime, $_SERVER;
	setcookie($var, $value,$life ? $addtime + $life : 0, $cookiepath,$cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    global $webaddr;
    $auth_key=md5($webaddr);
	$ckey_length = 4;
	$key = md5($key ? $key : $auth_key);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function daddslashes($string) {
    $string=str_replace("'",'"',$string);
    !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
    if(!MAGIC_QUOTES_GPC) {
        if(is_array($string)) {
            foreach($string as $key => $val) {
                $string[$key] = daddslashes($val);
            }
        } else {
            $string = addslashes($string);
        }
    }
	return $string;
}

function randStr($len=6) {
    $chars='ABDEFGHJKLMNPQRSTVWXYabdefghijkmnpqrstvwxy23456789';
    mt_srand((double)microtime()*1000000*getmypid());
    $password='';
    while(strlen($password)<$len)
    $password.=substr($chars,(mt_rand()%strlen($chars)),1);
    return $password;
}

//返回时间
function timeop($time,$type="talk") {
    $ntime=time()-$time;
    if ($ntime<60) {
        return("刚才");
    } elseif ($ntime<3600) {
        return(intval($ntime/60)."分钟前");
    } elseif ($ntime<3600*24) {
        return(intval($ntime/3600)."小时前");
    } else {
        if ($type=="talk") {
            return(gmdate('m月d日 H:i',$time+8*3600));
        } else {
            return(gmdate('Y-m-d H:i',$time+8*3600));
        }

    }
}

function invitecodeauth($code) {
    global $db;
    $query = $db->query("SELECT * FROM et_invitecode WHERE invitecode='$code'");
    $data=$db->fetch_array($query);
    if (!$data['id']) {
        $msg="邀请码无效！";
    } else if($data['isused']==1) {
        $msg="邀请码已被使用！";
    } else if($data['timeline']<time()) {
        $msg="邀请码已经过期！";
    } else {
        $msg="ok";
    }
    return $msg;
}

//数组用逗号隔开
function implodeids($array) {
	if(!empty($array)) {
		return "'".implode("','", is_array($array) ? $array : array($array))."'";
	} else {
		return '';
	}
}

function StrLenW($str){
    $len=strlen($str);
    $i=0;
    while($i<$len){
        if(preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$str[$i])){
            $i+=2;
        }else{
            $i+=1;
        }
    }
    return $i;
}

//utf-8截取
function getsubstrutf8($string, $start = 0,$sublen,$append=true) {
    $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
    preg_match_all($pa, $string, $t_string);

    if(count($t_string[0]) - $start > $sublen && $append==true) {
        return join('', array_slice($t_string[0], $start, $sublen))."...";
    } else {

        return join('', array_slice($t_string[0], $start, $sublen));
    }
}

//gbk截取
function getsubstrgbk($string,$start='0',$length='') {
    $start = (int)$start;
    $length = (int)$length;
    $i = 0;
    if(!$string) {
        return;
    }
    if($start>=0) {
        while($i<$start) {
            if(ord($string[$i])>127) {
                $i = $i+2;
            } else {
                $i++;
            }
        }
        $start = $i;
        if($length=='') {
            return substr($string,$start);
        }
        elseif($length>0) {
            $end = $start+$length;
            while($i<$end) {
                if(ord($string[$i])>127) {
                    $i = $i+2;
                } else {
                    $i++;
                }
            } if($end != $i-1) {
                $end = $i;
            } else {
                $end--;
            }
            $length = $end-$start;
            return substr($string,$start,$length);
        } elseif($length==0) {
            return;
        } else {
            $length = strlen($string)-abs($length)-$start;
            return getsubstrgbk($string,$start,$length);
        }
    } else {
        $start = strlen($string)-abs($start);
        return getsubstrgbk($string,$start,$length);
    }
}

//UBB代码替换
function ubb ($text) {
    global $webaddr;
    $weburl=urlop($webaddr,'e');
    $p= array(
        '/\[img\](.*?)\[\/img\]/ie',
        '/\[img link=(.*?)\](.*?)\[\/img\]/ie',
        '/\[video host=(.*?) pic=(.*?)\](.*?)\[\/video\]/ie',
        '/\[music\](.*?)\[\/music\]/ie',
        '/\[flash\](.*?)\[\/flash\]/ie',
        '/\[desc\](.*?)\[\/desc\]/i',
        '/\[url\](.*?)\[\/url\]/i',
        '/\[url=(.*?)\](.*?)\[\/url\]/i'
        );
    $rand=randStr(6);
    $r=array(
        'urlop("<a href=\"$1\" target=\"_blank\"><img src=\"$1\" alt=\"分享照片\" height=\"50px\" border=\"0\" class=\"h_postimg\"></a>","d")',
        'urlop("<p><a href=\"$1\" onclick=\"return hs.expand(this)\" target=\"_blank\"><img src=\"$2\" alt=\"分享照片\" class=\"h_postimg\"></a></p>","d")',
        'urlop("<div class=\"media\"><img id=\"img_'.$rand.'\" style=\"background:url($2) no-repeat;width:38px;height:28px;padding:30px 45px 30px 45px;cursor:pointer;\" src=\"'.$weburl.'/images/default/shareico.png\" alt=\"点击播放\" onclick=\"javascript:showFlash(\'$1\',\'$3\',this,\''.$rand.'\');\"/></div>","d")',
        'urlop("<div class=\"media\"><img id=\"img_'.$rand.'\" src=\"'.$weburl.'/images/music.gif\" alt=\"点击播放\" onclick=\"javascript:showFlash(\'music\',\'$1\',this,\''.$rand.'\');\" style=\"cursor:pointer;\"/></div>","d")',
        'urlop("<div class=\"media\"><img id=\"img_'.$rand.'\" src=\"'.$weburl.'/images/flash.gif\" alt=\"点击播放\" onclick=\"javascript:showFlash(\'flash\',\'$1\',this,\''.$rand.'\');\" style=\"cursor:pointer;\"/></div>","d")',
        "<div class=\"quote\"><span id=\"quote\" class=\"q\">$1</span></div>",
        "<a class='ubblink' href=\"$1\" target=\"_blank\">$1</a>",
        "<a href=\"$1\">$2</a>"
        );
    $text=preg_replace($p,$r,$text);
    $text=emotionrp($text);  //表情
    $text = preg_replace("/(.*?)#([^#].*?)#(.*?)/i", "$1<a href='{$webaddr}/keywords/$2'>#$2#</a>$3",$text); //专题
    return $text;
}

function getVideoHtml($url,$site) {
    $lines_array = file($url);
    $lines_string = implode('', $lines_array);
    if('youku.com' == $site) {
        preg_match("/<title>(.*?) - (.*)<\/title>/",  $lines_string, $head);
        preg_match_all("/<li class=\"download\"(.*)<\/li>/",$lines_string,$picmatch);
        preg_match("/\|http:\/\/g(\d+).ykimg.com\/(.*)\|/",$picmatch[1][0],$imageurl);
        $vpic=str_replace("|","",$imageurl[0]);
        $title=$head[1];
    } else if ('ku6.com' == $site) {
        preg_match("/<title>(.*?) - (.*)<\/title>/", $lines_string, $head);
        preg_match_all("/<span class=\"s_pic\">(.*)<\/span>/",$lines_string,$picmatch);
        $vpic=$picmatch[1][0];
        $title=clean_html(iconv("gbk", "utf-8",$head[1]));
    } elseif('tudou.com' == $site) {
        preg_match("/<title>(.*?)<\/title>/", $lines_string, $head);
        preg_match_all("/<span class=\"s_pic\">(.*)<\/span><span class=\"s_time\">/",$lines_string,$picmatch);
        $vpic=$picmatch[1][0];
        $title=clean_html(iconv("gbk", "utf-8",$head[1]));
        if (!$vpic) {//黑豆
            preg_match_all("/<li class=\"first current\">(.*?)<\/li>/isu",$lines_string,$picmatch);
            preg_match_all("/<div class=\"clip_wrap\"><a(.*) target=\"_self\"><img(.*)\/><\/a><\/div>/",$picmatch[1][0],$picmatch);
            $vpic=str_replace(array('"','src='),"",$picmatch[2][0]);
            $title=$head[1];
        }
    }
    if ($title=="无法找到该页") {
        $title='';
    }
    return array($title,$vpic);
}

function getFlash($link, $host) {
	$return = '';
	if('youku.com' == $host) {// http://v.youku.com/v_show/id_XNDg1MjA0ODg.html
        preg_match_all("/id\_(\w+)[\=|.html]/", $link, $matches);
		if(!empty($matches[1][0])) {
			$return = $matches[1][0];
		}
	} elseif('ku6.com' == $host) {// http://v.ku6.com/show/bjbJKPEex097wVtC.html
		preg_match_all("/\/([\w\-]+)\.html/", $link, $matches);
		if(1 > preg_match("/\/index_([\w\-]+)\.html/", $link) && !empty($matches[1][0])) {
			$return = $matches[1][0];
		}
	} elseif('tudou.com' == $host) {// http://www.tudou.com/programs/view/E4tG8kdHCtI
		preg_match_all("/\/(\w+)\/*$/", $link, $matches);
		if(!empty($matches[1][0])) {
			$return = $matches[1][0];
		}
	}
	return $return;
}

//读取回复的信息
function getReply($contentid) {
    global $db;
    $query = $db->query("SELECT user_name,user_nickname,content_body,replytimes FROM et_content WHERE content_id='$contentid'");
    $data = $db->fetch_array($query);
    return $data;
}

//用户没有登录 跳转首页
function toindex() {
    global $my,$webaddr;
    if (!$my[user_id]) {
        header("Location: $webaddr/index");
        exit;
    }
}

//用户没有登录 跳转首页
function tologin() {
    global $my,$webaddr;
    if (!$my[user_id]) {
        dsetcookie('urlrefer', 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        echo '<script language="javascript">top.location="'.$webaddr.'/op/login";</script>';
        exit;
    }
}

//关注数目更新
function frinum($uid) {
    global $db;
    $follownum=getcount("et_friend",array("fid_fasong"=>$uid));
    $followmenum=getcount("et_friend",array("fid_jieshou"=>$uid));

    $db->query("UPDATE et_users SET follow_num='$follownum',followme_num='$followmenum' WHERE user_id='$uid'");
}

//发邮件
function sendmail($to,$title,$send) {
    global $smtp,$smtpserver,$smtpserverport,$smtpuser,$smtppass,$smtpusermail;
    $smtp = new smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass);
    $smtp->debug = true;
    $smtp->sendmail($to,$smtpusermail,$title, $send, "text");
}

function jsalert($msg,$url) {
    return "<meta http-equiv='Content-Type'' content='text/html; charset=utf-8'><script language='javascript' charset='utf-8' type='text/javascript'>alert(\"{$msg}\");location.href='{$url}';</script>";
}

//信息转换
function idtoname($uid) {
    global $db;
    $query = $db->query("SELECT user_name FROM et_users WHERE user_id='$uid'");
    $row= $db->fetch_array($query);
    return $row['user_name'];
}
function nametoid($uname) {
    global $db;
    $query = $db->query("SELECT user_id FROM et_users WHERE user_name='".strtolower($uname)."'");
    $row= $db->fetch_array($query);
    return $row['user_id'];
}
function mailtoid($mail) {
    global $db;
    $query = $db->query("SELECT user_id FROM et_users WHERE mailadres='$mail'");
    $row= $db->fetch_array($query);
    return $row['user_id'];
}
function idtohead($uid) {
    global $db,$webaddr;
    $query = $db->query("SELECT user_head FROM et_users WHERE user_id='$uid'");
    $row= $db->fetch_array($query);
    $user_head =$row['user_head'];
    $user_head=$user_head?"$webaddr/attachments/head/".$user_head:"$webaddr/images/noavatar.jpg";
    return $user_head;
}

function isfriend($fid1,$fid2) {
    global $db;
    $query = $db->query("SELECT fid_jieshou,fid_fasong FROM et_friend WHERE fid_jieshou='$fid1' && fid_fasong='$fid2'");
    if ($data = $db->fetch_array($query)) {
        return 1;
    } else {
        return 0;
    }
}

function user_info($a1) {
    global $db;
    $query = $db->query("SELECT * FROM et_users WHERE $a1");
    $row= $db->fetch_array($query);
    return $row;
}

//home页面user资料返回
function homeuser($username) {
    global $db,$webaddr,$my;
    $query = $db->query("SELECT * FROM et_users WHERE user_name='$username'");
    $user= $db->fetch_array($query);
    $tem1=explode(" ",$user['home_city']);
    $tem2=explode(" ",$user['live_city']);
    $user['user_head']=$user['user_head']?"$webaddr/attachments/head/".$user['user_head']:"$webaddr/images/noavatar.jpg";
    $user['old']=date(Y)-getsubstrutf8($user['birthday'],0,4);
    if($user['home_city']=="选择省份 选择城市" || $user['home_city']=="" || $user['home_city']==" ") $user['home_city']="";
    else $user['home_city']="<a href='$webaddr/op.php?op=finder&sname=&act=search&homesf=".$tem1[0]."&homecity=".$tem1[1]."'>".$user['home_city']."</a>";
    if($user['live_city']=="选择省份 选择城市" || $user['live_city']=="" || $user['live_city']==" ") $user['live_city']="";
    else $user['live_city']="<a href='$webaddr/op.php?op=finder&sname=&act=search&livesf=".$tem2[0]."&livecity=".$tem2[1]."'>".$user['live_city']."</a>";
    $tem3=explode(" ",$user['gtalk']);
    $user['gtalk']=$tem3[0]?$tem3[0]:"";
    $user['gtalkauthcode']=$tem3[1];
    if ($user['userlock']==1){
        header("location: $webaddr/op/web/closeuser");
        exit;
    }
    if (!$user['user_name']){
        header("location: $webaddr/op/web/none");
        exit;
    }
    if ($user['user_id']!=$my['user_id'] && $user['isclose']=="是") {
        header("location: $webaddr/op/web/userlock");
        exit;
    }
    return $user;
}

//用户登录跳转空间
function tohome() {
    global $my,$webaddr;
    if ($my[user_id]) {
        header("Location: $webaddr/{$my[user_name]}/profile");
    }
}

//获取数目
function getcount($tablename, $wherearr, $get='COUNT(*)') {
	global $db;
	if(empty($wherearr)) {
		$wheresql = '1';
	} else {
		$wheresql = $mod = '';
		foreach ($wherearr as $key => $value) {
			$wheresql .= $mod."`$key`='$value'";
			$mod = ' AND ';
		}
	}
	return $db->result($db->query("SELECT $get FROM $tablename WHERE $wheresql LIMIT 1"), 0);
}

//词语过滤
function replace($content){
    global $replace;
    if ($content) {
        $content=clean_html($content);
        if($content=="") {
            $content="HTML代码已过滤";
        }
        $bad = explode("|",$replace);
        @reset($bad);
        for ($i=0;$i<count($bad);$i++) {
            $content= str_replace($bad[$i],"**",$content);
        }
        $suffix=mediasuffix($content);
        if (in_array($suffix,array("jpg","jpeg","gif","bmp","png"))) {
            $content=preg_replace('`((?:https?|ftp?|http):\/\/([a-zA-Z0-9-.?=&_\/:]*)/?)`sie','urlop("[img link=$1]$1[/img]","e")',$content);
        } else {
            $content=preg_replace('`((?:https?|ftp?|http):\/\/([a-zA-Z0-9-.?=&_\/"]*)/?)`si','[url]$1[/url]',$content);
        }
    }
    return $content;
}

//链接处理
function urlop($url,$op) {
    if ($op=='e') {
        return str_replace(array("http:","https:","ftp:"),array("http","https","ftp"),$url);
    } else if ($op=='d') {
        $nurl=str_replace(array("http","https","ftp"),array("http:","https:","ftp:"),$url);
        $nurl=str_replace(array("http::","https::","ftp::"),array("http:","https:","ftp:"),$nurl);
        return $nurl;
    }
}

function mediasuffix($content) {
    preg_match_all('`((?:https?|ftp?|http):\/\/([a-zA-Z0-9-.?=&_\/:]*)/?)`si',$content,$suffixtem);
    $suffix=getsubstrutf8($suffixtem[0][0],-3,3,false);
    return strtolower($suffix);
}

//表情过滤
function emotionrp($content) {
    global $webaddr;
    $p= array("(疑问)","(惊喜)","(鄙视)","(呕吐)","(拜拜)","(大笑)","(求)","(色)","(撇嘴)","(调皮)","(流泪)","(偷笑)","(鲜花)","(流汗)","(困)","(惊恐)","(闪人)","(惊讶)","(心)","(发怒)","(发愁)","(投降)","(便便)","(害羞)","(大哭)","(得意)","(跪服)","(难过)","(生气)","(闭嘴)","(抓狂)","(人品)","(钱)","(酷)","(挨打)","(痛打)","(阴险)","(疑问)","(尴尬)","(发呆)","(睡)","(嘘)","(鼻血)","(可爱)","(亲吻)","(寒)","(谢谢)","(顶)","(胜利)");
    $r=array("<img class='emo' src='{$webaddr}/attachments/emotion/1.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/2.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/3.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/4.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/5.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/6.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/7.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/8.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/9.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/10.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/11.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/12.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/13.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/14.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/15.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/16.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/17.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/18.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/19.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/20.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/21.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/22.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/23.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/24.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/25.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/26.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/27.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/28.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/29.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/30.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/31.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/32.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/33.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/34.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/35.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/36.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/37.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/38.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/39.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/40.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/41.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/42.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/43.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/44.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/45.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/46.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/47.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/48.gif'>&nbsp;","<img class='emo' src='{$webaddr}/attachments/emotion/49.gif'>&nbsp;");
    return str_replace($p, $r, $content);
}

//过滤html
function clean_html($html) {
    $html = str_replace(array("<br />","<br/>","<br>","\n"), "", $html);
    $html = eregi_replace('<("|\')?([^ "\']*)("|\')?.*>([^<]*)<([^<]*)>', '\4', $html);
    $html = preg_replace('#</?.*?\>(.*?)</?.*?\>#i','',$html);
    $html = preg_replace('#(.*?)\[(.*?)\](.*?)javascript(.*?);(.*?)\[/(.*?)\](.*?)#','', $html);
    $html = preg_replace('#javascript(.*?)\;#','', $html);
    $html = htmlspecialchars($html);
    return($html);
}

//链接过滤
function clean_http($html) {
    $html = preg_replace('`((?:https?|ftp?|http):\/\/([a-zA-Z0-9-.?=&_\/:]*)/?)`si','',$html);
    return($html);
}

//过滤链接ubb等
function ubbreplace($content) {
    $cbody=preg_replace("/\[(url|url=.*|img.*|video host=.*|music|flash|desc)\](\S+?)\[\/.*\]/i","$2",$content);
    return $cbody;
}

function simplecontent($content,$len=50) {
    $sc=clean_html(trim($content));
    $sc=ubbreplace($sc);
    $sc=clean_http($sc);
    if ($len!=0) {
        $sc=getsubstrutf8($sc,0,$len,true);
    }
    $sc=$sc?$sc:"还没有说什么！";
    return $sc;
}

//@用户
function atsend($content) {
    global $webaddr,$db;
    $uidarray=array();
    $tem=explode("@",$content);
    if (count($tem)>1) {
        for($i=1;$i<count($tem);$i++) {
            $tem1=explode(" ",$tem[$i]);
            $user=user_info("nickname='$tem1[0]'");
            if ($user) {
                $_content.="@[url=$webaddr/$user[user_name]]$user[nickname][/url] ".$tem1[1];
                array_push($uidarray,$user['user_id']);
            } else {
                $_content.="@".$tem[$i];
            }
        }
    }
    $_content=$tem[0].$_content;
    return array("uids"=>array_unique($uidarray),"content"=>$_content);
}

//收藏数更新
function updatefavnum($update) { //all ++ --
    global $my,$db;
    if ($update=='all') {
        $total=$db->result($db->query("SELECT count(*) FROM et_favorite AS f LEFT JOIN et_content AS c ON c.content_id=f.content_id && c.replyshow=1 WHERE f.sc_uid='$my[user_id]' && c.content_id != '' LIMIT 1"), 0);
        $db->query("UPDATE et_users SET fav_num='$total' WHERE  user_id='$my[user_id]'");
    } else if ($update=='++') {
        $db->query("UPDATE et_users SET fav_num=fav_num+1 WHERE  user_id='$my[user_id]'");
    } else if ($update=='--') {
        $db->query("UPDATE et_users SET fav_num=fav_num-1 WHERE  user_id='$my[user_id]'");
    }
}

//消息更新
function updatemsgnum($update,$uid) { //all ++ --
    global $db;
    if ($update=='all') {
        $total=getcount('et_content',array('user_id'=>$uid,'privacy'=>0));
        $db->query("UPDATE et_users SET msg_num='$total' WHERE user_id='$uid'");
    } else if ($update=='++') {
        $db->query("UPDATE et_users SET msg_num=msg_num+1 WHERE user_id='$uid'");
    } else if ($update=='--') {
        $db->query("UPDATE et_users SET msg_num=msg_num-1 WHERE user_id='$uid'");
    }
}

//获得扩展名
function getfiletype($Filename) {
    if (substr_count($Filename, ".") == 0) {
        return;
    } else if (substr($Filename, -1) == ".") {
        return;
    } else {
        $FileType = strrchr ($Filename, ".");
        $FileType = substr($FileType, 1);
        return $FileType;
    }
}

//更新回复数
function updatereplynum($delid) {  //index.php
    global $db;
    $query = $db->query("SELECT user_id,status_id FROM et_content WHERE content_id='$delid'");
    $data = $db->fetch_array($query);
    if ($data) {
        if ($data['status_id']>0) {
            $db->query("UPDATE et_content SET replytimes=replytimes-1 WHERE content_id='".$data['status_id']."'");
        }
        updatemsgnum('all',$data['user_id']);
    }
}

//话题
function explodetopic($content) {
    global $db;
    $topic = preg_replace("/(.*?)#([^#].*?)#(.*?)/i", "$2|",$content);
    $tem=explode("|",$topic);
    $length=count($tem);
    if ($length>1) {
        for($i=0;$i<$length-1;$i++) {
            if ($tem[$i]) {
                if (StrLenW($topic)>20) {
                    $tem[$i]=getsubstrutf8($tem[$i],0,20,false);
                }
                if (getcount('et_topic',array('topicname'=>$tem[$i]))==0) {
                    $db->query("INSERT INTO et_topic (topicname,topictimes) VALUES ('$tem[$i]','1')");
                } else {
                    $db->query("UPDATE et_topic SET topictimes=topictimes+1 WHERE topicname='$tem[$i]'");
                }
            }
        }
    }
}

function sizecount($filesize) {
	if($filesize >= 1073741824) {
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
	} elseif($filesize >= 1048576) {
		$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
	} elseif($filesize >= 1024) {
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	} else {
		$filesize = $filesize . ' Bytes';
	}
	return $filesize;
}

//截取链接
function sub_url($url, $length) {
	if(strlen($url) > $length) {
		$url = str_replace(array('%3A', '%2F'), array(':', '/'), rawurlencode($url));
		$url = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, - intval($length * 0.3));
	}
	return $url;
}

//load index
function loadindex($content) {
    if (count($content)!=0) {
        foreach ($content as $key=>$val) {
            echo loadoneli($val[content_id],$val[user_name],$val[user_id],$val[user_nickname],$val[user_head],$val[content_body],$val[posttime],$val[type],$val[zftimes],$val[replytimes],0,$val[status_id],$val[status_uname],$val[status_unickname]);
        }
    }
}

//加载回复li模块
function loadonelireply($content_id,$content) {
    global $webaddr,$my;
    $r.='<li class="lire">
    <div class="images">
        <a href="'.$webaddr.'/'.$my[user_name].'"><img src="'.$my[user_head].'" width="30px"></a>
    </div>
    <div class="info">
        <p><a class="username" href="'.$webaddr.'/'.$my[user_name].'">'.$my[nickname].'</a><span class="setgray">刚才&nbsp;<a href="javascript:void(0)" style="float:right" onclick="delmsg(\''.$webaddr.'/index.php?act=del&cid='.$content_id.'\',\'确实要删除此条TALK吗?\',this.parentNode.parentNode.parentNode.parentNode)">删除</a></span></p>
        <p>'.$content.'</p>
    </div></li>';
    return $r;
}

//加载li模块
function loadoneli($content_id,$user_name,$user_id,$user_nickname,$user_head,$content_body,$posttime,$type,$zftimes,$replytimes,$privacy,$status_id,$status_uname,$status_unickname,$wide=0,$showfavbtn=1) {
    global $webaddr,$my;
    $r.='<li class="unlight">';
    if ($wide==0) {
        $contentClass='content';
        $r.='<a href="'.$webaddr.'/'.$user_name.'" title="'.$user_nickname.'" class="avatar"><img src="'.$user_head.'" alt="'.$user_nickname.'" /></a>';
    } else {
        $contentClass='contentl';
    }
    $r.='<div class="'.$contentClass.'"><a href="'.$webaddr.'/'.$user_name.'" class="author">'.$user_nickname.'</a>';
    if ($status_id && $status_uname) {
        $r.='@<a href="'.$webaddr.'/'.$status_uname.'">'.$status_unickname.'</a>&nbsp;';
    }
    $r.=$content_body.'</div>';
    $r.='<span class="stamp" style="float:left">';
    $r.='<a href="'.$webaddr.'/op/view/'.$content_id.'">'.$posttime.'</a>&nbsp;通过'.$type.'&nbsp;';
    if ($status_id && $status_uname){
        $r.='<a href="javascript:void(0)" onclick="getReplyContent(\''.$status_id.'\',\''.$content_id.'\')">对'.$status_unickname.'的回复</a>&nbsp;';
    }
    $r.='</span>';
    $r.='<span class="method stamp" style="float:right">';
    if ($privacy==0) {
        if (!$status_id){
            $r.='<a href="javascript:void(0)" onclick="zhuanfa(\''.$content_id.'\')">转发('.$zftimes.')</a> | ';
        }
        $r.='<a href="javascript:void(0)" onclick="replyajax(\''.$content_id.'\')">回复('.$replytimes.')</a>';
        if ($showfavbtn==1) {
            $r.=' | <a class="fav" href="javascript:void(0)" onclick="send_f(\''.$content_id.'\')" title="添加到我的收藏">收藏</a>';
        }
    }
    $r.='</span>';
    if ($my[user_id]){
    $r.='<span class="op">';
        if ($my[user_id]==$user_id || $my[isadmin]>0) {
            $r.='<a class="delete" href="javascript:void(0)" onclick="delmsg(\''.$webaddr.'/index.php?act=del&cid='.$content_id.'\',\'确实要删除此条TALK吗?\',this.parentNode.parentNode)">删除</a>';
        }
    $r.='</span>';
    }
    $r.='<div class="clearline"></div>';
    $r.='<span id="reply_'.$content_id.'" class="replyspan"></span>';
    if ($status_id) {
        $r.='<span id="replyC_'.$content_id.'" class="replyspan"></span>';
    }
    $r.='</li>';
    return $r;
}
?>
