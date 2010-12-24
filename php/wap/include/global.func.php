<?php
function wapheader() {
    global $tsid,$head;
    echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>".
		"<html xmlns='http://www.w3.org/1999/xhtml'>".
		"<head>".
        "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'/>".
	    "<title>$head</title>".
		"<link rel='stylesheet' href='include/style.css' type='text/css'/>".
		"</head>".
		"<body>".
	    "<h1><center><a href='index.php?tsid=$tsid'><img src='include/logo.gif' alt='贫嘴'/></a></center></h1>";
}

function wapfooter() {
    echo //"<div id='ft'>小贫报时：".gmdate('m-d H:i',time()+8*3600)."</div>".
		 //"<div id='ft'>Copyright &copyright 贫嘴 </div>".
		 "</body>".
		 "</html>";
}

function wapreplace($content) {
    $content=clean_html($content);
    $content=wapubb($content);
    return $content;
}

function wapubb($text) {
    $p= array(
        '/\[img\](.*?)\[\/img\]/ie',
        '/\[img link=(.*?)\](.*?)\[\/img\]/ie',
        '/\[video host=(.*?)\](.*?)\[\/video\]/i',
        '/\[music\](.*?)\[\/music\]/i',
        '/\[flash\](.*?)\[\/flash\]/i',
        '/\[desc\](.*?)\[\/desc\]/i',
        '/\[url\](.*?)\[\/url\]/i',
        '/\[url=(.*?)\](.*?)\[\/url\]/i'
        );
    $r=array(
        'wapurlop("<a href=\"$1\" target=\"_blank\">[打开图片]</a>","d")',
        'wapurlop("<a href=\"$2\" target=\"_blank\">[打开图片]</a>","d")',
        '分享的视频',
        '分享的music',
        '分享的flash',
        '$1',
        '$1',
        '$2'
        );
    $text=preg_replace($p, $r, $text);
    $text=emotionrp($text);
    return $text;
}

function wapurlop($url,$op) {
    if ($op=='e') {
        return str_replace(array("http:","https:","ftp:"),array("http","https","ftp"),$url);
    } else if ($op=='d') {
        $nurl=str_replace(array("http","https","ftp"),array("http:","https:","ftp:"),$url);
        $nurl=str_replace(array("http::","https::","ftp::"),array("http:","https:","ftp:"),$nurl);
        return $nurl;
    }
}

function wapli($content_id,$user_id,$user_nickname,$content,$posttime,$type,$from,$status_id,$status_uname,$status_unickname,$showspeaker,$isprivate=0) {
    global $user;
    $delmsgbtn=$speaker='';
    if ($user_id==$user[user_id]) {
        $delmsgbtn=" <a href='index.php?op=home&act=delmsg&sid={$content_id}&from=".urlencode($from)."'>删除</a>";
    }
    if ($showspeaker==1) {
        $speaker="<a href='index.php?op=home&uid={$user_id}'>{$user_nickname}</a> ";
    }
    if ($isprivate==1) {
        $private="";
    } else {
        $private="<a href='index.php?op=reply&status_id={$content_id}'>回复</a> <a href='index.php?op=shoucang&sid={$content_id}'>收藏</a>";
    }
    if ($status_id && $status_uname){
        $isstatus='对'.$status_unickname.'的回复&nbsp;';
    } else {
        $isstatus='&nbsp;';
    }
    return "<li>$speaker".wapreplace($content)." <span class='stamp'>".timeop($posttime)." 通过{$type}{$isstatus}{$private}{$delmsgbtn}</span></li>";
}

function showmessage($message) {
    wapheader();
    echo $message;
    wapfooter();
}
?>