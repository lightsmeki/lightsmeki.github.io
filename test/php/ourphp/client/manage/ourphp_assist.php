<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php'; 

if(isset($_GET["our"]) == ""){
	echo '';
}else{

	if ($_POST['pass'] != ''){
		$sql="update `ourphp_admin` set `OP_Adminpass` = '".md5($_POST['pass'])."' where id = ".intval($_GET['id'])."";
		$query=mysql_query($sql);
		echo "<script language=javascript> alert('".$ourphp_adminfont['upok']."');history.go(-1);</script>";
	}else{
		$sql="update `ourphp_admin` set `OP_Adminpass` = '".$_POST['passto']."' where id = ".intval($_GET['id'])."";
		$query=mysql_query($sql);
		echo "<script language=javascript> alert('".$ourphp_adminfont['upok']."');history.go(-1);</script>";
	}
	
}
$smarty->assign('OP_Adminname',$OP_Adminname);
$smarty->assign('OP_Adminpower',$OP_Adminpower);
$smarty->display('ourphp_assistuse.html');
?>
