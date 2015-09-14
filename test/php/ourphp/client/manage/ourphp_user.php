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

	$query=mysql_query("SELECT OP_Useremail FROM `ourphp_user` WHERE `OP_Useremail` = '".admin_sql($_POST["OP_Useremail"])."'");
	$num=mysql_num_rows($query);
	if ($num != 0){
	
		$ourphp_font = 3;
		$ourphp_class = 'ourphp_user.php?id=ourphp';
		require 'ourphp_remind.php';
	
			}else{			

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
			
			$sql="insert into `ourphp_user` set 
			`OP_Userclass` = '".intval($_POST["OP_Userclass"])."',
			`OP_Userstatus` = '".intval($_POST["OP_Userstatus"])."',
			`OP_Useremail` = '".admin_sql($_POST["OP_Useremail"])."',
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
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_user.php?id=ourphp';
			require 'ourphp_remind.php';
			}
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){
			
			$sql="delete from ourphp_user where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_user.php?id=ourphp';
			require 'ourphp_remind.php';

						
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
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

function Userlist(){
	global $_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_user` order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select id,OP_Useremail,OP_Username,OP_Usermoney,OP_Userintegral,OP_Userip,OP_Userstatus,time,OP_Usersource from `ourphp_user` order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"email" => $ourphp_rs[1],
						"name" => $ourphp_rs[2],
						"money" => $ourphp_rs[3],
						"integral" => $ourphp_rs[4],
						"ip" => $ourphp_rs[5],
						"status" => $ourphp_rs[6],
						"time" => $ourphp_rs[7],
						"source" => $ourphp_rs[8]
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

Admin_click('会员管理','ourphp_user.php?id=ourphp');
$smarty->assign('Userleve',Userleve());
$smarty->assign('Userproblem',Userproblem());
$smarty->assign("Userlist",Userlist());
$smarty->display('ourphp_user.html');
?>