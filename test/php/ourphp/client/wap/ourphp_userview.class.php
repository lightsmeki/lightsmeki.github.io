<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

if(!isset($_SESSION['username'])){
	header("location: ?".$ourphp_Language."-userlogin.html");
	exit;
}
function wapshoppingnum(){
	global $db;
	if(empty($_SESSION['username'])){
	return;
	}else{
	$ourphp_rs = $db-> sqllist("select count(id) as tiaoshu from `ourphp_shoppingcart` where `OP_Shopusername` = '".$_SESSION['username']."'"); 
	return mysql_fetch_assoc($ourphp_rs);
	}
}

function wapshoppingorder(){
	global $db;
	if(empty($_SESSION['username'])){
	return;
	}else{
	$ourphp_rs = $db-> sqllist("select count(id) as tiaoshu from `ourphp_orders` where `OP_Ordersemail` = '".$_SESSION['username']."' && `OP_Orderspay` = 1"); 
	return mysql_fetch_assoc($ourphp_rs);
	}
}

function userclass($id){ 
global $db,$ourphp_webpath; 
$ourphp_rs = $db-> ourphpsql("select `OP_Userlevename` from `ourphp_userleve` where id = ".$id);
return $ourphp_rs[0];
}

function ourphp_wapuserview(){ 
global $ourphp_webpath,$db;
			$ourphp_rs = $db-> ourphpsql("select `id`,`OP_Useremail`,`OP_Username`,`OP_Usertel`,`OP_Userqq`,`OP_Userskype`,`OP_Useraliww`,`OP_Useradd`,`OP_Userclass`,`OP_Usermoney`,`OP_Userintegral`,`OP_Userproblem`,`OP_Useranswer`,`OP_Usertext`,`OP_Usercode`,`OP_Userpass` from `ourphp_user` where `OP_Useremail` = '".$_SESSION['username']."'"); 
			$userrows = array(
								'id' => $ourphp_rs[0],
								'email' => $ourphp_rs[1],
								'name' => $ourphp_rs[2],
								'tel' => $ourphp_rs[3],
								'qq' => $ourphp_rs[4],
								'skype' => $ourphp_rs[5],
								'aliww' => $ourphp_rs[6],
								'add' => $ourphp_rs[7],
								'class' => userclass($ourphp_rs[8]),
								'money' => $ourphp_rs[9],
								'integral' => $ourphp_rs[10],
								'problem' => $ourphp_rs[11],
								'answer' => $ourphp_rs[12],
								'text' => $ourphp_rs[13],
								'code' => $ourphp_rs[14],
								'password' => $ourphp_rs[15],

			);
			return $userrows;
}

function ourphp_userintegral(){
	global $conn,$db;
	$query = $db-> sqllist("select `id`,`OP_Iname`,`OP_Iintegral`,`OP_Iconfirm`,`OP_ITime` from `ourphp_integral` where `OP_Iuseremail` = '".$_SESSION['username']."'");
	$userrows = array();
	while($ourphp_rs = mysql_fetch_array($query)){
		$userrows[] = array(
							'id' => $ourphp_rs[0],
							'name' => $ourphp_rs[1],
							'integral' => $ourphp_rs[2],
							'confirm' => $ourphp_rs[3],
							'lqtime' => $ourphp_rs[4],
		);
	}
	return $userrows;
}

function ourphp_userpayquick(){
global $ourphp_webpath,$db;
			$ourphp_rs = $db-> ourphpsql("select `id`,`OP_Key` from `ourphp_api` where `id` = 3");
			$userrows = array(
								'id' => $ourphp_rs[0],
								'key' => explode('|',$ourphp_rs[1]),
			);
			return $userrows;
}

function ourphp_userpaybank(){
global $ourphp_webpath,$db;
			$ourphp_rs = $db-> ourphpsql("select `id`,`OP_Key` from `ourphp_api` where `id` = 4");
			$userrows = array(
								'id' => $ourphp_rs[0],
								'key' => explode('|',$ourphp_rs[1]),
			);
			return $userrows;
}

$smarty->assign('wapshoppingcart',wapshoppingnum());
$smarty->assign('wapshoppingorder',wapshoppingorder());
$smarty->assign('user',ourphp_wapuserview());
$smarty->assign('integrallist',ourphp_userintegral());
$smarty->assign('payquick',ourphp_userpayquick());
$smarty->assign('paybank',ourphp_userpaybank());
?>