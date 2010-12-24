$(document).ready(function(){
    $('#colorpicker').farbtastic('#color-background');
    $("#color-background").click(function() {
        $('#colorpicker').farbtastic('#color-background');
        closealert();
    });
    $("#color-text").click(function() {
        $('#colorpicker').farbtastic('#color-text');
        closealert();
    });
    $("#color-links").click(function() {
        $('#colorpicker').farbtastic('#color-links');
        closealert();
    });
    $("#color-sidebar").click(function() {
        $('#colorpicker').farbtastic('#color-sidebar');
        closealert();
    });
    $("#color-sidebox").click(function() {
        $('#colorpicker').farbtastic('#color-sidebox');
        closealert();
    });
    $("#color-background").val(my_theme_bgcolor);
    $("#color-background").css("background-color",my_theme_bgcolor);
    $("#color-text").val(my_theme_text);
    $("#color-text").css("background-color",my_theme_text);
    $("#color-links").val(my_theme_link);
    $("#color-links").css("background-color",my_theme_link);
    $("#color-sidebar").val(my_theme_sidebar);
    $("#color-sidebar").css("background-color",my_theme_sidebar);
    $("#color-sidebox").val(my_theme_sidebox);
    $("#color-sidebox").css("background-color",my_theme_sidebox);

    $("#tab-bg").click(function() {
        $("#settings-color").css("display","none");
        $("#settings-background").css("display","block");
        $("#tab-bg").attr("class","tab-bg show current");
        $("#tab-color").attr("class","tab-color show");
    });
    $("#tab-color").click(function() {
        $("#settings-color").css("display","block");
        $("#settings-background").css("display","none");
        $("#tab-bg").attr("class","tab-bg show");
        $("#tab-color").attr("class","tab-color show current");
    });
    $("#cencel").click(function() {
        window.location.href=webaddr+"/op/theme";
    });
    $("#save").click(function() {
        top.window.onbeforeunload="";
    });
    setpic();
});

function setpic() {
    $("#setbgyes").click(function() {
        var t=$("#color-background").val();
        var u=this.style.backgroundImage.replace("_thumb","");
        $("body").css("background",t+" "+ u);
        $("#user-background-repeat").attr("checked", true);
        $("#newbgurl").val(document.getElementById("setbgyes").style.backgroundImage.replace(webaddr,"").replace("url(","").replace(")","").replace("/themebg_thumb.jpg","").replace('"','').replace('"',''));
        closealert();
    });
    $("#setbgno").click(function() {
        $("body").css("background",$("#color-background").val());
        $("#newbgurl").val("");
        closealert();
    });
}

function usertheme(obj) {
    var ele= obj.split(",");
    $("#color-background").val(ele[0]);
    $("#color-background").css("background-color",ele[0]);
    $("#color-text").val(ele[1]);
    $("#color-text").css("background-color",ele[1]);
    $("#color-links").val(ele[2]);
    $("#color-links").css("background-color",ele[2]);
    $("#color-sidebar").val(ele[3]);
    $("#color-sidebar").css("background-color",ele[3]);
    $("#color-sidebox").val(ele[4]);
    $("#color-sidebox").css("background-color",ele[4]);

    $("body").css("backgroundColor",ele[0]);
    $("body").css("color",ele[1]);
    $("a").css("color",ele[2]);
    $("#sidebar").css("background",ele[3]);
    $("#sidebar").css("borderColor",ele[4]);

    if (ele[5]==1) {
        $("#themeimages").html('<a href="javascript:void(0);" id="setbgyes" style=""></a><a href="javascript:void(0);" class="nobg" id="setbgno"><img src="'+webaddr+'/images/default/theme-nobg.gif" alt="">&nbsp;<span>不要背景图片</span></a><p><label for="user-background-repeat"><input id="user-background-repeat" onclick="repeatclick()" name="pictype" type="radio" value="repeat"> 平铺背景图片</label>&nbsp;&nbsp;<label for="user-background-center"><input id="user-background-center" onclick="centerclick()" name="pictype" type="radio" value="center"> 背景居中</label>&nbsp;&nbsp;<label for="user-background-left"><input id="user-background-left" onclick="leftclick()" name="pictype" type="radio" value="left"> 左对齐</label></p>');
        setpic();
        $("#setbgyes").css("backgroundImage","url("+webaddr+"/attachments/usertemplates/"+ele[7]+"/themebg_thumb.jpg)");
        $("#user-background-"+ele[6]).attr("checked",true);
        if (ele[6]=="repeat") {
            $("body").css("background",ele[0]+" url("+webaddr+"/attachments/usertemplates/"+ele[7]+"/themebg.jpg) repeat scroll left top");
        } else if (ele[6]=="center"){
            $("body").css("background",ele[0]+" url("+webaddr+"/attachments/usertemplates/"+ele[7]+"/themebg.jpg) no-repeat scroll center top");
        } else if (ele[6]=="left"){
            $("body").css("background",ele[0]+" url("+webaddr+"/attachments/usertemplates/"+ele[7]+"/themebg.jpg) no-repeat scroll left top");
        }
        $("#newbgurl").val("attachments/usertemplates/"+ele[7]);
    } else {
        $("body").css("background",ele[0]);
        $("#color-background").val(ele[0]);
        $("#themeimages").html("");
        $("#newbgurl").val("");
    }
    closealert();
}

function repeatclick() {
    var t=$("#color-background").val();
    var u=document.getElementById("setbgyes").style.backgroundImage.replace("_thumb","");
    $("body").css("background",t+" "+ u +" repeat scroll left top");
    $("#newbgurl").val($("#setbgyes").style.backgroundImage.replace(webaddr,"").replace("url(","").replace(")","").replace("/themebg_thumb.jpg","").replace('"','').replace('"',''));
    closealert();
}

function centerclick() {
    var t=$("#color-background").val();
    var u=document.getElementById("setbgyes").style.backgroundImage.replace("_thumb","");
    $("body").css("background",t+" "+ u +" no-repeat scroll center top");
    $("#newbgurl").val($("#setbgyes").style.backgroundImage.replace(webaddr,"").replace("url(","").replace(")","").replace("/themebg_thumb.jpg","").replace('"','').replace('"',''));
    closealert();
}

function leftclick() {
    var t=$("#color-background").val();
    var u=document.getElementById("setbgyes").style.backgroundImage.replace("_thumb","");
    $("body").css("background",t+" "+ u +" no-repeat scroll left top");
    $("#newbgurl").val($("#setbgyes").style.backgroundImage.replace(webaddr,"").replace("url(","").replace(")","").replace("/themebg_thumb.jpg","").replace('"','').replace('"',''));
    closealert();
}

function closealert() {
    top.window.onbeforeunload = function(){return "如果确定要离开本页，那么你将丢失当前的操作！";}
}