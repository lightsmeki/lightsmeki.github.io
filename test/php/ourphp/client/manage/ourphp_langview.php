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
}elseif($_GET["ourphp_cms"] == "edit"){

		if (strstr($OP_Adminpower,"34")){
		
		$sql="update `ourphp_lang` set 
		`OP_Lang` = '".admin_sql($_POST["OP_Lang"])."',
		`OP_Font` = '".admin_sql($_POST["OP_Font"])."',
		`OP_Note` = '".admin_sql($_POST["OP_Note"])."',
		`OP_Langtitle` = '".admin_sql($_POST["OP_Langtitle"])."',
		`OP_Langkeywords` = '".admin_sql($_POST["OP_Langkeywords"])."',
		`OP_Langdescription` = '".admin_sql($_POST["OP_Langdescription"])."'
		 where id = ".$_GET["id"]." order by id asc";
		$query=mysql_query($sql);
		
		$ourphp_font = 1;
		$ourphp_class = 'ourphp_lang.php';
		require 'ourphp_remind.php';
		
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_lang.php';
		require 'ourphp_remind.php';
			
		}
	

}

$sql="select * from `ourphp_lang` where `id` = ".$_GET["id"]."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_lang',$ourphp_rs);
mysql_free_result($query);

$smarty->display('ourphp_langview.html');
?>