<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php'; 

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif($_GET["ourphp_cms"] == "add"){

	$query=mysql_query("SELECT OP_Lang FROM `ourphp_lang` WHERE `OP_Lang` = '".admin_sql($_POST["OP_Lang"])."'");
	$num=mysql_num_rows($query);
	if ($num != 0){
	
		$ourphp_font = 3;
		$ourphp_class = 'ourphp_lang.php';
		require 'ourphp_remind.php';
	
			}else{

		$sql="insert into `ourphp_lang` set 
		`OP_Lang` = '".admin_sql($_POST["OP_Lang"])."',
		`OP_Font` = '".admin_sql($_POST["OP_Font"])."',
		`OP_Note` = '".admin_sql($_POST["OP_Note"])."',
		`OP_Langtitle` = '".admin_sql($_POST["OP_Langtitle"])."',
		`OP_Langkeywords` = '".admin_sql($_POST["OP_Langkeywords"])."',
		`OP_Langdescription` = '".admin_sql($_POST["OP_Langdescription"])."'
		";
		$query=mysql_query($sql);
		
		$ourphp_font = 1;
		$ourphp_class = 'ourphp_lang.php';
		require 'ourphp_remind.php';
	
	}
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){

			$sql="delete from ourphp_lang where id = ".intval($_GET['id']);
			$query=mysql_query($sql);			
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_lang.php';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_lang.php';
			require 'ourphp_remind.php';
			
			}
				
}

function Langlist(){
	global $conn;
	$sql="select * from `ourphp_lang` order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs['id'],
						"lang" => $ourphp_rs['OP_Lang'],
						"font" => $ourphp_rs['OP_Font'],
						"default" => $ourphp_rs['OP_Default'],
						"note" => $ourphp_rs['OP_Note'],
						"langtitle" => $ourphp_rs['OP_Langtitle'],
						"keywords" => $ourphp_rs['OP_Langkeywords'],
						"description" => $ourphp_rs['OP_Langdescription']
					);
	}
	return $rows;
	mysql_free_result($query);
}
Admin_click('网站语言配置','ourphp_lang.php');
$smarty->assign("langlist",Langlist());
$smarty->display('ourphp_lang.html');
?>