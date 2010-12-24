<?php if (!class_exists('template')) die('Access Denied');$template->getInstance()->check('style.css.htm', '8d88b201d9d9c343bf3bc05dfaddec7f', 1292553288);?>
/*
<style type="text/css">
*/
* { margin:0; padding:0;}
body { font:12px/1.75 Tahoma,Arial;background: #acdae5 url(<?php echo $webaddr?>/images/default/bg.jpg) no-repeat 0 0; color:#333; line-height:180%;}
img {border:0; vertical-align:middle;}
* html #header h1 a{
    background: none;
    filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled='true', sizingMethod='corp', src='<?php echo $webaddr?>/images/default/logo.png');
}
.as h3{font-weight:bold;padding-bottom:10px;border-bottom:1px solid #cccccc;color:#222;}
.inlinebutton{height:23px;padding:0 .5em;border:1px solid;border-color:#ccc #999 #999 #ccc;cursor:pointer;}
.whitebg{background:#ffffff}
.faq{background:#ffffff;padding:20px}
.web{background:#ffffff;padding:100px 0 100px 0;text-align:center}
.fleft { float: left; }
.fright { float: right; }
/* 提示 */
.new-msg-tips{ position:absolute;width:115px;height:50px;margin:10px auto auto 15px;background:url(<?php echo $webaddr?>/images/default/new-msg-tips.png) no-repeat;_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=image, src=<?php echo $webaddr?>/images/default/new-msg-tips.png);_background-image: none;}
.new-msg-tips2{position: absolute; margin-top: 38px; margin-left: 30px; line-height: 1.3em;color:#000000}
/* index */
.imgList{ padding-left:10px; _padding-left:2px; padding-top:10px;height:100px;_height:113px;*height:117px;}
.imgList li{float:left;width:90px; height:90px; border:1px solid #E7F9FB; padding:4px; margin:0 2px;_margin:0 2px; position:relative;list-style:none;}
.imgList li.on{ background:#fff; border:1px solid #8CC87D;}
.imgList li img{border:1px solid #fff;width:88px; height:88px; cursor:pointer;}
.imgList li p.pbg{ position:absolute; bottom:5px; right:5px; background:#000; height:20px; text-align:center; color:#fff; line-height:20px;width:88px; background:#000;filter:alpha(opacity=70);  -moz-opacity:0.7; opacity:0.7;}
.imgList li p.pbg2{position:absolute; bottom:5px;right:5px;background:#000; height:20px; text-align:center; color:#fff; line-height:20px;width:88px;background:#339900;}

/* keywords */
.keywordbox {background:#ffffff;padding:20px;}
.keywordbox .info {background:#b6d8ff;border:1px solid #006de8;width:750px;margin-left:80px;padding:10px;margin-top:20px}
.keywordbox .keys {background:#b6d8ff;border:1px solid #006de8;width:750px;margin-left:80px;padding:10px;margin-top:20px;margin-bottom:20px}
.keywordbox .keys .keylist{width:180px;float:left}

#indexpage {float:left;margin:10px 0;background:url(<?php echo $webaddr?>/images/default/pagebg.gif) repeat-x;border:1px solid #e1e1e1;width:97%;height:26px;padding:5px;text-align:center;cursor:pointer;}
/* 反馈 */
#feedbackbutton{
	display:block;
	width:25px;
	height:70px;
	top:200px;
	position:fixed; *position:fixed !important; *position:absolute;
	right:0px;
	background:url(<?php echo $webaddr?>/images/default/feedback.gif) 0px 0px no-repeat;
}
* html #feedbackbutton{position: absolute;top: expression(offsetParent.scrollTop+document.documentElement.clientHeight-this.offsetHeight-200);}
#feedbackbutton:hover{
    width:28px;
}
/* 举报 */
#reportbutton{
	display:block;
	width:25px;
	height:70px;
	top:280px;
	position:fixed; *position:fixed !important; *position:absolute;
	right:0px;
	background:url(<?php echo $webaddr?>/images/default/jubao.gif) 0px 0px no-repeat;
}
* html #reportbutton{position: absolute;top: expression(offsetParent.scrollTop+document.documentElement.clientHeight-this.offsetHeight-280);}
#reportbutton:hover{
    width:28px;
}

#newshow {border-bottom:1px solid #ffa200;background:#ffe5b8;text-align:center;padding:5px;width:98%;height:20px;color:#000000;margin-top:5px}

/* sendbox */
.sendsp {color:#aaaaaa;font-size:12px;margin-right:5px}
.sendsp #nums {font-family:Georgia,Tahoma,Arial;font-size:16px}

/* toolbar */
#toolbar { background: #efefef; width: 96%; border: #ccc 1px solid; border-bottom-width: 0; position: fixed; left: 50%; bottom: 0; margin-left: -48%; color: #666; z-index: 999; }
.toolbarShow { border: #fff 1px solid; border-bottom-width: 0; height: 27px; }
.toolbarShow a { color: #666; }
.toolbarShow a:hover {color: #666; text-decoration:none;}
.userQLink a, .userStatus a { float: left; height: 22px; padding: 4px 15px 0 30px; border-left: #ccc 1px solid; position: relative; }
.userQLink a { border: 0; border-right: #ccc 1px solid; }
#toolbarmin { background: #efefef; width: 123px; border: #ccc 1px solid; border-bottom-width: 0; position: fixed; right: 50%; bottom: 0; margin-right: -48%; color: #666; z-index: 999; }
.toolbarShowmin { border: #fff 1px solid; border-bottom-width: 0; height: 27px; }
.toolbarShowmin a { color: #666; }
.toolbarShowmin a:hover {color: #666; text-decoration:none;}
.userStatusmin { float: right; }
.userStatusmin a { float: left; height: 22px; padding: 4px 10px 0 25px; position: relative; }
#homelogin{background:url(<?php echo $webaddr?>/images/homelogin.png) no-repeat 0;height:98px;margin-bottom:10px}
/* talk list */
h2 { font-size:16px;}
h3 { font-size:14px;}
a { color:#06c;text-decoration:none;}
a:hover {text-decoration:underline;}
a:hover .label { border-bottom:1px solid #06c;}
.method { margin-left:.5em;}
.setgray {color:#999999;margin-left:10px}
.headgray {color:#E0E0E0}
.followtime {color:#999999}
.imgborder {border:#CBCBCB solid 1px;padding:1px;}
.top5 {margin-top:5px}
.top10 {margin-top:10px}
.top20 {margin-top:20px}
.topbottom20 {margin:20px 0 20px 0}
.padding20 {padding:20px}
.inviteareatextemail {height:60px;width:630px;}
.inviteareatextmsg {COLOR: #999; font-size: 12px; height:60px; width:630px}
.badgebox {border:1px solid #cccccc;padding:10px;width:95%;margin:auto;background:#eeeeee;margin-top:10px;margin-bottom:10px}
.badgeflash {border:1px solid #cccccc;padding:5px;width:290px;background:#eeeeee;}
.badgeflashareatext {width:280px;height:200px;color:#808080}
.badgepic {border:1px solid #cccccc;padding:5px;width:95%;background:#eeeeee;}
.badgepicareatext {width:660px;height:30px;color:#808080}
.mailauthbox {border:1px solid #cccccc;padding:10px;width:58%;margin:auto;background:#eeeeee}
.file_input {font-size:14px; color:#666; border:1px solid; border-color:#7C7C7C #C3C3C3 #DDDDDD #C3C3C3;}
.tip{background-color:#ffffa3;border:solid 1px #E8D249;margin-bottom:10px;padding:7px;position:absolute;z-index:999;margin:5px}
.resetbottom{margin:30px 50px 0;padding:30px 0 30px 155px;border-top:1px solid #ccc;font-size:14px;}
.quote { margin: 0.5em 0; padding-left: 20px; background: url(<?php echo $webaddr?>/images/q_start.gif) no-repeat 0 0; overflow: hidden; zoom: 1; }
.quote .q, .quote blockquote { margin: 0; padding: 0 20px 0 0; background: url(<?php echo $webaddr?>/images/q_end.gif) no-repeat right bottom; color: #666; display: inline-block; }
.media{ margin-top:5px}
.linkbg { margin-top:10px;padding: 10px; border: 1px solid #EBE6C9; background: #FCF9E6 none repeat scroll 0 0; font-size: 12px; }
#viewbox {margin:10px;}
.photoimg {width:134px;margin:18px;float:left;text-align:center;border:1px #cccccc solid;padding:4px;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;}
.photoimgimg {width:130px;border:1px #cccccc solid;}
.h_postimg{cursor:url(<?php echo $webaddr?>/images/default/zoomin.cur), pointer;border:1px #cccccc solid;padding:3px;margin:4px 0 4px 0;max-width:90px;width:expression(width > 90 ? "90px" : true);overflow:hidden;}
.ubblink{font-size:12px;}

/* menu */
.popupmenu_popup { text-align: left; line-height: 1.4em; padding: 10px; overflow: hidden; border: 1px solid #CAD9EA; background: #FFF; background-repeat: repeat-x; background-position: 0 1px;  }
.headermenu_popup { width: 83px; }
.headermenu_popup li { float: left; width: 7em; line-height: 24px; height: 24px; overflow: hidden; border-bottom: 1px solid #E8E8E8; }
.headermenu_popup li a {font:normal 12px Verdana, Arial, Helvetica, sans-serif;margin-left:auto; margin-right:auto;background-color: #ffffff;text-decoration:none;}
.headermenu_popup li a:hover {color:#F87A01;}
.ads1,.ads2 {text-align:center;width:975px}
.ads1 img ,.ads2 img {width: expression(this.width > 975 ? '975px': true); max-width: 975px; }
.ads3,.ads4 {text-align:center;width:200px}
.ads3 img ,.ads4 img {width: expression(this.width > 200 ? '200px': true); max-width: 200px; }

/* button */
a.bh, a.bl, a.bl-long { float:left; display:inline-block; display:-moz-inline-stack; width:80px; height:20px; *height:18px; *padding-top:2px; line-height:20px; *line-height:18px; text-align:center; letter-spacing:1px; text-indent:1px; text-decoration:none; overflow:hidden; vertical-align:middle; *zoom:1;}
a.bh { background:url(<?php echo $webaddr?>/images/default/button-h.gif) no-repeat 0 0; color:#994800;}
a.bh:hover { background:url(<?php echo $webaddr?>/images/default/button-on.gif) no-repeat 0 0; color:#994800;}
a.bl { background:url(<?php echo $webaddr?>/images/default/button-l.gif) no-repeat 0 0; color:#333;}
a.bl:hover { background:url(<?php echo $webaddr?>/images/default/button-on.gif) no-repeat 0 0; color:#333;}

/* 表单开始 */
/* elements */
.input_text, textarea { border:1px solid; border-color:#7c7c7c #c3c3c3 #ddd; font-size:12px; line-height:120%;}
input, button { font-size:12px; vertical-align:middle;}
.input_text { height:15px; padding:3px 4px; line-height:15px;}
input.formbutton { height:23px; padding:0 10px; border:1px solid; border-color:#66acff #094fa1 #094fa1 #66acff; background:#2680e9; color:#fff; letter-spacing:0.3em; cursor:pointer;}
button.formbutton { height:23px; padding:0 10px; border:1px solid; border-color:#66acff #094fa1 #094fa1 #66acff; background:#2680e9; color:#fff; letter-spacing:0.3em; cursor:pointer; line-height:23px;}
.formbutton:focus { border-color:#000;}
select { padding:2px 2px 2px 0; height:21px; border:1px solid #B3B3B3}
option { padding:0 2px;}
textarea { padding:4px; overflow:auto;}
form p, .finder_block p { margin:10px 0; line-height:23px;}
input,textarea,select {-webkit-border-radius:5px;-moz-border-radius:5px;}
input.input_text,textarea.input_text {border:1px solid #B3B3B3;padding:5px}

/* vf for vertical forms */
.vf { width:300px; margin:0 auto;}
.vf label { font-weight:bold;}
.vf .label_input { display:block; float:none; text-align:left;}
.vf textarea { width:290px;}
.vf span.formtip { padding:0 .2em; color:#aaa;}
.vf .captcha-img { padding-left:0;}

/* lf for large forms */
.lf p { line-height:26px;}
.lf label.label_input { font-size:14px; font-weight:normal;}
.lf label.label_check { font-weight:normal;}
.lf input.input_text { width:280px; height:18px; color:#444; font-size:14px; font-weight:bold; line-height:18px;}
.lf p.act a { font-weight:bold;}
.lf p.err { color:red;}
.lf span.url { font-size:13px;}
.lf input#url { width:12em;}
/* 表单结束 */

/* 模板设置 */
.settings-theme{*zoom:1;}
.settings-theme:after{content:".";display:block;font-size:0;line-height:0;clear:both;visibility:hidden;}
.settings-theme #sidebar{float:right;width:220px;padding-bottom:5em;overflow:hidden;}
.settings-theme #sidebar h3{font-weight:bold;margin-bottom:1em;}
.settings-theme #sidebar h4{margin:3em 0 0;}
.settings-theme #sidebar #user_infos{width:172px;}
#form-setting-theme{float:left;width:500px;margin-left:10px;_display:inline;;}
#form-setting-theme h3{padding:10px 10px 6px;background:#fff url(<?php echo $webaddr?>/images/default/theme-titlebg.gif) repeat-x scroll 0 0;border:1px solid #eee;}
#form-setting-theme h3.title{width:auto;border-bottom:none;}
#tab-bg{float:left;width:220px;margin-top:1em;color:#06c;cursor:pointer;}
#tab-color{float:left;width:220px;margin-left:16px;margin-top:1em;color:#06c;cursor:pointer;}
#form-setting-theme h3.current{border-bottom:1px solid #fff;color:#222;}
.settings-theme .list{*height:1%;padding:5px 1px 1px 9px;*padding-bottom:10px;border:1px solid #eee;border-top:none;}
.settings-theme .list:after{content:".";display:block;font-size:0;line-height:0;clear:both;visibility:hidden;}
.settings-theme .list a{display:block;_display:inline;float:left;width:112px;height:72px;margin:0 8px 9px 0;border:1px solid #fff;}
.settings-theme .list a img{display:block;}
.settings-theme .list a.current{border:1px solid #333;}
.settings-theme .list a.hover{border:1px solid #999;}
.settings-theme .background{clear:both;padding:10px;border:1px solid #eee;}
.settings-theme .color{clear:both;padding:10px;border:1px solid #eee;}
.settings-theme .upload{padding:10px;background-color:#f3f3f3;}
.settings-theme .tip{display:block;margin-top:.5em;color:#666;}
.settings-theme .images{color:#666;}
.settings-theme .images a{display:block;_display:inline;float:left;width:112px;height:72px;margin:10px 10px 10px 0;background-color:#fff;background-repeat:no-repeat;background-position:0 0;border:1px solid #ccc;}
.settings-theme .images a.nobg:hover{background-color:#fff;border:1px solid #666;}
.settings-theme .images span{color:#333;}
.settings-theme .images a.nobg{width:102px;height:47px;padding:25px 0 0 10px;text-decoration:none;}
.settings-theme .images p{clear:left;margin:0;}
.settings-theme .picker{position:relative;z-index:1;float:right;top:0;right:0;padding:0;width:220px;height:190px;}
.settings-theme .inputs{float:left;width:250px;height:180px;}
.settings-theme .inputs label{display:block;_display:inline;float:left;width:90px;margin:0 5px 5px 0;color:#999;}
.settings-theme .inputs input{display:block;_display:inline;float:left;width:90px;margin:0 10px 10px 0;padding:5px 10px;text-transform:uppercase;border:1px solid #fff;}
.settings-theme p.act{width:500px;float:left;*float:none;margin-left:0;text-align:center;}
.settings-theme .show{margin-bottom:-1px;}

/* MODULE BLOCKS */
#container { width:975px; margin:0 auto;margin-bottom:30px}
/*#main { width:535px; overflow:hidden;}*/

/* header */
#header{position:relative;width:100%;padding:1em 0 1.25em;}
#header a{text-decoration:none;}
#header h1{float:left;width:168px;height:42px}
#header h1 a{display:block;_background:url(<?php echo $webaddr?>/images/default/logo.png) no-repeat 0 0;_zoom:1;}
#header h1 a:hover{background-color:transparent;text-decoration:underline}
#header h1 a img{_visibility:hidden;}
#header h1 a span{display:none;}

#navigation {width:975px;margin:0 auto;height:35px;background:url(<?php echo $webaddr?>/images/default/headbg.png) no-repeat;}
* html #navigation {_filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(enabled=true, sizingMethod=image, src=<?php echo $webaddr?>/images/default/headbg.png);_background-image:none;}
#navigationT {width:975px;margin:0 auto;height:35px;margin-top:-35px}
#navigationT ul { list-style:none;padding:8px;}
#navigationT li { float:left;margin-left:3px;color:#cccccc;}
#navigationT li a { color:#ffffff;padding:2px 7px; *padding:3px 7px 1px;}
#navigationT li a:hover { background:#06c;color:#ffffff }
#navigationT .selected a { background:#06c;color:#ffffff }
#searchr { width:150px;margin-top:-3px}
#searchr form { right:3px; width:150px; height:26px; background:url(<?php echo $webaddr?>/images/default/searchr-input.png) 0 0 no-repeat;}
#searchr-input { float:left; width:105px; height:18px; padding:4px 0; border:0; background:transparent; font-size:14px; line-height:18px; text-indent:5px;}
#searchr-submit { float:left; width:45px; height:26px; border:0; background:url(<?php echo $webaddr?>/images/default/searchr-submit.png) 0 0 no-repeat; color:#555; font-size:14px; line-height:26px; text-align:center; cursor:pointer;}
#searchr-submit:focus { background-image:url(<?php echo $webaddr?>/images/default/searchr-submit-on.png);}
html>/**/body #searchr-submit, x:-moz-any-link, x:default { padding-bottom:3px;} /* Only FireFox 3 */

/* sidebar */
.hotbang li{background:url(<?php echo $webaddr?>/images/default/api.gif) no-repeat 0;padding-left:18px}
#sidebar { width:220px;*width:225px; padding:20px 0 20px 15px; border-left:1px solid #b2d1a3; background:#e2f2da; vertical-align:top}
#sidebar ul { list-style:none;}
#sidebar h2 { font-size:14px; margin-bottom:10px;}
#sidebar h3 { font-size:14px; font-weight:normal;}
#sidebar img{width: expression(this.width > 200 ? '200px': true); max-width: 200px;}
#sidebar a { text-decoration:none;}
#sidebar a:hover { background:transparent; color:#06c; text-decoration:underline;}
#sidebar p { margin:5px 0;}
#sidebar textarea { width:195px; height:2.4em; overflow-y:hidden;}
#sidebar .sect { position:relative; margin:1em 0 1em -15px; padding:1em 8px 1em 15px; border-top:1px solid #b2d1a3;}
#sidebar .first-sect { margin-top:0; padding-top:0; border:0;}
#sidebar .stabs { position:relative; margin-left:-16px; margin-bottom:15px; font-size:14px; *zoom:1;}
#sidebar .stabs ul { list-style:none; border-top:1px solid #b2d1a3;}
#sidebar .stabs li { margin-left:1px; border-bottom:1px solid #b2d1a3; line-height:45px; _zoom:1;}
#sidebar .stabs li.current { margin-left:0; background:#fff;}
#sidebar .stabs li.loading {background:url(<?php echo $webaddr?>/images/spinner.gif) no-repeat 200px 15px;}
#sidebar .stabs li a { display:block; padding-left:16px; font-weight:bold; _zoom:1;}
#sidebar .stabs li a:hover { background:url(<?php echo $webaddr?>/images/default/pale.png); _background:#fff; text-decoration:none;}
#sidebar .stabs li.current a:hover { background:#fff;}
#sidebar .stabs li a .count { margin-left:.5em; font-family:"Times New Roman", Times, serif;}
#sidebar .tlist li { margin-bottom:.5em;background:url(<?php echo $webaddr?>/images/default/hotbg.gif) no-repeat ;text-indent:18px;}
#sidebar .tlist li img { width: expression(this.width > 200 ? '200px': true); max-width: 200px;}
#sidebar .more { position:absolute; top:10px; right:15px; *line-height:120%;}
#sidebar form#login p { margin:10px 0;}
#sidebar form#login .label_input { display:block; color:#444;}
#sidebar form#login .label_check { color:#444; cursor:pointer;}
#sidebar form#login .input_text { width:191px;}
#sidebar form#login #forgot { float:right; padding-right:10px;}
#sidebar #register p { margin:10px 0; text-align:center;}
#sidebar form#login p.captcha-img { margin-left:50px; _margin-left:52px;}
#sidebar .rssfeed a{ margin:10px 0 0; padding-left:20px; background:url(<?php echo $webaddr?>/images/default/feed-icon.png) 0 50% no-repeat;}

/* sidebar - user */
#user_stats { width:216px; margin-bottom:15px; overflow:hidden; *zoom:1;}
#user_stats:after { content:"."; display:block; font-size:0; line-height:0; clear:both; visibility:hidden;}
#user_stats li { float:left; width:60px; margin:0 8px 0 -10px; padding:0 4px 0 9px; border-left:1px solid #b2d1a3;}
#user_stats a { display:block; width:60px; padding-bottom:1px;}
#user_stats a:hover { text-decoration:none;}
#user_stats .count { display:block; font-size:20px; font-family:"Times New Roman", Times, serif; font-weight:bold;}

/* footer */
#footer {background:#0991be;padding:5px;text-align:center;color:#ffffff}
#footer p { display:inline; margin-right:4em; color:#ffffff;}
#footer a { margin:0 .25em; text-decoration:none;color:#ffffff}

/* tabs */
.tabs { position:relative; margin-bottom:5px; border-bottom:1px solid #acdae5; *zoom:1;}
#body .tabs { margin-bottom:15px;}
.tabs:after { content:"."; display:block; font-size:0; line-height:0; clear:both; visibility:hidden;}
.tabs a.crumb { position:absolute; top:10px; right:10px; padding:0 .5em; font-size:12px;}
.tabs ul { position:relative; list-style:none; margin-bottom:-1px; font-size:14px; text-align:center;}
@media screen and (-webkit-min-device-pixel-ratio:0){.tabs ul { margin-bottom:-2px;}}
.tabs li { display:inline; margin-right:2px;}
.tabs li a { display:inline-block; height:21px; margin:5px 0 0; padding:1px 12px 0; background:#acdae5; border:1px solid #acdae5; color:#222; text-decoration:none; line-height:21px; vertical-align:bottom;}
.tabs li a:hover { background:#fff; color:#ff7031;}
.tabs li.current a { margin:0; padding:4px 12px 2px; border-bottom:1px solid #fff; background:#fff;}

#stream h3 { padding:5px; color:#444; font-size:14px; border-bottom:1px dashed #ddd;}
#stream .title {padding:5px; color:#444; border-bottom:1px dashed #ddd;}
#stream ol {list-style:none; *zoom:1;}
#stream li.unlight,#stream li.light {padding:9px 10px 10px 5px;border-bottom:1px dashed #ddd;overflow:hidden;overflow-x:hidden;-o-text-overflow:ellipsis;}
#stream li a.avatar { float:left; margin-left:-59px; overflow:hidden;}
#stream li a.name { font-weight:bold;}
#stream li div.content {white-space:normal; word-wrap:break-word;width:630px;_overflow: hidden;}
#stream li div.contentl {white-space:normal; word-wrap:break-word;width:690px;_overflow: hidden;}
#stream .wa li.unlight,#stream .wa li.light{padding:9px 5px 10px 62px;overflow:hidden;}
#stream li:after, #stream .wa li:after { content:"."; display:block; font-size:0; line-height:0; clear:both; visibility:hidden;}
#stream li, #stream .wa li { *zoom:1; word-break:break-all; min-height:28px;}
#stream li span.avatar { float:left; margin-left:-55px; overflow:hidden;}
#stream.message li a.avatar img { display:block; width:48px; height:48px;}
#stream.message li a.author { float:left; _float:none; margin-right:.5em;}
#stream.search li dl strong, #stream.message li .content strong { color:red; font-weight:normal; }
#stream.search li dt { margin:.2em 0; font-weight:bold;}
#stream.search li dd { margin:.15em 0; font-size:12px;}
#stream.search li dd label { float:left; width:5em;}
#stream li.unlight {font-size:14px;background:#ffffff}
#stream li.light {font-size:14px;background:#f5f5f5}
#stream li.unlight span.op { visibility:hidden;}
#stream li.light span.op { visibility:visible;}

.stamp { color:#999; font-size:12px; _zoom:1;}
.stamp a {color:#999; text-decoration:none; line-height:1em;}
.stamp a:hover { background:transparent; color:#06c;border-bottom:#339900 1px dotted;}
.light .stamp a { color:#06c; border:0;}
.light .stamp a:hover { text-decoration:none;border-bottom:#339900 1px dotted;}
.unlight .stamp a { border:0;}

span.op a{font-size:12px;color:#999;text-decoration:none;}
span.op a:hover{background-color:transparent;text-decoration:underline;}

a.zhuanfa{display:inline-block;display:-moz-inline-stack;width:40px;height:16px;overflow:hidden;background:url(<?php echo $webaddr?>/images/default/msgicons.gif) 0 0 no-repeat;font-size:0!important;line-height:0;text-indent:-999em;vertical-align:middle;*zoom:1;}
span.op a.zhuanfa:hover{background-position:-40px 0px;}

span.op a.share{display:inline-block;display:-moz-inline-stack;width:40px;height:16px;overflow:hidden;background:url(<?php echo $webaddr?>/images/default/msgicons.gif) 0 -16px no-repeat;font-size:0!important;line-height:0;text-indent:-999em;vertical-align:middle;*zoom:1;}
span.op a.share:hover{background-position:-40px -16px;}

span.op a.delete{display:inline-block;display:-moz-inline-stack;width:40px;height:16px;overflow:hidden;background:url(<?php echo $webaddr?>/images/default/msgicons.gif) 0 -32px no-repeat;font-size:0!important;line-height:0;text-indent:-999em;vertical-align:middle;*zoom:1;}
span.op a.delete:hover{background-position:-40px -32px;}

span.op a.reply{display:inline-block;display:-moz-inline-stack;width:40px;height:16px;overflow:hidden;background:url(<?php echo $webaddr?>/images/default/msgicons.gif) 0 -48px no-repeat;font-size:0!important;line-height:0;text-indent:-999em;vertical-align:middle;*zoom:1;}
span.op a.reply:hover{background-position:-40px -48px;}

span a.fav{display:inline-block;display:-moz-inline-stack;width:16px;height:16px;overflow:hidden;background:url(<?php echo $webaddr?>/images/default/icon-fav2.gif) no-repeat;font-size:0!important;line-height:0;text-indent:-999em;vertical-align:middle;*zoom:1;margin-bottom:1px}
span a.fav:hover{background:url(<?php echo $webaddr?>/images/default/icon-fav1.gif) no-repeat;border-bottom:0;}
/* avatar list big */
.alist { list-style:none;}
.alist li { float:left; margin:0 3px 3px 0;}
.alist:after { content:"."; display:block; font-size:0; line-height:0; clear:both; visibility:hidden;}
.alist li a { float:left; width:48px; height:72px; overflow:hidden; text-decoration:none;}
.alist li a img { display:block;height:48px;}
.alist li a span { display:block; text-align:center; line-height:175%; white-space:nowrap;}
.alist { *zoom:1;}

/* avatar list small */
.alistsmall { list-style:none;}
.alistsmall li { float:left; margin:0 3px 3px 0;}
.alistsmall:after { content:"."; display:block; font-size:0; line-height:0; clear:both; visibility:hidden;}
.alistsmall li a { float:left; width:26px; height:26px; overflow:hidden; text-decoration:none;}
.alistsmall li a img { display:block;height:25px;}
.alistsmall { *zoom:1;}

/* page navigator & rss link */
.paginator { float:right; list-style:none; padding:20px 0 10px; white-space:nowrap;}
.paginator li { float:left; margin:0 3px;}
.paginator li.current { height:24px; margin:0 6px; font-weight:bold;font-size:16px; line-height:24px;}
p.rss { padding:20px 0 10px; white-space:nowrap;}
.paginator li a, p.rss a { float:left; height:22px; padding:0 6px; border:1px solid #ccc; text-decoration:none; line-height:22px;}
.paginator li a:hover, p.rss a:hover { text-decoration:underline;}
.paginatortop { float:left;margin:20px 0}

/* content */
#content { min-height:250px; _height:250px; padding:10px; border:1px solid #acdae5; background:#fff; *zoom:1;}
#content:after { content:"."; display:block; font-size:0; line-height:0; clear:both; visibility:hidden;}
#content.impact { padding:0;}
#content h2 { padding:5px 10px; border-bottom:1px solid #ccc; color:#444; font-size:15px;}
#content.impact h2 { padding:8px 15px;}

/* board */
#content .board { width:500px; margin:1em auto 2em; font-size:12px; line-height:150%;}
.narrowlook .board { width:600px; margin:0 auto; padding:1em 0 3em;}
.board h2 { margin:10px 0; border-bottom:1px solid #ccc; color:#444; font-size:16px; line-height:200%;}
#content .board p { margin:1em 0;}
.board ul { margin:1.75em 0; padding-left:2em; line-height:175%;}
#content .board ol { margin:1em 0; padding-left:2em;}
#content .board li { margin:.2em 0;}
#content .board a { font-weight:bold;}

/* user & (_message) */
#info { background:#ffffff;padding:20px}
#info #avatar { float:left; border:1px solid #999; background:#fff; overflow:hidden;}
#info #avatar img { display:block;_float:left; width:96px; height:96px;}
#infohead {background:url(<?php echo $webaddr?>/images/default/sendbg.png) repeat-x;padding:20px}
#infohead #avatar { float:left; border:1px solid #999; background:#fff; overflow:hidden;}
#infohead #avatar img {width:96px; height:96px;}
#panel { float:left;  margin:0 0 0 20px; }
#panel h1 { font-size:26px; line-height:30px;}
#panel p.state { color:gray;margin:5px 0;}
#panel p.actions { margin:10px 0; *zoom:1;}
#panel p.actions:after { content:"."; display:block; font-size:0; line-height:0; clear:both; visibility:hidden;}
#panel p.actions a { margin-right:.75em;}
#panel #relation { margin:8px 0 5px; color:#666;}
#panel #relation .actions { margin-left:2em;}
#panel #relation .actions a { margin-right:.5em; padding:1px 2px 2px; border:1px solid #fff; color:#bbb; text-decoration:none;}
#panel #relation .actions a:hover { border-color:#c99; background:#fdd; color:#c00;}
#latest { margin-left:115px;}
#latest h1 { padding:0 10px 8px; font-size:16px; line-height:120%;}
#latest h2 { padding:0 10px 20px; font-size:14px;}
#latest .stamp {right:10px; bottom:0; line-height:150%;}
.headbg{background:url(<?php echo $webaddr?>/images/default/sendbg.png) repeat-x;}

/* friends & followers*/
.actions { font-size:12px;}
#stream .actions { margin-top:10px; *zoom:1; }
.actions .bh,.actions .bl, .actions .bl-long { margin-right:0.75em;}
.actions .friend-deny,
.actions .friend-remove,
.actions .follower-remove { display:block; float:right; width:55px; height:20px; background-color:#eee; color:#666; text-decoration:none; text-align:center; }
.actions .open-notice, .actions .close-notice { display:block; float:right; width:140px; height:20px; margin-right:0.75em; background-color:#eee; text-decoration:none; text-align:center; }
.actions .close-notice { color:#666; }
.actions .friend-deny:hover,
.actions .friend-remove:hover,
.actions .follower-remove:hover,
.actions .close-notice:hover { background-color:#eee; color:#666; text-decoration:underline;}
.actions .open-notice:hover { background-color:#eee; }

.searchtopic {border-bottom:2px solid #e3eaec;margin-top:10px;height:20px;width:500px;padding:5px 0 5px 5px}
.homeupdatebox {border-bottom:2px solid #e3eaec;margin:10px 10px 0 20px;height:20px;width:695px;*width:690px;padding:5px 10px 5px 5px}
.myhome {background:url(<?php echo $webaddr?>/images/default/home.png) no-repeat;font-size:14px;font-weight:bold;padding-left:22px;float:left}
#homeupdate {float:right}
/* FUNCTION PAGES */
/* index */
#featured { position:relative; width:454px; padding:15px 20px 20px;}
#featured h2 { margin-bottom:15px; border-bottom:1px dashed #ddd; color:#444; line-height:2em;}
#featured .alist { margin-right:-10px;}
#featured .alist li { margin-right:10px;}
#featured .alist a { background:#fff; color:#06c;}
#featured .more { position:absolute; top:24px; right:20px; text-decoration:none;}

/* search */
#searchpanel { margin-bottom:1em; padding:0 1em .5em; border-bottom:1px solid #ddd;}
#searchpanel .input_text { width:25em;}
#search-switch { color:#aaa; font-size:14px;}
#search-switch strong { color:#666;}
#search-switch a { margin:.25em;}
#search-switch .current { color:#222; font-weight:bold; text-decoration:none; cursor:default;}
#search-switch .current:hover { background:transparent;}
#searchpanel .formbutton { *padding:.25em;}

/* new ui */
.newlook #header { float:none; *zoom:1;}
.newlook #header:after { content:"."; display:block; font-size:0; line-height:0; clear:both; visibility:hidden;}
.newlook #main { float:none;}
.newlook #mainhome { float:none;}
.newlook #content { padding:0; border:none; background:transparent;}

#columns { width:100%; border:0; border-collapse:collapse; border-spacing:0;}
td#main { width:705px; padding:20px 10px 20px 20px; border:0; background:#fff; vertical-align:top}
td#mainhome { width:735px;border:0; background:#fff; vertical-align:top}
.finder_block {margin:32px 80px; padding:16px 24px; border:1px solid #aaa; border-top-color:#ddd; border-left-color:#ddd; background:#f7f7f7; zoom:1;}
.finder_block h3 {font-size:14px;}
.finder_block p {margin-bottom:0;}
#finder_searchnick .input_text {width:385px; *width:370px; margin-right:5px;}
#contacts-form {width:500px; margin:0 auto;}
.contacts-box h3 {margin-bottom:.4em; color:#333; line-height:200%;}
.contacts-box .hd{border:1px solid #ccc; background:#eee; color:#333; line-height:200%;}
.contacts-box .hd input{margin:0 .5em;}
.contacts-box .bd{height:300px; border:1px solid #ccc; border-top:0; overflow:auto;}
.contacts-box .bd table{width:100%; *width:95%; border-collapse:collapse;}
.contacts-box .bd td{vertical-align:middle; cursor:pointer;}
.contacts-box .bd td.checkbox{width:20px;}
.contacts-box .bd td.checkbox input{margin:0 .5em;}
.contacts-box td{padding:5px 0;border-bottom:1px solid #eee;}
.contacts-box td.image{width:48px;padding-right:6px;}
.contacts-box td.info{color:#333;}
.contacts-box td.info h4{font-size:14px;}
.contacts-box td.info p{margin:0;}
.contacts-box td.network{width:5em;color:#666;}
.contacts-box tr.alt {background:#f3f3f3;}
#extranote {width:490px; height:50px;}
p.nc { border:dashed #ddd; border-width:1px 0; margin:1em 0; padding:2em 0; font-size:16px; text-indent:5em;}
.solo { border-top:1px dashed #ddd;}

/* friends */
.friends {background:#ffffff ;padding:20px 25px 10px;}
.friends h2 { margin:5px 0 0; padding:0 5px; border-bottom:1px dashed #ddd; color:#666; font-size:14px; line-height:200%;}

/* reply */
.status_reply_list{
    width:630px; 
    margin-left:0px; 
    font-size:12px; 
    margin-top:5px;
}
.status_reply_list .arrow{
    background:transparent url("<?php echo $webaddr?>/images/default/cmt_arrow.gif") no-repeat scroll 30px 0;
    height:9px;
    overflow:hidden;
    position:relative;
    width:630px;
}
.status_reply_list .top {
    background:transparent url("<?php echo $webaddr?>/images/default/cmt_top.gif") no-repeat scroll left top;
    clear:both;
    height:4px;
    margin-top:-2px;
    overflow:hidden;
}
.status_reply_list  .cont {
    background:transparent url("<?php echo $webaddr?>/images/default/cmt_mid.gif") repeat-y scroll left top;
    clear:both;
    overflow:auto;
    padding:0 20px;
}
.status_reply_list  .bottom {
    background:transparent url("<?php echo $webaddr?>/images/default/cmt_bot.gif") no-repeat scroll left top;
    clear:both;
    height:4px;
    overflow:hidden;
}
.status_reply_list h1{
    font-size:12px;
    color:#999999;
    line-height:20px;
    padding-bottom:8px;
    font-weight:normal;
}
.status_reply_list .line {
    background:transparent url("<?php echo $webaddr?>/images/default/cmt_border2.gif") repeat-x scroll left bottom;
}
.clearline {
	display:block;
	height:0;
	line-height:0;
	font-size:0;
	overflow:hidden;
	clear:both;
}
.lire {font-size:12px}
.reply_list_ul li{
    padding:5px;
    overflow:hidden;
    list-style:none;
    border-bottom:1px dashed #ddd;
}
.reply_list_ul li .images{
    float:left;
    overflow:hidden;
    width:38px;
}
.reply_list_ul li .info{
    word-wrap:break-word;
    float:left;
    width:330px;
    line-height:16px;
}
.reply_list_ul li p{ margin:0px; }
.replyspan {
    clear:right;
    display:block;
}
.replyajaxbox { word-wrap:break-word;width:390px }
.viewcontent { word-wrap:break-word;width:750px }
.viewbox {border:1px solid #dadada;background:#f8f8f8;padding:10px;min-height:80px;height:80px}
div[class].viewbox {height: auto;}	
/* 弹框 */
#ye_dialog_overlay {position:fixed;top:0;left:0;height:100%;width:100%;background-color:#000;filter:alpha(opacity=25);-moz-opacity: 0.25;opacity: 0.25;z-index:1000; display:none;}
* html #ye_dialog_overlay {position:absolute;margin:0 auto;height:expression(offsetParent.scrollTop+document.documentElement.clientHeight)}
#ye_dialog_loading {background:#fff url(<?php echo $webaddr?>/images/default/loading.gif) no-repeat 1px 1px;width:34px;height:34px;position:fixed;top:50%;left:50%;margin:-32px 0 0 -32px;z-index:1001; display:none;}
#ye_dialog_window{background-color:#fff;z-index:1002;position:fixed;top:50%;left:50%;border:1px solid #789fa6;width:300px;height:150px; display:none;
-webkit-border-radius:0px;-moz-border-radius:0px;padding-bottom:8px;}
* html #ye_dialog_window{position:absolute;top:expression((offsetParent.scrollTop+document.documentElement.clientHeight-this.offsetHeight)/2);}
#ye_dialog_window_w {position:relative;left:-3px;top:-3px;}
#ye_dialog_title {background:url(<?php echo $webaddr?>/images/default/pagebg.gif) repeat-x;height:36px; line-height:25px;padding:5px 10px;font-size:14px;color:#333;font-weight:bold; text-align:left}
#ye_dialog_body {width:100%;}
#ye_dialog_iframe {width:100%;height:100%;border:0 none;}
#ye_dialog_close {position:absolute; width:13px; height:13px;display:block; color:#000; right:9px; top:12px; text-decoration:none; background:url(<?php echo $webaddr?>/images/default/close.gif) no-repeat;}
#ye_dialog_close:hover{background-position:0 -12px;} 
.ye_msg_window {padding:0;position:fixed; top:50%; left:50%; z-index:1100; width:250px;}
* html .ye_msg_window {position:absolute;top:expression((offsetParent.scrollTop+document.documentElement.clientHeight-this.offsetHeight)/2); left:expression(document.documentElement.clientWidth/2);}
.ye_msg_wrap {padding:10px 20px;border:1px solid #666;background-color:#fff; font-size:14px;-webkit-border-radius:5px;-moz-border-radius:5px;text-align:left;}
.ye_msg_autoclose { height:20px; line-height:20px; color:#666; font-size:12px; text-align:left;}
.ye_msg_ico_1,.ye_msg_ico_2,.ye_msg_ico_3,.ye_msg_ico_4,
.ye_msg_ico_5 {background:#fff no-repeat 20px center;padding-left:90px;}
.ye_msg_ico_1 {background-image:url(<?php echo $webaddr?>/images/default/dialog_msgtype_ico_1.gif);}
.ye_msg_ico_2 {background-image:url(<?php echo $webaddr?>/images/default/dialog_msgtype_ico_2.gif);}
.ye_msg_ico_3 {background-image:url(<?php echo $webaddr?>/images/default/dialog_msgtype_ico_3.gif);}
.ye_msg_ico_4 {background-image:url(<?php echo $webaddr?>/images/default/dialog_msgtype_ico_4.gif);}
.ye_msg_ico_5 {background-image:url(<?php echo $webaddr?>/images/default/dialog_msgtype_ico_5.gif);}

/* head */
.sharephoto{background:url(<?php echo $webaddr?>/images/default/image.gif) no-repeat;padding-left:20px;height:20px;float:left;margin-top:5px;margin-left:5px}
.shares{background:url(<?php echo $webaddr?>/images/default/video.gif) no-repeat;padding:2px 0 0 30px;height:22px;}
.topics{background:url(<?php echo $webaddr?>/images/default/topic.gif) no-repeat;padding-left:20px;height:20px;float:left;margin-top:5px}
.hometip{font-size:18px;font-weight:bold}
.sendbutton {background:url(<?php echo $webaddr?>/images/default/send.png);width:101px;height:35px;line-height:35px;background-position:0 0;border-width:0;font-size:14px;cursor:pointer;}
.sendbutton:hover {background-position:0 -35px;}
.sendgray{color:#E0E0E0;font-size:16px;}
.headtextarea{width:630px;height:60px;margin-top:5px}
.sendbox{margin-top:5px;width:640px}
.sendbox .sendtip{float:left;margin-top:5px}

#uploadbox {float:left;font-size:12px}
.uploadbtn {margin-left:-30px;position:absolute;filter:alpha(opacity=0);opacity:0;cursor:pointer;}
#priviewbtn {display:none;color:#0066cc;cursor:pointer;}
#uploading {color:#999;display:none}
#priviewpoic {display:none;border:1px solid #ccc;padding:3px;position:absolute;background:#ffffff}

.adminico{padding:0 0 0 20px;background:url(<?php echo $webaddr?>/images/default/online_admin.gif) no-repeat;}
.uonlineico{padding:0 0 0 20px;background:url(<?php echo $webaddr?>/images/default/online_member.gif) no-repeat;}
.uofflineico{padding:0 0 0 20px;background:url(<?php echo $webaddr?>/images/default/disonline.gif) no-repeat;}

/*跟随提示信息*/
.followerPreviewBox {
    padding: 5px;
    width: 200px;
    background: #FFF url(<?php echo $webaddr?>/images/spinner.gif) no-repeat 5px center;
    position: absolute;
    z-index: 9999;
    text-align: left;
    min-height: 30px;
    border-color: #000;
    border-style: solid;
    border-width: 0 1px 1px 0;
    margin-top: 5px;
}
.followerPreviewBox table {
    overflow: hidden;
}
.followerPreviewBoxArrLeft, .followerPreviewBoxArrRight {
    background: url(<?php echo $webaddr?>/images/default/followtop.gif) no-repeat 0;
    width: 7px;
    height: 4px;
    overflow: hidden;
    position: absolute;
    top: -4px;
}
.followerPreviewBoxArrLeft {
    left: 8px;
}
.followerPreviewBoxArrRight {
    right: 8px;
}

/*表情*/
.emotions {
    position:absolute;
	width: 338px;
	padding: 2px 0 0 2px;
	background-color: #FFF;
	border: 1px solid #CEE1EE;
	z-index:9999;
}
ul.emotion{
	letter-spacing: -4px;
}
ul.emotion li{
    
	display: inline-block;
	vertical-align: top;
	letter-spacing: 0;
	margin: 0 2px 2px 0;
	width: 24px;
	height: 24px;
	*display: inline;
	*zoom: 1;
}
ul.emotion a {
	display: block;
	padding: 3px 1px;
	width: 20px;
	height: 16px;
	background-color: #FFF;
	border: 1px solid #DDD;
	text-align: center;
}
ul.emotion li.wider a {width: 46px;}
ul.emotion a:hover {
	border-color:#888;
}
ul.emotion img {
	display: block;
	margin: 0 auto;
    width:16px;
    height:16px;
}
.emo {/*width:20px;height:20px*/}

/*  top */
.itemtitle{clear:both;overflow:hidden;margin-bottom:10px;line-height:23px;padding-bottom:8px;background:url(<?php echo $webaddr?>/images/default/hard_dash.gif) repeat-x left bottom;}
.itemtitle h1{margin:0 20px 0 0;color:#179db5;font-size:16px}
.ranklist{margin:8px -9px;}
.ranklist dd{float:left;width:32%;margin-bottom:15px;}
.ranklist h3{margin:0 8px;padding:5px;border:1px solid #EEE;background:#F5F5F5;}
.ranklist h3 .more{float:right;}
.ranklist ul{border-top:1px solid #F5F5F5;list-style:none;}
.ranklist li{margin-bottom:0;padding:7px;border:solid #EEE;border-width:0 1px 1px;}
.ranklist li span{background:#E5E5E5;}
.top_list{margin:0 8px;}
.top_list .topavatar{border:1px solid #cccccc; padding:2px;float:left;margin-right:10px;}
.top_list .topavatar img{width:36px;height:36px;}
.top_list li{clear:both;margin-bottom:5px;line-height:20px;}
.top_list li span{float:left;margin:4px 8px 0 0;width:16px;height:14px;line-height:14px;text-align:center;background:url(<?php echo $webaddr?>/images/default/bg_li.gif) no-repeat;color:#fff;font-size:10px;}
.top_list li em{float:right;margin-left:8px;color:#999;}

.gotop{width:42px;position:fixed;right:40px;bottom:0;}
* html .gotop{position: absolute;top: expression(offsetParent.scrollTop+document.documentElement.clientHeight-this.offsetHeight);} 
.gotop button{background:url('<?php echo $webaddr?>/images/default/main_top.png') no-repeat 0 0;width:42px;height:33px;border:0 none;cursor:pointer}
.gotop button:hover{background-position:-41px 0;}
.gotop button span{display:none;}

 
