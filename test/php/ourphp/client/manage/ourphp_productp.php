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
}elseif ($_GET["ourphp_cms"] == "add"){

			$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Img"]));
			$sql="insert into `ourphp_productcp` set 
			`OP_Brand` = '".admin_sql($_POST["OP_Brand"])."',
			`OP_Img` = '".$ourphp_xiegang."',
			`OP_Class` = '2',
			`time` = '".date("Y-m-d H:i:s")."'
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_productp.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "edit"){

		if (strstr($OP_Adminpower,"34")){
		
			$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Img"]));
			$sql="update `ourphp_productcp` set 
			`OP_Brand` = '".admin_sql($_POST["OP_Brand"])."',
			`OP_Img` = '".$ourphp_xiegang."',
			`OP_Class` = '2',
			`time` = '".date("Y-m-d H:i:s")."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_productp.php?id=ourphp';
			require 'ourphp_remind.php';

		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_productp.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){		
			
			$sql="delete from ourphp_productcp where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_productp.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_productp.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}
}

function Brand(){
	global $conn;
	$sql="select id,OP_Brand,OP_Img from `ourphp_productcp` where `OP_Class` = 2 order by id desc";
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1],
						"img" => $ourphp_rs[2]
					);
	$i = $i + 1;
	}
	return $rows;
	mysql_free_result($query);
}

$smarty->assign("Brand",Brand());
if (isset($_GET["pid"])){
$sql="select * from `ourphp_productcp` where `id` = ".intval($_GET['pid'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_productp',$ourphp_rs);
mysql_free_result($query);
}
$smarty->display('ourphp_productp.html');
?>