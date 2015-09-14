<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php'; 

if (isset($_GET["ourphp_cms"]) == "edit"){

	$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Weblogo"]));

	$sql="update `ourphp_wap` set 
	`OP_Website` = '".admin_sql($_POST["OP_Website"])."',
	`OP_Weblogo` = '".$ourphp_xiegang."',
	`OP_Webkeywords` = '".admin_sql($_POST["OP_Webkeywords"])."',
	`OP_Webdescriptions` = '".admin_sql($_POST["OP_Webdescriptions"])."',
	`OP_Weburl` = '".admin_sql($_POST["OP_Weburl"])."'
	 where id = 1";
	$query=mysql_query($sql);
	
	$ourphp_font = 1;
	$ourphp_class = 'ourphp_wap.php';
	require 'ourphp_remind.php';

}

Admin_click('手机网站设置','ourphp_wap.php');

$sql="select * from `ourphp_wap` where `id` = 1";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_wap',$ourphp_rs);
mysql_free_result($query);
$smarty->display('ourphp_wap.html');
?>