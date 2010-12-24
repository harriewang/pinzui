<?php
if(!defined('IN_ET')) {
	exit('Access Denied');
}

//备份还原函数
function write_file($sql,$filename) {
    $re=true;
    if(!@$fp=fopen("./backup/".$filename,"w+")) {$re=false; echo "failed to open target file";}
    if(!@fwrite($fp,$sql)) {$re=false; echo "failed to write file";}
    if(!@fclose($fp)) {$re=false; echo "failed to close target file";}
    return $re;
}
function down_file($sql,$filename){
	ob_end_clean();
	header("Content-Encoding: none");
	header("Content-Type: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'application/octetstream' : 'application/octet-stream'));

	header("Content-Disposition: ".(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') ? 'inline; ' : 'attachment; ')."filename=".$filename);

	header("Content-Length: ".strlen($sql));
	header("Pragma: no-cache");

	header("Expires: 0");
	echo $sql;
	$e=ob_get_contents();
	ob_end_clean();
}

function writeable($dir){
	if(!is_dir($dir)) {
	    @mkdir($dir, 0777);
	}
	if(is_dir($dir)){
        if($fp = @fopen("$dir/test.test", 'w')){
            @fclose($fp);
            @unlink("$dir/test.test");
            $writeable = 1;
        }else {
            $writeable = 0;
	    }
    }
	return $writeable;
}

function make_header($table){
    global $db;
    $sql="DROP TABLE IF EXISTS `".$table."`;\n";
    $db->query("show create table ".$table);
    $db->nextrecord();
    $tmp=preg_replace("/\n/","",$db->f("Create Table"));
    $sql.=$tmp.";\n";
    return $sql;
}

function make_record($table,$num_fields){
    global $db;
    $comma="";
    $sql .= "INSERT INTO ".$table." VALUES(";
    for($i = 0; $i < $num_fields; $i++)
    {$sql .= ($comma."'".mysql_escape_string($db->record[$i])."'"); $comma = ",";}
    $sql .= ");\n";
    return $sql;
}

function show_msg($msgs){
    $i=0;
    $tm1="<table width='100%' border='0'  cellpadding='0' cellspacing='1'><tr><td><font color='red'><b>提示信息：</b></font></td></tr><tr><td><ul>";
    while (list($k,$v)=each($msgs)){
        $i=$i+1;
        $t1="<li>$i.".$v."</li>";
        $t=$t.$t1;
    }
    $tm2="</ul></td></tr></table>";
    return $tm1.$t.$tm2;
}

function pageend(){
    exit();
}

function import($fname) {
    global $db;
    $sqls=file($fname);
        foreach($sqls as $sql){
        str_replace("\r","",$sql);
        str_replace("\n","",$sql);
        if(!$db->query(trim($sql))) return false;
	}
    return true;
}
?>