<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
include '../../config/ourphp_code.php';
include '../../config/ourphp_config.php';
include '../../config/ourphp_Language.php';
include '../../function/ourphp_function.class.php';

session_start();
date_default_timezone_set('Asia/Shanghai'); //设置时区

//处理注册用户
if(empty($_GET["ourphp_cms"])){

	exit('no!');
	
}elseif($_GET["ourphp_cms"] == 'reg'){


		include_once "../../function/api/ourphpuser/ourphp_system.php";
		$oid = user_reg($_POST['useremail'],$_POST['username'],$_POST['password'],$_POST['passwordto']);
		if ($oid <= 0) {
			if ($oid == -1) {
				exit("<script language=javascript> alert('必填项不能为空');history.go(-1);</script>");
			} elseif ($oid == -2) {
				exit("<script language=javascript> alert('Email格式不正确');history.go(-1);</script>");
			} elseif ($oid == -3) {
				exit("<script language=javascript> alert('Email账户已存在');history.go(-1);</script>");
			} elseif ($oid == -4) {
				exit("<script language=javascript> alert('Email账户不存在或密码错误');history.go(-1);</script>");
			} elseif ($oid == -5) {
				exit("<script language=javascript> alert('账户被锁定');history.go(-1);</script>");
			} elseif ($oid == -6) {
				exit("<script language=javascript> alert('两次密码输入错误');history.go(-1);</script>");
			} else {
				echo '未定义';
			}
		} else {
			echo "<script language=javascript> location.replace('".$ourphp_webpath."client/wap/?".$_POST["lang"]."-userlogin.html');</script>"; //成功
		}

			
//处理会员登录
}elseif($_GET["ourphp_cms"] == 'login'){

		include_once "../../function/api/ourphpuser/ourphp_system.php";
		$oid = user_login($_POST['useremail'],$_POST['password']);
		if ($oid <= 0) {
			if ($oid == -1) {
				exit("<script language=javascript> alert('必填项不能为空');history.go(-1);</script>");
			} elseif ($oid == -2) {
				exit("<script language=javascript> alert('Email格式不正确');history.go(-1);</script>");
			} elseif ($oid == -3) {
				exit("<script language=javascript> alert('Email账户已存在');history.go(-1);</script>");
			} elseif ($oid == -4) {
				exit("<script language=javascript> alert('Email账户不存在或密码错误');history.go(-1);</script>");
			} elseif ($oid == -5) {
				exit("<script language=javascript> alert('账户被锁定');history.go(-1);</script>");
			} elseif ($oid == -6) {
				exit("<script language=javascript> alert('两次密码输入错误');history.go(-1);</script>");
			} else {
				echo '未定义';
			}
		} else {
			echo "<script language=javascript> location.replace('".$ourphp_webpath."client/wap/?".$_POST["lang"]."-usercenter.html');</script>"; //成功
		}

//退出
}elseif($_GET["ourphp_cms"] == 'out'){

	include_once "../../function/api/ourphpuser/ourphp_system.php";
	user_out($_SESSION['username']);
	echo "<script language=javascript> location.replace('".$ourphp_webpath."client/wap/?".$_GET["lang"]."-userlogin.html');</script>";
	

}elseif($_GET["ourphp_cms"] == 'integral'){

	$query=mysql_query("SELECT `id`,`OP_Iintegral`,`OP_Iid` FROM `ourphp_integral` WHERE `id` = '".intval($_GET["id"])."' && OP_Iuseremail = '".$_SESSION['username']."' && `OP_Iconfirm` = 0");
	$ourphp_rs = mysql_fetch_array($query);
	$num=mysql_num_rows($query);
	if ($num < 1){
				exit("<script language=javascript> alert('".$accessno."');history.go(-1);</script>");
	}else{
				$sql="update `ourphp_integral` set `OP_Iconfirm` = 1,`OP_ITime` = '".date("Y-m-d H:i:s")."' where `id` = '".intval($_GET["id"])."' && OP_Iuseremail = '".$_SESSION['username']."'";
				$query=mysql_query($sql);
				
				$sqlto="update `ourphp_user` set `OP_Userintegral` = `OP_Userintegral` + ".$ourphp_rs[1]." where `OP_Useremail` = '".$_SESSION['username']."'";
				$query=mysql_query($sqlto);
				
				$sqlth="insert into `ourphp_userpay` set 
				`OP_Useremail` = '".$_SESSION['username']."',
				`OP_Usermoney` = 0,
				`OP_Userintegral` = '".$ourphp_rs[1]."',
				`OP_Usercontent` = '领取商品赠送积分<br>商品id:".$ourphp_rs[2]."',
				`OP_Useradmin` = '".$_SESSION['username']."',
				`time` = '".date("Y-m-d H:i:s")."'
				";
				$query=mysql_query($sqlth);
				
				echo "<script language=javascript> location.replace('".$ourphp_webpath."client/wap/?".$_GET["lang"]."-userintegral.html');</script>";
				exit;	
	}
}
?>