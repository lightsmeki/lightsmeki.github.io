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

	if (admin_sql($_POST["OP_Userclass"]) == 1){
		$query=mysql_query("SELECT OP_Useremail FROM `ourphp_user` WHERE `OP_Useremail` = '".admin_sql($_POST["OP_Usercollect"])."'");
		$num=mysql_num_rows($query);
		if ($num == 0){
		
			$ourphp_font = 5;
			$ourphp_img = 'no.png';
			$ourphp_content = '会员账户不存在！';
			$ourphp_class = 'ourphp_usermessage.php?id=ourphp';
			require 'ourphp_remind.php';
			
		}
	}
			$sql="insert into `ourphp_usermessage` set 
			`OP_Usersend` = '".admin_sql($_POST["OP_Usersend"])."',
			`OP_Usercollect` = '".admin_sql($_POST["OP_Usercollect"])."',
			`OP_Usercontent` = '".admin_sql($_POST["OP_Usercontent"])."',
			`OP_Userclass` = '".intval($_POST["OP_Userclass"])."',
			`time` = '".date("Y-m-d H:i:s")."'
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_usermessage.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){
			
			$sql="delete from ourphp_usermessage where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_usermessage.php?id=ourphp';
			require 'ourphp_remind.php';

						
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_usermessage.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}
}

function emaillist(){
	global $_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_usermessage` order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select id,OP_Usersend,OP_Usercollect,OP_Usercontent,OP_Userclass,time from `ourphp_usermessage` order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"send" => $ourphp_rs[1],
						"collect" => $ourphp_rs[2],
						"content" => $ourphp_rs[3],
						"class" => $ourphp_rs[4],
						"time" => $ourphp_rs[5]
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

Admin_click('站内邮件','ourphp_usermessage.php?id=ourphp');

$smarty->assign("email",emaillist());
$smarty->display('ourphp_usermessage.html');
?>