$(document).ready(function(){
    var a={};$(".followpreview").mouseover(function(){
        var h=$(this);var b=h.attr("id"),d=h.offset().left,j=h.offset().top+h.height(),g="";var e=$("body").width();
        if(e-d<210){d=d-186;g="followerPreviewBoxArrRight"}else{g="followerPreviewBoxArrLeft";}
        a[b]=window.setTimeout(function(){
            var l="Box"+b;var k=b.replace("fu","");
            if(document.getElementById(l)==null){
                $("body").append('<div class="followerPreviewBox" id="'+l+'"></div>');
                $("#"+l).css({left:d,top:j}).fadeIn(500);
                $.ajax({type: "GET",url:  webaddr+"/source/ajax.php?act=getuserinfo&uid="+k+"&class="+g+"&rank="+GetRandomNum(1,999999),success: function(msg){$("#"+l).html(msg).css("backgroundImage","none");}});
            }else{$("#"+l).fadeIn(500)}},500);function c(){var l=$(this).attr("id");window.clearTimeout(a[l]);var k="Box"+l;$("#"+k).fadeOut(500)}}
         ).mouseout(function(){var c=$(this).attr("id");window.clearTimeout(a[c]);var b="Box"+c;$("#"+b).hide()})});