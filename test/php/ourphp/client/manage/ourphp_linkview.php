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
		
			$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Linkimg"]));
			$sql="update `ourphp_link` set 
			`OP_Linkname` = '".admin_sql($_POST["OP_Linkname"])."',
			`OP_Linkurl` = '".admin_sql($_POST["OP_Linkurl"])."',
			`OP_Linkclass` = '".admin_sql($_POST["OP_Linkclass"])."',
			`OP_Linkimg` = '".$ourphp_xiegang."',
			`OP_Linksorting` = '".intval($_POST["OP_Linksorting"])."',
			`OP_Linkstate` = '".intval($_POST["OP_Linkstate"])."',
			`time` = '".date("Y-m-d H:i:s")."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_link.php?id=ourphp';
			require 'ourphp_remind.php';

		
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_link.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}			
}

$sql="select * from `ourphp_link` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_link',$ourphp_rs);
mysql_free_result($query);

$smarty->display('ourphp_linkview.html');
?>