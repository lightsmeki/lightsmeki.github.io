<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
 *-------------------------------
 * 模板操作类(2014-10-15)
 *-------------------------------
*/
if(!defined('OURPHPNO')){exit('no!');}

$temptypetoo = $temptype;
$temptypetoo = str_replace("　and","and",$temptypetoo);
$temptypetoo = str_replace("　or","or",$temptypetoo);

switch($temptypetoo){
case "cn":
			include './ourphp_userview.class.php';
			if($smarty->templateExists($ourphp_templates."/".$ourphp_Language."_index.html")){
			$smarty->display($ourphp_Language.'_index.html');
				}else{
			echo $ourphp_tempno;
			exit();
			}
break;

case "reg.html":
		include './ourphp_userreg.class.php';
		if($smarty->templateExists($ourphp_templates."/".$ourphp_Language."_reg.html")){
		$smarty->display($ourphp_Language.'_reg.html');
			}else{
		echo $ourphp_tempno;
		}
break;

case "login.html":
		if($smarty->templateExists($ourphp_templates."/".$ourphp_Language."_login.html")){
		$smarty->display($ourphp_Language.'_login.html');
			}else{
		echo $ourphp_tempno;
		}
break;

case "useredit.html":
		include './ourphp_userview.class.php';
		if($smarty->templateExists($ourphp_templates."/".$ourphp_Language."_edit.html")){
		$smarty->display($ourphp_Language.'_edit.html');
			}else{
		echo $ourphp_tempno;
		}
break;

case "usermail.html":
		include './ourphp_userview.class.php';
		if($smarty->templateExists($ourphp_templates."/".$ourphp_Language."_mail.html")){
		$smarty->display($ourphp_Language.'_mail.html');
			}else{
		echo $ourphp_tempno;
		}
break;

case "usershopping.html":
		include './ourphp_userview.class.php';
		include './ourphp_shoppingorders.class.php';
		if($smarty->templateExists($ourphp_templates."/".$ourphp_Language."_usershopping.html")){
		$smarty->display($ourphp_Language.'_usershopping.html');
			}else{
		echo $ourphp_tempno;
		}
break;

case "userpay.html":
		include './ourphp_userview.class.php';
		if($smarty->templateExists($ourphp_templates."/".$ourphp_Language."_userpay.html")){
		$smarty->display($ourphp_Language.'_userpay.html');
			}else{
		echo $ourphp_tempno;
		}
break;

case "userintegral.html":
		include './ourphp_userview.class.php';
		if($smarty->templateExists($ourphp_templates."/".$ourphp_Language."_userintegral.html")){
		$smarty->display($ourphp_Language.'_userintegral.html');
			}else{
		echo $ourphp_tempno;
		}
break;

case "password.html":
		include './ourphp_password.class.php';
		if($smarty->templateExists($ourphp_templates."/".$ourphp_Language."_password.html")){
		$smarty->display($ourphp_Language.'_password.html');
			}else{
		echo $ourphp_tempno;
		}
break;

default:
		include './ourphp_userview.class.php';
		if($smarty->templateExists($ourphp_templates."/".$ourphp_Language."/".$ourphp_Language."_".$temptype)){
		$smarty->display($ourphp_Language.'/'.$ourphp_Language."_".$temptype);
			}else{
		echo $ourphp_tempno.'No:'.$ourphp_Language."_".$temptype;
		}
break;
}
?>