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

		if (strstr($OP_Adminpower,"34")){
		
			$OP_Adpiaofui = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Adpiaofui"]));
			$OP_Adduilianli = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Adduilianli"]));
			$OP_Adduilianri = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Adduilianri"]));
			$sql="update `ourphp_ad` set 
			`OP_Adpiaofui` = '".$OP_Adpiaofui."',
			`OP_Adpiaofuu` = '".admin_sql($_POST["OP_Adpiaofuu"])."',
			`OP_Adyouxiat` = '".admin_sql($_POST["OP_Adyouxiat"])."',
			`OP_Adyouxiaf` = '".admin_sql($_POST["OP_Adyouxiaf"])."',
			`OP_Adduilianli` = '".$OP_Adduilianli."',
			`OP_Adduilianlu` = '".intval($_POST["OP_Adduilianlu"])."',
			`OP_Adduilianri` = '".$OP_Adduilianri."',
			`OP_Adduilianru` = '".intval($_POST["OP_Adduilianru"])."',
			`OP_Adstateo` = '".intval($_POST["OP_Adstateo"])."',
			`OP_Adstatet` = '".intval($_POST["OP_Adstatet"])."',
			`OP_Adstates` = '".intval($_POST["OP_Adstates"])."',
			`time` = '".date("Y-m-d H:i:s")."'
			 where id = 5";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_ad.php?id=ourphp';
			require 'ourphp_remind.php';
		
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_ad.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
}

function ADlist(){
	global $conn;
	$id = '1,2,3,4';
	$sql="select id,OP_Adtitle,OP_Adpiaofui,OP_Adclass from `ourphp_ad` where id in($id) order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1],
						"img" => $ourphp_rs[2],
						"position" => $ourphp_rs[3]
					);
	$i = $i + 1;
	}
	return $rows;
	mysql_free_result($query);
}



Admin_click('广告管理','ourphp_ad.php?id=ourphp');
$smarty->assign("ADList",ADlist());

$sql="select * from `ourphp_ad` where `id` = 5";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_ad',$ourphp_rs);

$smarty->display('ourphp_ad.html');
?>