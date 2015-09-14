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

			$sql="insert into `ourphp_productattribute` set 
			`OP_Title` = '".admin_sql($_POST["OP_Title"])."',
			`OP_Sorting` = '".admin_sql($_POST["OP_Sorting"])."',
			`OP_Class` = '0',
			`time` = '".date("Y-m-d H:i:s")."'
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_productattribute.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "edit"){

		if (strstr($OP_Adminpower,"34")){
		
			$sql="update `ourphp_productattribute` set 
			`OP_Title` = '".admin_sql($_POST["OP_Title"])."',
			`OP_Sorting` = '".admin_sql($_POST["OP_Sorting"])."',
			`OP_Class` = '0',
			`time` = '".date("Y-m-d H:i:s")."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_productattribute.php?id=ourphp';
			require 'ourphp_remind.php';

		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_productattribute.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){		
			
			$sql="delete from ourphp_productattribute where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$sql="delete from ourphp_productattribute where OP_Class = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_productattribute.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_productattribute.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}
}

function Attribute(){
	global $conn;
	$sql="select id,OP_Title,OP_Sorting from `ourphp_productattribute` where `OP_Class` = 0 order by OP_Sorting asc";
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1],
						"sorting" => $ourphp_rs[2]
					);
	$i = $i + 1;
	}
	return $rows;
	mysql_free_result($query);
}

$smarty->assign("Attribute",Attribute());
$smarty->display('ourphp_productattribute.html');
?>