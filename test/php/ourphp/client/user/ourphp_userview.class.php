<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

if(!isset($_SESSION['username'])){
	header("location: ?".$ourphp_Language."-login.html");
	exit;
}

function ourphp_usermail(){ 
global $ourphp_webpath,$db,$smarty;
	
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_usermessage` where `OP_Usersend` = '".$_SESSION['username']."' || `OP_Usercollect` = '".$_SESSION['username']."' || `OP_Usercollect` = '全体会员'");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	
	$query = $db-> sqllist("select `id`,`OP_Usersend`,`OP_Usercollect`,`OP_Usercontent`,`OP_Userclass`,`time` from `ourphp_usermessage` where `OP_Usersend` = '".$_SESSION['username']."' || `OP_Usercollect` = '".$_SESSION['username']."' || `OP_Usercollect` = '全体会员' order by time desc LIMIT ".$start.",".$listpage);
	$rows=array();
	$i=1;
	while($ourphp_rs = mysql_fetch_array($query)){
			   $rows[]=array(
							"i" => $i,
							"id" => $ourphp_rs[0],
							"send" => $ourphp_rs[1],
							"collect" => $ourphp_rs[2],
							"content" => $ourphp_rs[3],
							"class" => $ourphp_rs[4],
							"time" => $ourphp_rs[5],
							); 
			$i+=1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
}

function ourphp_userview(){ 
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

$smarty->assign('mail',ourphp_usermail());
$smarty->assign('user',ourphp_userview());
$smarty->assign('payquick',ourphp_userpayquick());
$smarty->assign('paybank',ourphp_userpaybank());
$smarty->assign('integrallist',ourphp_userintegral());
?>