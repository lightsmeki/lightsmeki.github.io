<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">*{ font-size:12px;}</style>
</head>
<body>
<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
 *-------------------------------
 * 快递100查询接口
 *-------------------------------
*/

include '../../../config/ourphp_code.php';
include '../../../config/ourphp_config.php';
include '../../../config/ourphp_Language.php';
include '../../ourphp_function.class.php';

session_start();
if(!isset($_SESSION['username'])){
	exit($ourphp_adminfont['power']);
}

#查询API接口数据
$query = mysql_query("select `OP_Key` from `ourphp_api` where id = 1");
$ourphp_rs = mysql_fetch_array($query);
$api = explode('|',$ourphp_rs[0]);
mysql_free_result($query);
#判断接口是否开启
if ($api[1] == 2){
		exit($api[0].$ourphp_adminfont['plugsno']);
}
#接口查询结束
#调用方式：$api[0] 表示API名称，$api[1] 表示开关，$api[2~N] API值


$title = $_GET['title'];
$number = $_GET['number'];
$AppKey=$api[2];
$url ='http://www.kuaidi100.com/applyurl?key='.$AppKey.'&com='.$title.'&nu='.$number;

if (function_exists('curl_init') == 1){
  $curl = curl_init();
  curl_setopt ($curl, CURLOPT_URL, $url);
  curl_setopt ($curl, CURLOPT_HEADER,0);
  curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt ($curl, CURLOPT_USERAGENT,$_SERVER['HTTP_USER_AGENT']);
  curl_setopt ($curl, CURLOPT_TIMEOUT,5);
  $get_content = curl_exec($curl);
  curl_close ($curl);
}else{
  include("snoopy.php");
  $snoopy = new snoopy();
  $snoopy->referer = 'http://www.google.com/';
  $snoopy->fetch($url);
  $get_content = $snoopy->results;
}
echo '<iframe src="'.$get_content.'" width="550" height="255" scrolling="no" frameborder="0"></iframe><p style="width:550px;text-align:center;">数据由kuaidi100.com提供！</p>';
?>
</body>
</html>