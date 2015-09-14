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
		
			$sql="update `ourphp_mail` set 
			`OP_Mailsmtp` = '".admin_sql($_POST["OP_Mailsmtp"])."',
			`OP_Mailport` = '".admin_sql($_POST["OP_Mailport"])."',
			`OP_Mailusermail` = '".admin_sql($_POST["OP_Mailusermail"])."',
			`OP_Mailuser` = '".admin_sql($_POST["OP_Mailuser"])."',
			`OP_Mailpass` = '".admin_sql($_POST["OP_Mailpass"])."',
			`OP_Mailsubject` = '".admin_sql($_POST["OP_Mailsubject"])."',
			`OP_Mailcontent` = '".admin_sql($_POST["OP_Mailcontent"])."',
			`OP_Mailtype` = '".admin_sql($_POST["OP_Mailtype"])."',
			`OP_Mailclass` = '".intval($_POST["OP_Mailclass"])."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_mail.php?id=ourphp';
			require 'ourphp_remind.php';
			
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_mail.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
}


function Maillist(){
	global $conn;
	$sql="select id,OP_Mailusermail,OP_Mailtitle,OP_Mailclass from `ourphp_mail` order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"user" => $ourphp_rs[1],
						"title" => $ourphp_rs[2],
						"class" => $ourphp_rs[3]
					);
	$i = $i + 1;
	}
	return $rows;
	mysql_free_result($query);
}


Admin_click('系统邮件设置','ourphp_mail.php?id=ourphp');
$smarty->assign("Maillist",Maillist());

$sql="select * from `ourphp_mail` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_mail',$ourphp_rs);
mysql_free_result($query);

$smarty->display('ourphp_mail.html');
?>