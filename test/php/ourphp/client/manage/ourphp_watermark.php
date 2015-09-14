<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';
include 'ourphp_page.class.php';
include '../../function/ourphp_navigation.class.php';

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){

			$sql="update `ourphp_watermark` set 
			`OP_Watermarkimg` = '".admin_sql($_POST["OP_Watermarkimg"])."',
			`OP_Watermarkfont` = '".admin_sql($_POST["OP_Watermarkfont"])."',
			`OP_Watermarkcolor` = '".admin_sql($_POST["OP_Watermarkcolor"])."',
			`OP_Watermarksize` = '".admin_sql($_POST["OP_Watermarksize"])."',
			`OP_Watermarkposition` ='".admin_sql($_POST["OP_Watermarkposition"])."',
			`OP_Watermarkoff` ='".admin_sql($_POST["OP_Watermarkoff"])."'
			 where id = 1";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_watermark.php?id=ourphp';
			require 'ourphp_remind.php';
}

Admin_click('图片水印设置','ourphp_watermark.php?id=ourphp');

$sql="select * from `ourphp_watermark` where `id` = 1";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_watermark',$ourphp_rs);

$smarty->display('ourphp_watermark.html');
?>