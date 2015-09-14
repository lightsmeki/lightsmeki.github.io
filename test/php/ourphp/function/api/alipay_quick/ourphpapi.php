<?php


include '../../../config/ourphp_code.php';
include '../../../config/ourphp_config.php';
include '../../../config/ourphp_version.php';
include '../../../config/ourphp_Language.php';
include '../../ourphp_function.class.php';
include '../../ourphp/Smarty.class.php';
date_default_timezone_set('Asia/Shanghai'); //设置时区
session_start();
if(!isset($_SESSION['username'])){
	exit($ourphp_adminfont['power']);
}

//通用类

$sql = "select * from `ourphp_web` where `id` = 1"; 
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$web = array(
					'website' => $ourphp_rs["OP_Website"],
					'weburl' => $ourphp_rs["OP_Weburl"],
					'weblogo' => $ourphp_webpath.$ourphp_rs["OP_Weblogo"],
					'webname' => $ourphp_rs["OP_Webname"],
					'webadd' => $ourphp_rs["OP_Webadd"],
					'webtel' => $ourphp_rs["OP_Webtel"],
					'webmobi' => $ourphp_rs["OP_Webmobi"],
					'webfax' => $ourphp_rs["OP_Webfax"],
					'webemail' => $ourphp_rs["OP_Webemail"],
					'webzip' => $ourphp_rs["OP_Webzip"],
					'webqq' => $ourphp_rs["OP_Webqq"],
					'weblinkman' => $ourphp_rs["OP_Weblinkman"],
					'webicp' => $ourphp_rs["OP_Webicp"],
					'webstatistics' => $ourphp_rs["OP_Webstatistics"],
					'webtime' => $ourphp_rs["OP_Webtime"],
);
mysql_free_result($query);

$sql = "select `OP_Key` from `ourphp_api` where `id` = 3"; 
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$api = explode('|',$ourphp_rs[0]);
mysql_free_result($query);

#判断接口是否开启
if ($api[1] == 2){
		exit($api[0].$ourphp_adminfont['plugsno']);
}
#接口查询结束
#调用方式：$api[0] 表示API名称，$api[1] 表示开关，$api[2~N] API值
?>