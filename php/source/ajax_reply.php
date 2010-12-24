<?php
$API=1;
include('../common.inc.php');

if ($action=='sendreply') {
    if ($_POST['sid'] && $_POST['suid'] && $_POST['scont'] && $my['user_id']) {
        $query = $db->query("SELECT privacy FROM et_content WHERE content_id='$_POST[sid]'");
        $data = $db->fetch_array($query);
        if ($data[privacy]==1) {
            echo '此消息是私密消息不能回复';
            exit;
        }
        $content=getsubstrutf8($content,0,140,false);
        $content=replace(trim($_POST['scont'])); //词语过滤
        $back=atsend($content); //@
        $content=$back['content'];
        $uids=$back['uids'];
        array_push($uids,$_POST['suid']);
        $uids=array_unique($uids);
        $content=daddslashes($content);
        $isshownew=$_POST['rck']=="true"?1:0; //作为新的信息
        $contdata=getReply($_POST[sid]);
        if (!$content) {
            echo '你还没有填写发表的内容！';
            exit;
        }
        $db->query("INSERT INTO et_content (user_id,user_name,user_nickname,user_head,content_body,posttime,status_id,status_uname,status_unickname,replyshow) VALUES ('$my[user_id]','$my[user_name]','$my[nickname]','$my[user_head]','$content','$addtime','$_POST[sid]','$contdata[user_name]','$contdata[user_nickname]','$isshownew')");
        $insertid=mysql_insert_id();
        if ($insertid) {
            for($i=0;$i<count($uids);$i++) {
                $db->query("UPDATE et_users SET replyread = replyread+1 WHERE user_id='$uids[$i]'");
                $db->query("INSERT INTO et_replyto (user_id,content_id) VALUES ('$uids[$i]','$insertid')");
            }
            $db->query("UPDATE et_users SET msg_num=msg_num+1,lastcontent='$content',lastconttime='$addtime' where user_id='$my[user_id]'");
            $db->query("UPDATE et_content SET replytimes=replytimes+1 where content_id='$_POST[sid]'");
        }
        echo loadonelireply($insertid,ubb($content));
    } else {
        echo '数据传输错误！';
    }
    exit;
}

if ($act=='load') {
    $cid=$_GET['cid'];
?>
<div class="status_reply_list">
<div class="arrow"></div>
<div class="top"></div>
<div class="cont">
<?php
$replys=array();
$rnum=0;
$query = $db->query("SELECT * FROM et_content WHERE status_id='$cid' ORDER BY content_id");
while($data = $db->fetch_array($query)) {
    $rep='';
    $rnum++;
    if ($my['user_id'] && $my['user_id']!=$data['user_id']) {
        $rep="<a href='javascript:void(0)' style='float:right' onclick=\"replyajaxin('{$cid}','{$data[user_nickname]}')\">回复</a>";
    }
    if ($my['user_id'] && $my['user_id']==$data['user_id']) {
        $rep='<a href="javascript:void(0)" style="float:right" onclick="delmsg(\''.$webaddr.'/index.php?act=del&cid='.$data[content_id].'\',\'确实要删除此条TALK吗?\',this.parentNode.parentNode.parentNode.parentNode)">删除</a>';
    }
    $content=ubb($data['content_body']);
    $replys[]='<li class="lire">
        <div class="images"><a href="'.$webaddr.'/'.$data['user_name'].'"><img src="'.$data['user_head'].'" width="30px"></a></div>
        <div class="info">
            <p><a class="username" href="'.$webaddr.'/'.$data['user_name'].'">'.$data['user_nickname'].'</a><span class="setgray">'.timeop($data['posttime']).'&nbsp;'.$rep.'</span></p>
            <p>'.$content.'</p>
        </div>
        </li>';
}
$replynums=count($replys);
$replyshow=implode(' ',$replys);
if ($replynums>5) {
    $allreply='<div id="all_'.$cid.'" style="display:none">'.$replyshow.'</div>';
    $showall='<li style="padding-bottom:0px"><a href="##" onclick="showallreply(\''.$cid.'\')">显示中间 '.($replynums-4).' 条消息</a></li>'.$allreply;
    $replyshow=$replys[0].$replys[1].$showall.$replys[$replynums-2].$replys[$replynums-1];
}
echo '<ul class="reply_list_ul"><span id="showall_'.$cid.'">'.$replyshow.'</span></ul>';
$contDT = $db->fetch_array($db->query("SELECT * FROM et_content WHERE content_id='$cid'"))
?>
<table border="0" width="100%">
<tr>
    <td width="50"><a href="javascript:void(0);" onclick="showemotion('emotion_<?php echo $cid;?>','replybox_<?php echo $cid;?>')"><img src="<?php echo $webaddr;?>/images/default/facelist.gif"></a></td>
    <td width="280"><input type="text" id="replybox_<?php echo $cid;?>" onkeyup="if (this.value.length>140) {this.value=this.value.slice(0,140)}" onkeydown="javascript:return ctrlEnterReply(event,<?php echo $contDT['content_id'];?>,<?php echo $contDT['user_id'];?>);" class="input_text" style="width:250px;height:18px;margin:5px 0 5px 0"><div id="emotion_<?php echo $cid;?>"></div></td>
    <td><input type="button" id="replybutton_<?php echo $cid;?>" class="formbutton" value="回复" onclick="replysend('<?php echo $contDT['content_id'];?>','<?php echo $contDT['user_id'];?>')"/></td>
</tr>
<tr>
    <td colspan="3"><input type="checkbox" id="replycheckbox_<?php echo $cid;?>"><label for="replycheckbox_<?php echo $cid;?>" style="margin-left:5px;color:#999999">同时发一条微博</label></td>
</tr>
</table>
</div>
<div class="bottom"></div>
</div>
<?php } ?>