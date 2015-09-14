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

			$sql="update `ourphp_productset` set 
			`OP_Pattern` = '".intval($_POST["OP_Pattern"])."',
			`OP_Scheme` = '".intval($_POST["OP_Scheme"])."',
			`OP_Stock` = '".intval($_POST["OP_Stock"])."',
			`OP_buy` = '".intval($_POST["OP_buy"])."',
			`OP_Sendout` = '".admin_sql($_POST["OP_Sendout"])."',
			`time` = '".date("Y-m-d H:i:s")."',
			`OP_Delivery` = '".admin_sql($_POST["OP_Delivery"])."'
			 where id = 1";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_productset.php?id=ourphp';
			require 'ourphp_remind.php';
			
}
$sql="select * from `ourphp_productset` where `id` = 1";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_set',$ourphp_rs);
mysql_free_result($query);

$smarty->display('ourphp_productset.html');
?>