<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
 *-------------------------------
 * 视频播放器(2014-10-15)
 *-------------------------------
*/
include '../config/ourphp_code.php';
include '../config/ourphp_config.php';
include '../config/ourphp_Language.php';
include './ourphp_function.class.php';
session_start();
date_default_timezone_set('Asia/Shanghai'); //设置时区
$ValidateCode = $_SESSION["code"]; //验证码 没搞明白为毛要写在这里才可以兼容其它虚拟主机

//处理留言
if(isset($_GET["ourphp_cms"])){
$book = $ourphp_adminfont['bookadd'];
$code = $ourphp_adminfont['code'];

if($_POST["bookcontent"] == '' || $_POST["bookname"] == '' || $_POST["booktel"] == '' || $_POST["bookcode"] == ''){
	echo "<script language=javascript> alert('".$book."');history.go(-1);</script>";
	exit;
}

if($_POST["bookcode"] != $ValidateCode){
	echo "<script language=javascript> alert('".$code."');history.go(-1);</script>";
	exit;
}
			$sql="insert into `ourphp_book` set 
			`OP_Bookcontent` = '".dowith_sql(ourphp_sensitive($_POST["bookcontent"]))."',
			`OP_Bookname` = '".dowith_sql(ourphp_sensitive($_POST["bookname"]))."',
			`OP_Booktel` = '".dowith_sql($_POST["booktel"])."',
			`OP_Bookip` = '".dowith_sql($_POST["ip"])."',
			`OP_Bookclass` = '".dowith_sql($_POST["class"])."',
			`OP_Booklang` = '".dowith_sql($_POST["lang"])."',
			`time` = '".date("Y-m-d H:i:s")."'
			";
			$query=mysql_query($sql);

			if(isset($_POST["wapbook"])){
			echo "<script language=javascript>location.replace('".$ourphp_webpath."client/wap/?".$_POST["lang"]."-clubview-".$_POST["class"].".html');</script>";
			}else{
			echo "<script language=javascript>location.replace('".$ourphp_webpath."?".$_POST["lang"]."-clubview-".$_POST["class"].".html');</script>";
			}

}

//处理下载
if(isset($_GET["ourphp_down"])){

			$power= $ourphp_adminfont['power'];
			$sql="select `OP_Downrights`,`OP_Downdurl` from `ourphp_down` where id = ".intval($_GET["ourphp_down"])." && OP_Random = '".dowith_sql($_GET["code"])."'";
			$result=mysql_query($sql);
			$ourphp_rs=mysql_fetch_array($result);
			
			$OP_Downrights = $ourphp_rs[0];
			$OP_Downdurl = $ourphp_rs[1];
			if(substr($OP_Downdurl,0,7) == 'http://'){
				$downflie = $OP_Downdurl;
			}else{
				$downflie = $ourphp_webpath.$OP_Downdurl;
			}
			
			if(!mysql_num_rows($result)){
				echo "<script language=javascript> alert('".$power."');javascript:window.close()</script>";
					}else{
					
				if($OP_Downrights == '0'){
				header("location: ".$downflie);
					}else{
						//会员权限
						@session_start();
						@$usersql="select `OP_Userclass` from `ourphp_user` where `OP_Useremail` = '".$_SESSION['username']."'";
						$userresult=mysql_query($usersql);
						$ourphp_userrs=mysql_fetch_array($userresult);
						if (strstr($OP_Downrights,$ourphp_userrs[0])){
						header("location: ".$downflie);
						}else{
						exit("<script language=javascript> alert('".$power."');javascript:window.close()</script>");
						}
				}
				
			}
			mysql_free_result($userresult);
			mysql_free_result($query);
			exit;
}

//购物车删除
if(isset($_GET["ourphp_shopping"])){

		if(isset($_GET["type"])){
			$urltype = $ourphp_webpath."client/wap/?".$_GET["lang"]."-shoppingcart.html"; //手机
		}else{
			$urltype = $ourphp_webpath."?".$_GET["lang"]."-shoppingcart.html"; //电脑
		}

			$power= $ourphp_adminfont['power'];
			$sql="select `id` from `ourphp_shoppingcart` where id = ".intval($_GET["ourphp_shopping"])." && OP_Shopusername = '".$_SESSION['username']."'";
			$result=mysql_query($sql);
			
			if(!mysql_num_rows($result)){
				exit("<script language=javascript> alert('".$power."');javascript:window.close()</script>");
					}else{
				$sql="delete from `ourphp_shoppingcart` where id = ".intval($_GET["ourphp_shopping"])." && OP_Shopusername = '".$_SESSION['username']."'";
				$result=mysql_query($sql);
				echo "<script language=javascript>location.replace('".$urltype."');</script>";
				mysql_free_result($result);
			}
}
?>