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
		
			if (admin_sql($_POST["OP_Userpass"]) == ''){
			$OP_Userpass = admin_sql($_POST["password"]);
			}else{
			
			if (admin_sql($_POST["OP_Userpass"]) != admin_sql($_POST["OP_Userpassto"])){
					$ourphp_font = 4;
					$ourphp_content = '两次密码输入的不一样，请重新操作！';
					$ourphp_class = 'ourphp_user.php?id=ourphp';
					require 'ourphp_remind.php';
			}
			$OP_Userpass = admin_sql(substr(md5(md5($_REQUEST["OP_Userpass"])),0,16));
			}
		
			$sql="update `ourphp_user` set 
			`OP_Userclass` = '".intval($_POST["OP_Userclass"])."',
			`OP_Userstatus` = '".intval($_POST["OP_Userstatus"])."',
			`OP_Userpass` = '".$OP_Userpass."',
			`OP_Usermoney` = '".admin_sql($_POST["OP_Usermoney"])."',
			`OP_Userintegral` = '".admin_sql($_POST["OP_Userintegral"])."',
			`OP_Username` = '".admin_sql($_POST["OP_Username"])."',
			`OP_Usertel` = '".admin_sql($_POST["OP_Usertel"])."',
			`OP_Userqq` = '".intval($_POST["OP_Userqq"])."',
			`OP_Useraliww` = '".admin_sql($_POST["OP_Useraliww"])."',
			`OP_Userskype` = '".admin_sql($_POST["OP_Userskype"])."',
			`OP_Useradd` = '".admin_sql($_POST["OP_Useradd"])."',
			`OP_Usersource` = '".admin_sql($_POST["OP_Usersource"])."',
			`OP_Userhead` = '".admin_sql($_POST["OP_Userhead"])."',
			`OP_Userip` = '".admin_sql($_POST["OP_Userip"])."',
			`OP_Userproblem` = '".admin_sql($_POST["OP_Userproblem"])."',
			`OP_Useranswer` = '".admin_sql($_POST["OP_Useranswer"])."',
			`OP_Usertext` = '".admin_sql($_POST["OP_Usertext"])."',
			`OP_Usercode` = '".randomkeys(18)."',
			`time` = '".date("Y-m-d H:i:s")."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_user.php?id=ourphp';
			require 'ourphp_remind.php';
		
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_user.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
}

function Userleve(){
	global $conn;
	$sql="select id,OP_Userlevename from `ourphp_userleve` order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1]
					);
	}
	return $rows;
	mysql_free_result($query);
}

function Userproblem(){
	global $conn;
	$sql="select id,OP_Userproblem from `ourphp_userproblem` order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1]
					);
	}
	return $rows;
	mysql_free_result($query);
}
$sql="select * from `ourphp_user` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_user',$ourphp_rs);
mysql_free_result($query);

$smarty->assign('Userleve',Userleve());
$smarty->assign('Userproblem',Userproblem());
$smarty->display('ourphp_userview.html');
?>