<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php'; 

if (isset($_GET["ourphp_cms"]) == "edit"){

	$sql="update `ourphp_webdeploy` set 
	`OP_Webrewrite` = '".admin_sql($_POST["OP_Webrewrite"])."',
	`OP_Webkeywords` = '".admin_sql($_POST["OP_Webkeywords"])."',
	`OP_Webkeywordsto` = '".admin_sql($_POST["OP_Webkeywordsto"])."',
	`OP_Webdescriptions` = '".admin_sql($_POST["OP_Webdescriptions"])."'
	 where id = 1";
	$query=mysql_query($sql);
	$ourphp_font = 1;
	$ourphp_class = 'ourphp_webseo.php';
	require 'ourphp_remind.php';

}

$sql="select * from `ourphp_webdeploy` where `id` = 1";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$rows = array(
				'OP_Weboff' => $ourphp_rs['OP_Weboff'],
				'OP_Webofftext' => $ourphp_rs['OP_Webofftext'],
				'OP_Webrewrite' => $ourphp_rs['OP_Webrewrite'],
				'OP_Webpage' => explode(",",$ourphp_rs['OP_Webpage']),
				'OP_Webkeywords' => $ourphp_rs['OP_Webkeywords'],
				'OP_Webkeywordsto' => $ourphp_rs['OP_Webkeywordsto'],
				'OP_Webdescriptions' => $ourphp_rs['OP_Webdescriptions'],
);
$smarty->assign('ourphp_web',$rows);
mysql_free_result($query);
$smarty->display('ourphp_webseo.html');
?>