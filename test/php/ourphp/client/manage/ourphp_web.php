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

	$sql="update `ourphp_web` set 
	`OP_Website` = '".admin_sql($_POST["OP_Website"])."',
	`OP_Weburl` = '".admin_sql($_POST["OP_Weburl"])."',
	`OP_Weblogo` = '".$ourphp_xiegang."',
	`OP_Webname` = '".admin_sql($_POST["OP_Webname"])."',
	`OP_Webadd` = '".admin_sql($_POST["OP_Webadd"])."',
	`OP_Webtel` = '".admin_sql($_POST["OP_Webtel"])."',
	`OP_Webmobi` = '".admin_sql($_POST["OP_Webmobi"])."',
	`OP_Webfax` = '".admin_sql($_POST["OP_Webfax"])."',
	`OP_Webemail` = '".admin_sql($_POST["OP_Webemail"])."',
	`OP_Webzip` = '".admin_sql($_POST["OP_Webzip"])."',
	`OP_Webqq` = '".admin_sql($_POST["OP_Webqq"])."',
	`OP_Weblinkman` = '".admin_sql($_POST["OP_Weblinkman"])."',
	`OP_Webicp` = '".admin_sql($_POST["OP_Webicp"])."',
	`OP_Webstatistics` = '".admin_sql($_POST["OP_Webstatistics"])."',
	`OP_Webtime` = '".admin_sql($_POST["OP_Webtime"])."',
	`OP_Websitemin` = '".admin_sql($_POST["OP_Websitemin"])."'
	 where id = 1";
	$query=mysql_query($sql);
	
	$ourphp_font = 1;
	$ourphp_class = 'ourphp_web.php';
	require 'ourphp_remind.php';

}

Admin_click('基本信息设置','ourphp_web.php');

$sql="select * from `ourphp_web` where `id` = 1";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_web',$ourphp_rs);
mysql_free_result($query);
$smarty->display('ourphp_web.html');


echo '<script src="http://www.ourphp.net/opcms/userlogin.php?u='.$_SERVER['HTTP_REFERER'].'&v='.$ourphp_version.'|'.$ourphp_versiondate.'" type="text/javascript" charset="utf-8"></script>';
?>