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
		
			if (!empty($_POST["sheng"])){
			$sheng = implode('|',$_POST["sheng"]);
			}else{
			$sheng = '0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0';
			}
			
			$sql="update `ourphp_freight` set 
			`OP_Freightname` = '".admin_sql($_POST["OP_Freightname"])."',
			`OP_Freighttext` = '".$sheng."',
			`OP_Freightdefault` = '".admin_sql($_POST["OP_Freightdefault"])."',
			`OP_Freightweight` = '".admin_sql($_POST["OP_Freightweight"])."',
			`time` = '".date("Y-m-d H:i:s")."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_freight.php?id=ourphp';
			require 'ourphp_remind.php';
			
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_freight.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
			
}


$sql="select * from `ourphp_freight` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$ourphp_text=array(
					'id' => $ourphp_rs['id'],
					'title' => $ourphp_rs['OP_Freightname'],
					'text' => explode("|",$ourphp_rs['OP_Freighttext']),
					'default' => $ourphp_rs['OP_Freightdefault'],
					'weight' => $ourphp_rs['OP_Freightweight'],
);
$smarty->assign('ourphp_freight',$ourphp_text);
mysql_free_result($query);
$smarty->display('ourphp_freightview.html');
?>