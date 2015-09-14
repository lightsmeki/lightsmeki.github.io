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
			//OP_QQother` = '".admin_sql($_POST["OP_QQother"])."',
			$sql="insert into `ourphp_qq` set 
			`OP_QQname` = '".admin_sql($_POST["OP_QQname"])."',
			`OP_QQnumber` = '".admin_sql($_POST["OP_QQnumber"])."',
			`OP_QQclass` = '".admin_sql($_POST["OP_QQclass"])."',
			`OP_QQsorting` = '".admin_sql($_POST["OP_QQsorting"])."',
			`time` = '".date("Y-m-d H:i:s")."'
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_qq.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){		
			
			$sql="delete from ourphp_qq where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_qq.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_qq.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}
}

function QQlist(){
	global $conn;
	$sql="select id,OP_QQname,OP_QQnumber,OP_QQclass,OP_QQsorting,time from `ourphp_qq` order by OP_QQsorting asc";
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1],
						"number" => $ourphp_rs[2],
						"class" => $ourphp_rs[3],
						"sorting" => $ourphp_rs[4],
						"time" => $ourphp_rs[5]
					);
	$i = $i + 1;
	}
	return $rows;
	mysql_free_result($query);
}

Admin_click('浮动客服管理','ourphp_qq.php?id=ourphp');
$smarty->assign("QQlist",QQlist());
$smarty->display('ourphp_qq.html');
?>