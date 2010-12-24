jQuery.cookie = function(name, value, options) {if (typeof value != 'undefined') {options = options || {};if (value === null) {value = '';options.expires = -1;}var expires = '';if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {var date;if (typeof options.expires == 'number') {date = new Date();date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));} else {date = options.expires;}expires = '; expires=' + date.toUTCString();}var path = options.path ? '; path=' + (options.path) : '';var domain = options.domain ? '; domain=' + (options.domain) : '';var secure = options.secure ? '; secure' : '';document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');} else {var cookieValue = null;if (document.cookie && document.cookie != '') {var cookies = document.cookie.split(';');for (var i = 0; i < cookies.length; i++) {var cookie = jQuery.trim(cookies[i]);if (cookie.substring(0, name.length + 1) == (name + '=')) {cookieValue = decodeURIComponent(cookie.substring(name.length + 1));break;}}}return cookieValue;}};
var autoupdatehomeid;
var autoupdateindexid;
var indexpage=0;
var homepage=0;
var pripage=0;
var hometab;
var titlebody;
var etobj = jQuery.parseJSON(etuser);
var setok=etobj.setok;
var webaddr=etobj.webaddr;
var user_id=etobj.user_id;
var my_uid=etobj.my_uid;
var user_name=etobj.user_name;
var nickname=etobj.nickname;
$(document).ready(function(){
    titlebody=$(document).find("title").html();
    reloadjs();
    //微博达人
    $("#imgList li").mouseover(function(){
        $(this).addClass("on");
        $(this).children(".pbg").attr("class","pbg2");
    });
    $("#imgList li").mouseout(function(){
        $(this).removeClass("on");
        $(this).children(".pbg2").attr("class","pbg");
    });
    // 输入字数计算
    $("#contentbox").keyup(function(){
        var len=$('#contentbox').val().length;
        len=140-len;
        if (len<0) {
            $('#contentbox').val($('#contentbox').val().slice(0,140));
            len=0;
        }
        $('#nums').html(len);
    });
    //自动刷新
    $("#autoupdatehome").click(function() {
        if ($("#autoupdatehome:checked").val()=='on' && user_name) {
            homeup();
        } else {
            $("#updatetime").html("30");
            clearInterval(autoupdatehomeid);
        }
    });
    $("#autoupdateindex").click(function() {
        if ($("#autoupdateindex:checked").val()=='on') {
            indexup();
        } else {
            $("#updatetime").html("30");
            clearInterval(autoupdateindexid);
        }
    });
    // tip
    if(setok=="theme1") {
        ye_msg.open('模板保存成功^_^',3,1);
    } else if(setok=="home1") {
        ye_msg.open('您没有输入信息内容',3,2);
    } else if(setok=="home4") {
        ye_msg.open('分享地址不合法',3,2);
    } else if(setok=="home5") {
        ye_msg.open('描述字数太多,不可超过100字',3,2);
    } else if(setok=="home6") {
        ye_msg.open('分享成功了',3,1);
    } else if(setok=="home7") {
        ye_msg.open('分享的地址不能识别',3,2);
    } else if(setok=="account1") {
        ye_msg.open('您两次输入的密码不一样或为空！',3,2);
    } else if(setok=="account2") {
        ye_msg.open('密码修改成功',3,1);
    } else if(setok=="account3") {
        ye_msg.open('原始密码错误',3,2);
    } else if(setok=="finder1") {
        ye_msg.open('成功发送邀请^_^',3,1);
    } else if(setok=="finder1") {
        ye_msg.open('没有填写邀请的电子邮件',3,2);
    } else if(setok=="login1") {
        ye_msg.open('您好，您的帐号被管理员屏蔽，不能登录！',3,2);
    } else if(setok=="login2") {
        ye_msg.open('用户名或者密码错误，请重新登录！',3,2);
    } else if(setok=="mail1") {
        ye_msg.open('验证邮件已经发送，请查收',3,1);
    } else if(setok=="mail2") {
        ye_msg.open('邮箱格式不正确',3,2);
    } else if(setok=="mail3") {
        ye_msg.open('邮箱已存在，请更换其他邮箱',3,2);
    } else if(setok=="mail4") {
        ye_msg.open('新电子邮件和旧电子邮件不能一样',3,2);
    } else if(setok=="mail5") {
        ye_msg.open('没有填写电子邮件',3,2);
    } else if(setok=="mail6") {
        ye_msg.open('邮箱已经验证成功',3,1);
    } else if(setok=="mail7") {
        ye_msg.open('邮箱已经验证失败',3,2);
    } else if(setok=="mail8") {
        ye_msg.open('邮箱已经更换',3,1);
    } else if(setok=="reset1") {
        ye_msg.open('未找到您的邮箱地址',3,2);
    } else if(setok=="reset2") {
        ye_msg.open('电子邮件已发出，请查收',3,1);
    } else if(setok=="setting1") {
        ye_msg.open('头像设置成功^_^',3,1);
    } else if(setok=="setting2") {
        ye_msg.open('新昵称已经存在',3,2);
    } else if(setok=="setting3") {
        ye_msg.open('信息保存成功',3,1);
    } else if(setok=="settingfirst") {
        ye_msg.open('您是第一次登陆微博，请先完善您的资料',3,3);
    } else if(setok=="feedback1") {
        ye_msg.open('信息提交成功，感谢您的反馈！',3,1);
    } else if(setok=="feedback2") {
        ye_msg.open('很抱歉，提价信息失败了！',3,2);
    } else if(setok=="report1") {
        ye_msg.open('感谢您的举报，我们会及时处理！',3,1);
    } else if(setok=="report2") {
        ye_msg.open('您没有填写完整举报信息！',3,2);
    } else if(setok=="upload1") {
        ye_msg.open('传失败，文件过大或者文件不存在！',3,2);
    } else if(setok=="upload2") {
        ye_msg.open('上传图片过大，请控制在2M之内！',3,2);
    } else if(setok=="upload3") {
        ye_msg.open('上传失败，图片格式不正确！',3,2);
    } else if(setok=="upload4") {
        ye_msg.open('上传失败，附件文件不存在！',3,2);
    } else if(setok=="im1") {
        ye_msg.open('您填写的Gtalk地址不正确！',3,2);
    } else if(setok=="im2") {
        ye_msg.open('您填写的Gtalk地址已经存在！',3,2);
    } else if(setok=="im3") {
        ye_msg.open('Gtalk已经绑定，请按照操作进行验证！',3,1);
    } else if(setok=="im4") {
        ye_msg.open('Gtalk已经成功注销！',3,1);
    }
});

function reloadjs() {
    // li
    $("ol li").mouseover(function(){
        $(this).addClass("light");
        $(this).removeClass("unlight");
    });
    $("ol li").mouseout(function(){
        $(this).addClass("unlight");
        $(this).removeClass("light");
    });
}

//自动更新倒计时
function homeup() {
    clearInterval(autoupdatehomeid);
    var _s=30;
    function doTime() {
        _s--;
        if (_s<=0) {
            _s=30;
            homeupcount();
        }
        $("#updatetime").html(_s);
    }
    autoupdatehomeid=setInterval(doTime, 1000);
}
function homeupcount() {
    var s1=$('.wa li').first();
    var s2=s1.find("span").last().attr("id");
    var s3=s2.replace("reply_","");
    var reg = new RegExp('<li class="unlight">', "g");
    $.ajax({
    type: "GET",
    url: webaddr+"/home/"+user_name+"/friend&act=getupdate&lastid="+s3+"&rank="+GetRandomNum(1,999999),
    success:function(msg){
        var num=msg.match(reg).length;
        if (num>0) {
            $(document).find("title").html("("+num+") "+titlebody)
            $("#newshow").html("有"+num+"条新动态，<a href='##' onclick='shownewhome()'>点击查看</a>");
            $("#newshowhtml").html(msg);
            $("#newshow").show();
        }
    }});
}
function shownewhome() {
    //处理
    $(document).find("title").html(titlebody)
    var firstli=$('.wa li').first();
    $("#newshow").hide();
    $("#newshow").attr("background","#ffffff");
    var lilength=$("ol li").length;
    firstli.before($("#newshowhtml").html());
    $("#newshowhtml").html('');
    //绑定事件
    var newlilength=$("ol li").length;
    var obj=$("ol li").slice(0, parseInt(newlilength)-parseInt(lilength));
    obj.mouseover(function(){
        $(this).addClass("light");
        $(this).removeClass("unlight");
    });
    obj.mouseout(function(){
        $(this).addClass("unlight");
        $(this).removeClass("light");
    });
}

function indexup() {
    clearInterval(autoupdateindexid);
    var _s2=30;
    function doTime2() {
        _s2--;
        if (_s2<=0) {
            _s2=30;
            indexupinsert();
        }
        $("#updatetime").html(_s2);
    }
    autoupdateindexid=setInterval(doTime2, 1000);
}
function indexupinsert() {
    var s1=$('.wa li').first();
    var s2=s1.find("span").last().attr("id");
    var s3=s2.replace("reply_","");
    $.ajax({
    type: "GET",
    url: webaddr+"/index.php?act=getupdate&lastid="+s3+"&rank="+GetRandomNum(1,999999),
    success:function(msg){
        if (msg!='<center>没有更多的消息可以显示了...</center>') {
            var lilength=$("ol li").length;
            s1.before(msg);
            var newlilength=$("ol li").length;
            var obj=$("ol li").slice(0, parseInt(newlilength)-parseInt(lilength));
            obj.mouseover(function(){
                $(this).addClass("light");
                $(this).removeClass("unlight");
            });
            obj.mouseout(function(){
                $(this).addClass("unlight");
                $(this).removeClass("light");
            });
        }
    }});
}

//复制
function ETCopy(id){
    var testCode=document.getElementById(id).value;
    if(copy2Clipboard(testCode)!=false){
        document.getElementById(id).select() ;
        ye_msg.open('已复制剪贴板，用Ctrl+V粘贴吧',1,1);
    }
}
copy2Clipboard=function(txt){
    if(window.clipboardData){
        window.clipboardData.clearData();
        window.clipboardData.setData("Text",txt);
    }
    else if(navigator.userAgent.indexOf("Opera")!=-1){
        window.location=txt;
    }
    else if(window.netscape){
        try{
            netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
        }
        catch(e){
            alert("您的firefox安全限制限制您进行剪贴板操作，请打开'about:config'将signed.applets.codebase_principal_support'设置为true'之后重试，相对路径为firefox根目录/greprefs/all.js");
            return false;
        }
        var clip=Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
        if(!clip)return;
        var trans=Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
        if(!trans)return;
        trans.addDataFlavor('text/unicode');
        var str=new Object();
        var len=new Object();
        var str=Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
        var copytext=txt;str.data=copytext;
        trans.setTransferData("text/unicode",str,copytext.length*2);
        var clipid=Components.interfaces.nsIClipboard;
        if(!clip)return false;
        clip.setData(trans,null,clipid.kGlobalClipboard);
    }
}

function GetRandomNum(Min,Max) {
    var Range = Max - Min;
    var Rand = Math.random();
    return(Min + Math.round(Rand * Range));
}

//删除信息
function delmsg(url,mes,obj) {
    var mymes;
    if (!my_uid) {
        location.href=webaddr+'/op/login';
    }
    mymes=confirm(mes);
    if(mymes==true){
        $.ajax({
        type: "GET",
        url: url,
        success: function(msg){
            if (msg=="success") {
                $(obj).animate({opacity: 'toggle'}, "slow");
                ye_msg.open('删除成功 ^_^',1,1);
            } else {
                ye_msg.open(msg,3,2);
            }
        }
        });
    }
}

//解除添加关注
function followop(url,mes,mes2,uname,unickname) {
    var mymes;
    if (!my_uid) {
        location.href=webaddr+'/op/login';
    }
    if (mes2=='gz') {
        mymes=true;
    } else {
        mymes=confirm(mes);
    }
    if(mymes==true){
        $.ajax({
        type: "GET",
        url: url,
        success: function(msg){
            if (msg=="success") {
                if (mes2=='gz') {
                    ye_msg.open('关注成功 ^_^',1,1);
                    $('#followsp_'+uname).html("<a class='bl' href='javascript:void(0);' onclick=\"followop('"+webaddr+"/home.php?act=delfollow&user_name="+uname+"&rank="+GetRandomNum(1,999999)+"','确认要解除对 "+unickname+" 的关注吗？','jc','"+uname+"','"+unickname+"')\">解除关注</a>");
                } else {
                    ye_msg.open('解除成功 ^_^',1,1);
                    $('#followsp_'+uname).html("<a class='bh' href='javascript:void(0);' onclick=\"followop('"+webaddr+"/home.php?act=addfollow&user_name="+uname+"&rank="+GetRandomNum(1,999999)+"','','gz','"+uname+"','"+unickname+"')\">关注一下</a>");
                }
            } else {
                ye_msg.open(msg,3,2);
            }
        }
        });
    }
}

function jsop(url,mes){
    var mymes;
    if (!my_uid) {
        location.href=webaddr+'/op/login';
    }
    mymes=confirm(mes);
    if(mymes==true){
        window.location=url;
    }
}

function cookielimit() {
    var optiontimes= Number($.cookie('optiontimes'));
    if (optiontimes>3) {
        ye_msg.open('你的操作太快，休息一下吧！',1,2);
        return false;
    }
    $.cookie("optiontimes", optiontimes+1, {expires:0.0001});
}

//收藏
function send_f(id){
    if (!my_uid) {
        location.href=webaddr+'/op/login';
    }
    if (cookielimit()==false) {
        return false;
    }
    $.ajax({
    type: "GET",
    url: webaddr+'/home.php?hm=favorite&act=addfav&fid='+id+"&rank="+GetRandomNum(1,999999),
    success: function(msg){
        if (msg=='success') {
            ye_msg.open('收藏成功 ^_^',1,1);
        } else {
            ye_msg.open(msg,1,2);
        }
    }});
}

//转发
function zhuanfa(id){
    if (cookielimit()==false) {
        return false;
    }
    if (!my_uid) {
        location.href=webaddr+'/op/login';
    }
    $.ajax({
    type: "GET",
    url: webaddr+'/home.php?act=zhuanfa&cid='+id+"&rank="+GetRandomNum(1,999999),
    success: function(msg){
        if (msg=='success') {
            ye_msg.open('转发成功 ^_^',1,1);
        } else {
            ye_msg.open('此消息不能被转发！',1,2);
        }
    }});
}

function isfun(val) {
    if (val=="#请在这里输入自定义话题#") {
        ye_msg.open('请输入要发表的话题',1,2);
        return false;
    } else if (val=="") {
        ye_msg.open('您没有填写发表的内容，请填写后发表！',1,2);
        return false;
    } else if (val.length>140)  {
        ye_msg.open('发送的信息长度不能大于140字符！',1,2);
        return false;
    } else {
        return true;
    }
}
function isfun2(funame,msg) {
    if (funame=="") {
        ye_msg.open('您还没有选择好友！',1,2);
        return false;
    }
    if (msg=="") {
        ye_msg.open('您没有填写发表的内容，请填写后发表！',1,2);
        return false;
    } else if (msg.length>140)  {
        ye_msg.open('发送的信息长度不能大于140字符！',1,2);
        return false;
    } else {
        return true;
    }
}

// 回复
function replysend(id,uid) {
    if (cookielimit()==false) {
        return false;
    }
    var replycheckbox=$("#replycheckbox_"+id).attr('checked');
    if (!my_uid) {
        location.href=webaddr+'/op/login';
    }
    if ($('#replybox_'+id).val()=="") {
        ye_msg.open('您没有填写回复的内容，请填写后发表！',1,2);
        return false;
    } else if ($('#replybox_'+id).val().length>140)  {
        ye_msg.open('回复的信息长度不能大于140字符！',1,2);
        return false;
    } else {
        $('#replybutton_'+id).css("background","#ffffff");
        $('#replybutton_'+id).css("color","#000000");
        $('#replybutton_'+id).attr("disabled","disabled");
        var cont=countCharacters($('#replybox_'+id).val(),140);
        var sendreply= $.cookie('sendreply');
        if (cont==sendreply) {
            $('#replybox_'+id).val("");
            $('#replybutton_'+id).removeAttr("disabled");
            $('#replybutton_'+id).css("background","#2680e9");
            $('#replybutton_'+id).css("color","#ffffff");
            ye_msg.open('不能发表相同信息',1,2);
            return false;
        }
        $.ajax({
        type: "POST",
        url: webaddr+"/source/ajax_reply.php",
        data:"action=sendreply&sid="+id+"&suid="+uid+"&scont="+cont+"&rck="+replycheckbox+"&rank="+GetRandomNum(1,999999),
        success: function(msg){
            if (msg!="此消息是私密消息不能回复" && msg!="你还没有填写发表的内容！" && msg!="数据传输错误！") {
                $.cookie('sendreply', cont);
                $("#showall_"+id).append(msg);
            } else {
                ye_msg.open(msg,1,2);
            }
            $('#replybox_'+id).val("");
            $('#replybutton_'+id).removeAttr("disabled");
            $('#replybutton_'+id).css("background","#2680e9");
            $('#replybutton_'+id).css("color","#ffffff");
        }});
    }
}

function showemotion(em,pid) {
    $("#"+em).html('<div class="emotions"><ul class="emotion"><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(疑问)\')"><img alt="疑问" title="疑问" src="'+webaddr+'/attachments/emotion/1.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(惊喜)\')"><img alt="惊喜" title="惊喜" src="'+webaddr+'/attachments/emotion/2.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(鄙视)\')"><img alt="鄙视" title="鄙视" src="'+webaddr+'/attachments/emotion/3.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(呕吐)\')"><img alt="呕吐" title="呕吐" src="'+webaddr+'/attachments/emotion/4.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(拜拜)\')"><img alt="拜拜" title="拜拜" src="'+webaddr+'/attachments/emotion/5.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(大笑)\')"><img alt="大笑" title="大笑" src="'+webaddr+'/attachments/emotion/6.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(求)\')"><img alt="求" title="求" src="'+webaddr+'/attachments/emotion/7.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(色)\')"><img alt="色" title="色" src="'+webaddr+'/attachments/emotion/8.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(撇嘴)\')"><img alt="撇嘴" title="撇嘴" src="'+webaddr+'/attachments/emotion/9.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(调皮)\')"><img alt="调皮" title="调皮" src="'+webaddr+'/attachments/emotion/10.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(流泪)\')"><img alt="流泪" title="流泪" src="'+webaddr+'/attachments/emotion/11.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(偷笑)\')"><img alt="偷笑" title="偷笑" src="'+webaddr+'/attachments/emotion/12.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(鲜花)\')"><img alt="鲜花" title="鲜花" src="'+webaddr+'/attachments/emotion/13.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(流汗)\')"><img alt="流汗" title="流汗" src="'+webaddr+'/attachments/emotion/14.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(困)\')"><img alt="困" title="困" src="'+webaddr+'/attachments/emotion/15.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(惊恐)\')"><img alt="惊恐" title="惊恐" src="'+webaddr+'/attachments/emotion/16.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(闪人)\')"><img alt="闪人" title="闪人" src="'+webaddr+'/attachments/emotion/17.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(惊讶)\')"><img alt="惊讶" title="惊讶" src="'+webaddr+'/attachments/emotion/18.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(心)\')"><img alt="心" title="心" src="'+webaddr+'/attachments/emotion/19.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(发怒)\')"><img alt="发怒" title="发怒" src="'+webaddr+'/attachments/emotion/20.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(发愁)\')"><img alt="发愁" title="发愁" src="'+webaddr+'/attachments/emotion/21.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(投降)\')"><img alt="投降" title="投降" src="'+webaddr+'/attachments/emotion/22.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(便便)\')"><img alt="便便" title="便便" src="'+webaddr+'/attachments/emotion/23.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(害羞)\')"><img alt="害羞" title="害羞" src="'+webaddr+'/attachments/emotion/24.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(大哭)\')"><img alt="大哭" title="大哭" src="'+webaddr+'/attachments/emotion/25.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(得意)\')"><img alt="得意" title="得意" src="'+webaddr+'/attachments/emotion/26.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(跪服)\')"><img alt="跪服" title="跪服" src="'+webaddr+'/attachments/emotion/27.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(难过)\')"><img alt="难过" title="难过" src="'+webaddr+'/attachments/emotion/28.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(生气)\')"><img alt="生气" title="生气" src="'+webaddr+'/attachments/emotion/29.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(闭嘴)\')"><img alt="闭嘴" title="闭嘴" src="'+webaddr+'/attachments/emotion/30.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(抓狂)\')"><img alt="抓狂" title="抓狂" src="'+webaddr+'/attachments/emotion/31.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(人品)\')"><img alt="人品" title="人品" src="'+webaddr+'/attachments/emotion/32.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(钱)\')"><img alt="钱" title="钱" src="'+webaddr+'/attachments/emotion/33.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(酷)\')"><img alt="酷" title="酷" src="'+webaddr+'/attachments/emotion/34.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(挨打)\')"><img alt="挨打" title="挨打" src="'+webaddr+'/attachments/emotion/35.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(痛打)\')"><img alt="痛打" title="痛打" src="'+webaddr+'/attachments/emotion/36.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(阴险)\')"><img alt="阴险" title="阴险" src="'+webaddr+'/attachments/emotion/37.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(疑问)\')"><img alt="疑问" title="疑问" src="'+webaddr+'/attachments/emotion/38.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(尴尬)\')"><img alt="尴尬" title="尴尬" src="'+webaddr+'/attachments/emotion/39.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(发呆)\')"><img alt="发呆" title="发呆" src="'+webaddr+'/attachments/emotion/40.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(睡)\')"><img alt="睡" title="睡" src="'+webaddr+'/attachments/emotion/41.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(嘘)\')"><img alt="嘘" title="嘘" src="'+webaddr+'/attachments/emotion/42.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(鼻血)\')"><img alt="鼻血" title="鼻血" src="'+webaddr+'/attachments/emotion/43.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(可爱)\')"><img alt="可爱" title="可爱" src="'+webaddr+'/attachments/emotion/44.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(亲吻)\')"><img alt="亲吻" title="亲吻" src="'+webaddr+'/attachments/emotion/45.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(寒)\')"><img alt="寒" title="寒" src="'+webaddr+'/attachments/emotion/46.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(谢谢)\')"><img alt="谢谢" title="谢谢" src="'+webaddr+'/attachments/emotion/47.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(顶)\')"><img alt="顶" title="顶" src="'+webaddr+'/attachments/emotion/48.gif"/></a></li><li><a href="javascript:void(0);" onclick="emotion(\''+em+'\',\''+pid+'\',\'(胜利)\')"><img alt="胜利" title="胜利" src="'+webaddr+'/attachments/emotion/49.gif"/></a></li><li> </li><li> </li><li><a href="javascript:void(0);" onclick="closeemotion(\''+em+'\')">&nbsp;x&nbsp;</a></li></ul></div>');
    var p = $("#"+pid);
    var position = p.position();
    $('#'+em).css("top",position.top+85);
    $('#'+em).css("left",position.left);
}

function emotion(em,id,emo) {
    $("#"+id).val($("#"+id).val()+emo);
    closeemotion(em);
}

function closeemotion(id) {
     $("#"+id).html('');
}

// 发送私信box
function sendprimsgbox(funame) {
    var html='<div style="margin:0 20px;"><p><textarea onkeyup="$(\'#pmcontentbox\').val($(\'#pmcontentbox\').val().slice(0,140));" name="content" id="pmcontentbox" class="input_text" style="width:350px;height:70px;"></textarea><div id="emotion"></div></p><p><div style="float:left;margin-top:10px"><a href="javascript:void(0);" onclick="showemotion(\'emotion\',\'pmcontentbox\')"><img src="'+webaddr+'/images/default/facelist.gif"></a></div><div style="float:right;margin-top:10px"><input type="button" class="formbutton" onclick="if (isfun2(\''+funame+'\',$(\'#pmcontentbox\').val())){sendprimsg(\''+funame+'\',$(\'#pmcontentbox\').val())}" title="按Ctrl+Enter键发送消息" value="发送"/></div></p></div>';
    ye_dialog.openHtml(html,'@'+funame,'400','175');
}

// 发送私信
function sendprimsg(funame,contents) {
    if (cookielimit()==false) {
        return false;
    }
    if (!my_uid) {
        location.href=webaddr+'/op/login';
    }
    var url=webaddr+"/source/ajax.php";
    var postDt="action=send&funame="+funame+"&content="+contents+"&rank="+GetRandomNum(1,999999);
    $.ajax({
    type: "POST",
    url:  url,
    data: postDt,
    success: function(msg){
        if (msg=="success") {
            $('#pmcontentbox').val('');
            ye_msg.open('私信发送成功了！',1,1);
            ye_dialog.close();
        } else {
            ye_msg.open(msg,1,2);
        }
    }});
}

//发表Talk
function sendTalk(topic) {
    if (cookielimit()==false) {
        return false;
    }
    if (!my_uid) {
        location.href=webaddr+'/op/login';
    }
    var cont=$("#contentbox").val();
    var ispri=$("#privacy:checked").val();
    var morecontent=$("#morecontent").html();
    ispri=ispri?1:0;
    $('#emotion').css('display','none');
    if (!cont) {
        ye_msg.open('您没有输入信息内容',1,2);
        return false;
    }
    var sendbody= $.cookie('sendbody');
    if (cont==sendbody) {
        ye_msg.open('不能发表相同信息',1,2);
        return false;
    }
    // 提交
    $.ajax({
    type: "POST",
    url:  webaddr+"/home.php",
    data: "action=msgsend&content="+cont+"&morecontent="+morecontent+"&privacy="+ispri+"&rank="+GetRandomNum(1,999999),
    success: function(msg){
        if (msg!='error') {
            var firstli;
            if ((ispri==0 && $('#stab_friend').hasClass("current")) || topic) {
               firstli=$(".wa li").first();
               firstli.before(msg);
            }
            if (ispri==1 && $('#stab_privacy').hasClass("current") && !topic) {
               firstli=$("ol li").first();
               firstli.before(msg);
            }
            $("ol li").slice(0, 1).mouseover(function(){
               $(this).addClass("light");
               $(this).removeClass("unlight");
            });
            $("ol li").slice(0, 1).mouseout(function(){
               $(this).addClass("unlight");
               $(this).removeClass("light");
            });
            if (topic) {
                $("#contentbox").val("#"+topic+"#");
            } else {
                $('#contentbox').val('');
            }
            //更新消息数
            if (ispri==0 && !topic) {
                $("#mymsgnum").html(parseInt($("#mymsgnum").html())+1);
            }
            $.cookie('sendbody', cont);
            //清除图片
            $("#uploading").hide();
            $("#priviewbtn").hide();
            $("#loadform").show();
            $("#priviewpoic").html('');
            $("#imageUpload").contents().find("body").html('');
            $("#morecontent").html('');
            $("#nums").html('140');
            ye_msg.open('消息发表成功！',1,1);
        } else {
            ye_msg.open('您没有输入信息内容',1,2);
        }
    }});
}

// 回复调用
function replyajax(contid,reshow) {
    var e=$('#reply_'+contid+':empty').length;
    if (e==1 || reshow=='reshow') {
        $('#reply_'+contid).html('<span style="margin:10px 0 0 30px"><img src="'+webaddr+'/images/spinner.gif"></span>');
        $.ajax({
        type: "GET",
        url:  webaddr+"/source/ajax_reply.php?act=load&cid="+contid+"&rank="+GetRandomNum(1,999999),
        success: function(msg){
            $('#reply_'+contid).html(msg);
            $('#replybox_'+contid).focus();
        }});
    } else {
        $('#reply_'+contid).html("");
    }
}
function replyajaxin(inputid,nickname) {
    var atto='@'+nickname+' ';
    $('#replybox_'+inputid).focus();
    $('#replybox_'+inputid).val(atto);
}

// 字数统计[中英文]
function isChinese(str) {
   var lst = /[u00-uFF]/;
   return !lst.test(str);
}
function CheckLen(str) {
   var strlength=0;
   for (i=0;i<str.length;i++) {
     if (isChinese(str.charAt(i))==true) {
        strlength=strlength + 2;
     } else {
        strlength=strlength + 1;
     }
   }
   return strlength;
}

// 字符串截取
function countCharacters(str, len) {
    if(!str || !len) { return ''; }
    var a = 0;
    var i = 0;
    var temp = '';
    for (i=0;i<str.length;i++) {
        a++;
        if(a > len) { return temp; }
         temp += str.charAt(i);
    }
    return str;
}

// Showhome
function showhome(tabname,uname,type){
    if (tabname!='friend') {
        clearInterval(autoupdatehomeid);
    } else {
        if ($("#autoupdatehome:checked").val()=='on' && user_name) {
            homeup();
        }
    }
    $("#indexpage").html('<span style="color:#999"><img src="'+webaddr+'/images/spinner.gif"> 正在载入中</span>');
    if (type=='new' || hometab!=tabname) {
        homepage=1;
    } else {
        homepage++;
    }
    if (type=='new' || $("#homecontainer").html()=='' || hometab!=tabname) {
        $("#homecontainer").html('<div id="loadingimg" style="margin-top:10px"><img src="'+webaddr+'/images/spinner.gif"> 数据载入中...</div>');
    }
    $("#homestabs > li").attr("class","");
    $("#stab_"+tabname).attr("class","loading");
    if (tabname=='privacy') {
        var url=webaddr+"/home/"+uname+"/home/p."+homepage+"&privacy=1&rank="+GetRandomNum(1,999999);
    } else {
        var url=webaddr+"/home/"+uname+"/"+tabname+"/p."+homepage+"&rank="+GetRandomNum(1,999999);
    }
    if (tabname=='friend') {
        $("#homeupdate").show();
    } else {
        $("#homeupdate").hide();
    }
    var lilength=0;
    $.ajax({
    type: "GET",
    url: url,
    success: function(msg){
        $("#homeload").remove();
        if (type=='new' || hometab!=tabname) {
            $("#homecontainer").html(msg);
        } else {
            lilength=$("ol li").length;
            $("#homecontainer").append(msg);
        }
        hometab=tabname;
        $("#stab_"+tabname).attr("class","current");
        //绑定事件
        if (lilength>0) {
            var newlilength=$("ol li").length;
            var obj=$("ol li").slice(parseInt(lilength)-1, newlilength);
            obj.mouseover(function(){
                $(this).addClass("light");
                $(this).removeClass("unlight");
            });
            obj.mouseout(function(){
                $(this).addClass("unlight");
                $(this).removeClass("light");
            });
        } else {
            reloadjs();
        }
        $("#loadingimg").remove();
    }
    });
}

// 注册检测
function check_register() {
    var t0=$('#invitecode').val();
    var t1=$('#username').val();
    var t2=$('#mailadres').val();
    var t3=$('#password1').val();
    var t4=$('#password2').val();
    var t5=$('#nickname').val();
    var url1=webaddr+"/op.php?op=register&act=check&invitecode="+t0+"&uname="+t1+"&unick="+t5+"&mail="+t2+"&pass1="+t3+"&pass2="+t4+"&rank="+GetRandomNum(1,999999);
    var url2=webaddr+"/op.php?op=register&act=reg&invitecode="+t0+"&uname="+t1+"&unick="+t5+"&mail="+t2+"&pass1="+t3+"&pass2="+t4+"&rank="+GetRandomNum(1,999999);

    $.ajax({
    type: "GET",
    url: url1,
    success:function(msg){
        if (msg=="check_ok") {
            ye_dialog.openUrl(url2,400,100,'新用户注册');
        } else {
            ye_msg.open(msg,3,2);
        }
    }
    });
}

function shares() {
    var html='<div style="margin-left:40px"><form action="'+webaddr+'/'+user_name+'/profile" method="post"><p>分享视频、音乐、Flash、网址</p><p><input type="text" name="link" id="link" class="input_text" value="http://" onfocus="javascript:if(\'http://\'==this.value)this.value=\'\';" onblur="javascript:if(\'\'==this.value)this.value=\'http://\'" style="width:190px;" /></p><p>描述(最多100个字符,可留空)</p><p><textarea name="describe" style="width:190px;height:100px" class="input_text"></textarea></p><p><input name="action" value="share" type="hidden"><input tabindex="4" type="submit" class="formbutton" value="分享" onclick="javascript:var l=$(\'#link\').val();if(countCharacters(l,7)!=\'http://\' || l==\'http://\'){ye_msg.open(\'您输入的网址不合法\',1,2);return false;}" />&nbsp;&nbsp;<input class="formbutton" type="button" value="关闭" onclick="ye_dialog.close()"/></p></form></div>';
    ye_dialog.openHtml(html,'我要分享','300','330');
}

function reportbox() {
    var html='<div style="margin-left:40px;margin-right:40px;margin-top:10px"><p>如果您在微博中发现有色情、暴力或者其它违规的内容,请提交，我们将尽快处理。</p><br/><form action="'+webaddr+'/index" method="post"><select name="reporttp" id="reporttp"><option value="0" selected="selected">=请选择不良信息的类型=</option><option value="1">涉及黄色和暴力</option><option value="2">政治反动</option><option value="3">内容侵权</option><option value="4">其他不良信息</option></select><p>不良信息描述并请提交不良信息的地址</p><p><textarea name="describe" id="describe" style="width:310px;height:100px" class="input_text">当前地址：'+document.URL+'</textarea></p><p><input name="action" value="reportsubmit" type="hidden"><center><input tabindex="4" type="submit" class="formbutton" value="确定" onclick="javascript:var l=$(\'#reporttp\').val();var d=$(\'#describe\').val();if(l==0 || !d){ye_msg.open(\'您的举报信息没有填写完整！\',1,2);return false;}"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="formbutton" type="button" value="关闭" onclick="ye_dialog.close()"/></center></p></form></div>';
    ye_dialog.openHtml(html,'举报不良信息','400','350');
}

function rtopic() {
	$('#contentbox').val('#请在这里输入自定义话题#');
	var textArea = document.getElementById('contentbox')
	if (document.selection) { //IE
		 var rng = textArea.createTextRange();
		 rng.collapse(true);
		 rng.moveEnd("character",12)
		 rng.moveStart("character",1)
		 rng.select();
	} else if (textArea.selectionStart || (textArea.selectionStart == '0')) { // Mozilla/Netscape…
        textArea.selectionStart = 1;
        textArea.selectionEnd = 12;
    }
    textArea.focus();
    return false;
}


// 回复调用
function getReplyContent(contid,spid) {
    var e=$('#replyC_'+spid+':empty').length;
    if (e==1) {
        $('#replyC_'+spid).html('<span style="margin:10px 0 0 30px"><img src="'+webaddr+'/images/spinner.gif"></span>');
        $.ajax({
        type: "GET",
        url:  webaddr+"/source/ajax.php?act=getreplycontent&contid="+contid+"&rank="+GetRandomNum(1,999999),
        success: function(msg){
            $('#replyC_'+spid).html(msg);
        }});
    } else {
        $('#replyC_'+spid).html('');
    }
}

function loadindexajax() {
    indexpage++;
    $("#indexpage").html('<span style="color:#999"><img src="'+webaddr+'/images/spinner.gif"> 正在载入中</span>');
    $.ajax({
        type: "GET",
        url:  webaddr+"/index.php?act=loadindex&page="+indexpage+"&rank="+GetRandomNum(1,999999),
        success: function(msg){
            var lilength=$("ol li").length;
            lilength=lilength==0?1:lilength;
            $('#indexcont').append(msg);
            var newlilength=$("ol li").length;
            var obj=$("ol li").slice(parseInt(lilength)-1, newlilength);
            obj.mouseover(function(){
                $(this).addClass("light");
                $(this).removeClass("unlight");
            });
            obj.mouseout(function(){
                $(this).addClass("unlight");
                $(this).removeClass("light");
            });
            $("#indexpage").html("显示更多");
    }});
}

function indextop() {
    window.location.href="#";
}

function isKeyTrigger(e,keyCode){
    var argv = isKeyTrigger.arguments;
    var argc = isKeyTrigger.arguments.length;
    var bCtrl = false;
    if(argc > 2){
        bCtrl = argv[2];
    }
    var bAlt = false;
    if(argc > 3){
        bAlt = argv[3];
    }
    var nav4 = window.Event ? true : false;
    if(typeof e == 'undefined') {
        e = event;
    }
    if( bCtrl && !((typeof e.ctrlKey != 'undefined') ? e.ctrlKey : e.modifiers & Event.CONTROL_MASK > 0)){
        return false;
    }
    if( bAlt && !((typeof e.altKey != 'undefined') ? e.altKey : e.modifiers & Event.ALT_MASK > 0)){
        return false;
    }
    var whichCode = 0;
    if (nav4) whichCode = e.which;
    else if (e.type == "keypress" || e.type == "keydown") whichCode = e.keyCode;
    else whichCode = e.button;
    return (whichCode == keyCode);
}

function ctrlEnter(e){
    var ie =navigator.appName=="Microsoft Internet Explorer"?true:false;
    if(ie){
        if(event.ctrlKey && window.event.keyCode==13){sendTalk();}
    } else {
        if(isKeyTrigger(e,13,true)){sendTalk();}
    }
}

function ctrlEnterReply(e,p1,p2){
    var ie =navigator.appName=="Microsoft Internet Explorer"?true:false;
    if(ie){
        if(event.ctrlKey && window.event.keyCode==13){replysend(p1,p2);}
    } else {
        if(isKeyTrigger(e,13,true)){replysend(p1,p2);}
    }
}

function showallreply(id) {
    $("#showall_"+id).html($("#all_"+id).html());
}

//pic
function cencelUpload() {
    $("#imageUpload").attr("src","about:blank");
    $("#loadform").show();
    $("#priviewbtn").hide();
    $("#uploading").hide();
    $("#imageUpload").contents().find("body").html('');
}
function uploadpic() {
    $("#imageUpload").attr("src","about:blank");
    $("#loadform").hide();
    $("#priviewbtn").hide();
    $("#uploading").show();
    $("#upform").submit();
    $('#imageUpload').unbind("load");
    $("#imageUpload").load(function(){loadpic();});
}
function loadpic() {
    var htmls=$("#imageUpload").contents().find("body").html();
    var obj = jQuery.parseJSON(htmls);
    if (htmls) {
        if (obj.ret=='success') {
            $("#loadform").hide();
            $("#uploading").hide();
            $("#priviewbtn").show();
            $("#priviewbtn").html(obj.name+"<a href='##' onclick='delUpload()'> [删除]</a>");
            $("#priviewpoic").html("<img src='"+obj.img+"'>");
            $("#priviewbtn").mouseover(function(){$("#priviewpoic").show();});
            $("#priviewbtn").mouseout(function(){$("#priviewpoic").hide();});
            $("#imageUpload").contents().find("body").html('');
            $("#morecontent").html(obj.content);
            if (!$('#contentbox').val()) {
                $('#contentbox').val('我分享了照片');
            }
        } else {
            ye_msg.open(obj.ret,3,2);
        }
    }
}
function delUpload() {
    $("#uploading").hide();
    $("#priviewbtn").hide();
    $("#loadform").show();
    $("#priviewpoic").html('');
    $("#imageUpload").contents().find("body").html('');
}