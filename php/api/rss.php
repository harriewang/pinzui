<?php
$API=1;
include('../common.inc.php');

$username=$_GET['user_name'];

$user=user_info("user_name='{$username}'");
if (!$user) {
    echo "不存在该用户";
    exit;
}

header("Content-type: application/xml");
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n".
     "  <rss version=\"2.0\">\n".
     "  <channel>\n".
     "  <title>{$user[nickname]} - 贫嘴</title>\n".
     "  <link>{$webaddr}/{$user[user_name]}</link>\n".
     "  <description>贫嘴 - 看看 {$user[nickname]} 在做什么…</description>\n".
     "  <webMaster></webMaster>\n".
     "  <language>zh-cn</language>\n".
     "  <image>\n".
     "  <link>{$webaddr}</link>\n".
     "  <url>{$webaddr}/images/default/logo.png</url>\n".
     "  <title>贫嘴</title>\n".
     "  </image>\n";

    $query = $db->query("SELECT * FROM et_content WHERE user_name='$username' && privacy=0 && replyshow=1 ORDER BY content_id DESC LIMIT 20");
    while($data = $db->fetch_array($query)) {
        $contents=clean_html($data['content_body']);
        $contents=ubbreplace($contents);
        $title=getsubstrutf8($contents,0,30,true);
        echo "    <item>\n".
             "     <title>{$data[user_nickname]}: {$title}</title>\n".
             "     <description><![CDATA[$data[user_nickname]: $contents]]></description>\n".
             "     <pubDate>".date("r",$data['posttime'])."</pubDate>\n".
             "     <link>$webaddr/op/view/$data[content_id]</link>\n".
             "   </item>\n";
    }
    echo "  </channel>\n".
         "  </rss>";
?>