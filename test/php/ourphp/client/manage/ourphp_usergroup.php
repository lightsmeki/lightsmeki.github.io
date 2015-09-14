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
		
	if($_POST["OP_Userlevename"] == ''){
	
							$ourphp_font = 4;
							$ourphp_content = '不能为空!';
							$ourphp_class = 'ourphp_usergroup.php?id=ourphp';
							require 'ourphp_remind.php';
	
		}else{

			$sql="update `ourphp_userleve` set 
			`OP_Userlevename` = '".admin_sql($_POST["OP_Userlevename"])."',
			`OP_Userweight` = '".admin_sql($_POST["OP_Userweight"])."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_usergroup.php?id=ourphp';
			require 'ourphp_remind.php';
		}
		
}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_usergroup.php?id=ourphp';
		require 'ourphp_remind.php';
			
}
}

function Userleve(){
	global $conn;
	$sql="select id,OP_Userlevename,OP_Userweight from `ourphp_userleve` order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1],
						"weight" => $ourphp_rs[2],
					);
	}
	return $rows;
	mysql_free_result($query);
}

Admin_click('用户组管理','ourphp_usergroup.php?id=ourphp');
$smarty->assign("Userleve",Userleve());
$smarty->display('ourphp_usergroup.html');
?>