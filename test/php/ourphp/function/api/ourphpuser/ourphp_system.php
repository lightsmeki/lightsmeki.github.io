<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
 *-------------------------------
 * OURPHP系统 会员处理接口
 *-------------------------------
*/
if(!defined('OURPHPNO')){exit('no!');}

//session_start();
@$useremail = dowith_sql($_REQUEST['useremail']);
@$username = dowith_sql($_REQUEST['username']);
@$password = dowith_sql($_REQUEST['password']);
@$passwordto = dowith_sql($_REQUEST['passwordto']);
@$type = $_REQUEST['type'];
@$key = $_REQUEST['key'];

function user_reg($useremail,$username,$password,$passwordto){

	if($password != $passwordto){
		return "-6"; //两次密码验证出错
		exit;
	}
	if($useremail == "" || $username == "" || $password == ""){
		return "-1"; //不能为空
		exit;
	}elseif(!strpos($useremail,"@")){
		return "-2"; //EMAIL格式不正确
		exit;
			}else{
			
			$query=mysql_query("SELECT OP_Useremail FROM `ourphp_user` WHERE `OP_Useremail` = '".dowith_sql($useremail)."'");
			$num=mysql_num_rows($query);
			if ($num != 0){
				return "-3"; //EMAIL账户已存在
				exit;
			}else{

				$sql="insert into `ourphp_user` set 
				  `OP_Useremail` = '".dowith_sql(htmlspecialchars($useremail))."',
				  `OP_Userpass` = '".dowith_sql(substr(md5(md5($password)),0,16))."',
				  `OP_Username` = '".dowith_sql(htmlspecialchars($username))."',
				  `OP_Userclass` = '1',
				  `OP_Usersource` = 'API接口',
				  `OP_Usermoney` = '0.00',
				  `OP_Userintegral` = '0.00',
				  `OP_Userproblem` = '你的家乡在哪？',
				  `OP_Useranswer` = '中国',
				  `OP_Userstatus` = 1,
				  `OP_Usercode` = '".randomkeys(18)."',
				  `time` = '".date("Y-m-d H:i:s")."'
				";
				$query=mysql_query($sql);
				return "200";
			}	
	}
}

function user_login($useremail,$password){
	if($useremail == "" || $password == ""){
		return "-1"; //不能为空
		exit;
	}elseif(!strpos($useremail,"@")){
		return "-2"; //EMAIL格式不正确
		exit;
			}else{
			
				$query=mysql_query("SELECT `id`,`OP_Userstatus` FROM `ourphp_user` WHERE `OP_Useremail` = '".dowith_sql($useremail)."' && `OP_Userpass` = '".dowith_sql(substr(md5(md5($password)),0,16))."'");
				$num=mysql_num_rows($query);
				$ourphp_rs = mysql_fetch_array($query);
				if ($num < 1){
					return "-4"; //EMAIL账户不存在或密码错误
					exit;
				}elseif($ourphp_rs[1] == 2){
					return "-5"; //账户被锁定
					exit;
				}else{
					$_SESSION['username'] = $useremail;
					return "200";
				}
			}	
}

function user_out($useremail){
		unset($_SESSION['username']);
		return "200";
}

?>