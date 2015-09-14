<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php'; 
if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "add"){

	$query = mysql_query("select `OP_Weburl` from `ourphp_web` where id = 1");
	$ourphp_rs = mysql_fetch_array($query);
	if($ourphp_rs[0] == '127.0.0.1' || $ourphp_rs[0] == 'localhost' || substr($ourphp_rs[0],0,3) == '192'){
	exit("域名无法开通统计服务，请联系OURPHP客服。");
	}
	
	$url = 'http://intf.cnzz.com/user/companion/b2b-builder.php?domain='.$ourphp_rs[0].'&key='.md5($ourphp_rs[0].'KclGiq7H').'&cms=ourphp';
	$info = file($url);
	$info = explode('@',$info[0]);
	$tjcode = '<script src="http://pw.cnzz.com/c.php?id='.$info[0].'&l=2" language="JavaScript" charset="gb2312"></script>';
	$query = mysql_query("update `ourphp_api` set `OP_Key` = 'CNZZ网站流量统计|1|".$info[0]."|".$info[1]."' where id = 2");
	$query = mysql_query("update `ourphp_web` set `OP_Webstatistics` = '".$tjcode."' where id = 1");
	exit("开通成功，请重新进入该页面！");
}

#查询API接口数据
$query = mysql_query("select `OP_Key` from `ourphp_api` where id = 2");
$ourphp_rs = mysql_fetch_array($query);
$api = explode('|',$ourphp_rs[0]);
mysql_free_result($query);
#判断接口是否开启
if ($api[1] == 2){
		exit($api[0].$ourphp_adminfont['plugsno']);
}
#接口查询结束
#调用方式：$api[0] 表示API名称，$api[1] 表示开关，$api[2~N] API值


$smarty->assign('cnzzname',$api[2]); 
$smarty->assign('cnzzpass',$api[3]); 
$smarty->display('ourphp_statistics.html');
?>