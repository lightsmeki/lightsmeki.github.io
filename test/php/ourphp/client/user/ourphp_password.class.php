<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

$ourphp_rs = '';
@$username = dowith_sql($_POST['OP_Useremail']);
$usernameno = $ourphp_adminfont['usernameno'];
$faqno = $ourphp_adminfont['faqno'];
$upok = $ourphp_adminfont['upok'];
$ValidateCode = $_SESSION["code"]; //验证码 没搞明白为毛要写在这里才可以兼容其它虚拟主机

	
if(empty($_GET['user'])){
echo '';
}elseif ($_GET['user'] == 'email'){

	$code = $ourphp_adminfont['code'];
	if ($_POST["code"] != $ValidateCode){
		exit("<script language=javascript> alert('".$code."');history.go(-1);</script>");
	}

	$query=mysql_query("SELECT `id`,`OP_Useremail`,`OP_Userproblem` FROM `ourphp_user` WHERE `OP_Useremail` = '".$username."'");
	$num=mysql_num_rows($query);
	if ($num < 1){
	exit("<script language=javascript> alert('".$usernameno."');history.go(-1);</script>");
	}
	$ourphp_rs = mysql_fetch_array($query);
	
}elseif ($_GET['user'] == 'faq'){
	
	$query=mysql_query("SELECT `id`,`OP_Useremail`,`OP_Useranswer` FROM `ourphp_user` WHERE `OP_Useremail` = '".$username."' && OP_Useranswer = '".dowith_sql($_POST['OP_Useranswer'])."'");
	$num=mysql_num_rows($query);
	if ($num < 1){
	exit("<script language=javascript> alert('".$faqno."');history.go(-2);</script>");
	}
	$ourphp_rs = mysql_fetch_array($query);
	
}elseif ($_GET['user'] == 'ok'){

	$query=mysql_query("SELECT `id` FROM `ourphp_user` WHERE `OP_Useremail` = '".$username."' && OP_Useranswer = '".dowith_sql($_POST['OP_Useranswer'])."'");
	$num=mysql_num_rows($query);
	if ($num < 1){
	exit("<script language=javascript> alert('".$usernameno."');history.go(-2);</script>");
	}
	
	$OP_Userpass = dowith_sql(substr(md5(md5($_REQUEST["OP_Userpass"])),0,16));
	$query=mysql_query("update `ourphp_user` set `OP_Userpass` = '".$OP_Userpass."' WHERE `OP_Useremail` = '".$username."'");
	echo "<script language=javascript> alert('".$upok."');location.replace('".$ourphp_webpath."client/user/?".$ourphp_Language."-login.html');</script>";
}

$smarty->assign('faq',$ourphp_rs);
?>