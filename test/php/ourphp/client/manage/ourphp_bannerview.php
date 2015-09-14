<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';
include '../../function/ourphp_navigation.class.php';

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){

		if (strstr($OP_Adminpower,"34")){
		
			$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Bannerimg"]));
			$sql="update `ourphp_banner` set 
			`OP_Bannerimg` = '".$ourphp_xiegang."',
			`OP_Bannertitle` = '".admin_sql($_POST["OP_Bannertitle"])."',
			`OP_Bannerurl` = '".admin_sql($_POST["OP_Bannerurl"])."',
			`OP_Bannerlang` = '".admin_sql($_POST["OP_Bannerlang"])."',
			`time` = '".date("Y-m-d H:i:s")."',
			`OP_Bannerclass` = '".admin_sql($_POST["OP_Bannerclass"])."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_banner.php?id=ourphp';
			require 'ourphp_remind.php';
			
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_banner.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}			
}

function Langlist(){
	global $conn;
	$sql="select id,OP_Lang,OP_Font,OP_Default from `ourphp_lang` order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs[0],
						"lang" => $ourphp_rs[1],
						"font" => $ourphp_rs[2],
						"default" => $ourphp_rs[3]
					);
	}
	return $rows;
	mysql_free_result($query);
}

$sql="select * from `ourphp_banner` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_banner',$ourphp_rs);
mysql_free_result($query);

$smarty->assign('langlist',Langlist());
$smarty->display('ourphp_bannerview.html');
?>