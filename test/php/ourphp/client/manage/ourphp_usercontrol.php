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

			if (!empty($_POST["OP_Usermoney"])){
			$OP_Usermoney = implode('|',$_POST["OP_Usermoney"]);
			}else{
			$OP_Usermoney = '0|0|0|0';
			}
			
			$sql="update `ourphp_usercontrol` set 
			`OP_Userreg` = '".intval($_POST["OP_Userreg"])."',
			`OP_Userlogin` = '".intval($_POST["OP_Userlogin"])."',
			`OP_Userprotocol` = '".admin_sql($_POST["OP_Userprotocol"])."',
			`OP_Usergroup` = '".intval($_POST["OP_Usergroup"])."',
			`OP_Usermoney` ='".$OP_Usermoney."',
			`OP_Useripoff` ='".intval($_POST["OP_Useripoff"])."',
			`time` = '".date("Y-m-d H:i:s")."'
			 where id = 1";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_usercontrol.php?id=ourphp';
			require 'ourphp_remind.php';
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

Admin_click('会员选项','ourphp_usercontrol.php?id=ourphp');

$sql="select * from `ourphp_usercontrol` where `id` = 1";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_usercontrol',$ourphp_rs);

$OP_Usermoney = explode('|',$ourphp_rs["OP_Usermoney"]);
$smarty->assign('ourphp_Usermoney',$OP_Usermoney);

$smarty->assign("userleve",Userleve());
$smarty->display('ourphp_usercontrol.html');
?>