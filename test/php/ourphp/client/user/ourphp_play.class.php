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

function ourphp_usercontrol(){ 
$sql = "select a.`OP_Userreg`,a.`OP_Userlogin`,a.`OP_Usergroup`,a.`OP_Usermoney`,a.`OP_Useripoff` ,b.`OP_Ucenter` from `ourphp_usercontrol` a , `ourphp_webdeploy` b where a.`id` = 1 && b.`id` = 1"; 
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$rows = array(
				'regoff' => $ourphp_rs[0],
				'loginoff' => $ourphp_rs[1],
				'group' => $ourphp_rs[2],
				'money' => explode("|",$ourphp_rs[3]),
				'ipoff' => $ourphp_rs[4],
				'ucenter' => $ourphp_rs[5],
			);
return $rows;
mysql_free_result($query);
}

session_start();
date_default_timezone_set('Asia/Shanghai'); //设置时区
$ValidateCode = $_SESSION["code"]; //验证码 没搞明白为毛要写在这里才可以兼容其它虚拟主机
$ourphp_usercontrol = ourphp_usercontrol();
$inputno = $ourphp_adminfont['inputno'];
$code = $ourphp_adminfont['code'];
$passwordto = $ourphp_adminfont['passwordto'];
$regyes = $ourphp_adminfont['regyes'];
$usernameyes = $ourphp_adminfont['usernameyes'];
$userip = $ourphp_adminfont['userip'];
$userloginno = $ourphp_adminfont['userloginno'];
$upok = $ourphp_adminfont['upok'];
$usernameno = $ourphp_adminfont['usernameno'];
$mailsend = $ourphp_adminfont['mailsend'];
$accessno = $ourphp_adminfont['accessno'];
$mobilecode = $ourphp_adminfont['mobilecode'];

//处理注册用户
if(empty($_GET["ourphp_cms"])){

	exit('no!');
	
}elseif($_GET["ourphp_cms"] == 'reg'){


if ($_POST["OP_Useremail"] == '' || $_POST["OP_Userpass"] == '' || $_POST["OP_Userpass2"] == '' || $_POST["OP_Username"] == '' || $_POST["OP_Usertel"] == '' || $_POST["OP_Useranswer"] == ''){
exit("<script language=javascript> alert('".$inputno."');history.go(-1);</script>");
}elseif ($_POST["OP_Userpass"] != $_POST["OP_Userpass2"]){
exit("<script language=javascript> alert('".$passwordto."');history.go(-1);</script>");
}elseif ($_POST["code"] != $ValidateCode){
exit("<script language=javascript> alert('".$code."');history.go(-1);</script>");
}

$op = $db -> plugsclass("手机短信API接口","regsms");
if($op == "200"){
	if($_POST['mobilecode'] != $_SESSION['mobilecode']){
		exit("<script language=javascript> alert('".$mobilecode."');history.go(-1);</script>");
	}
}

	$query=mysql_query("SELECT OP_Useremail FROM `ourphp_user` WHERE `OP_Useremail` = '".dowith_sql($_POST["OP_Useremail"])."'");
	$num=mysql_num_rows($query);
	if ($num != 0){
	
		exit("<script language=javascript> alert('".$usernameyes."');history.go(-1);</script>");
	
			}else{	
			
			if ($ourphp_usercontrol['ipoff'] == 1){
				$query=mysql_query("SELECT id FROM `ourphp_user` WHERE `OP_Userip` = '".dowith_sql($_POST["ip"])."'");
				$num=mysql_num_rows($query);
				if ($num != 0){
								exit("<script language=javascript> alert('".$userip."');history.go(-1);</script>");
				}
			}
			
			if(dowith_sql($_POST["introducer"]) == ''){
				$introducer = '';
			}else{			 
				$queryto=mysql_query("SELECT `OP_Useremail` FROM `ourphp_user` WHERE `id` = ".intval($_POST["introducer"]));
				$num=mysql_num_rows($queryto);
				if ($num != 0){
					$query=mysql_query("update `ourphp_user` set 
					`OP_Usermoney` = `OP_Usermoney` + ".$ourphp_usercontrol['money'][2].",
					`OP_Userintegral` = `OP_Userintegral` + ".$ourphp_usercontrol['money'][3]."
					 where id = ".intval($_POST["introducer"]));
					 
					$ourphp_rs = mysql_fetch_array($queryto);
					$introducer = $ourphp_rs[0];
				}else{
					$introducer = '';
				}
			}
			
				$sql="insert into `ourphp_user` set 
				  `OP_Useremail` = '".dowith_sql($_POST["OP_Useremail"])."',
				  `OP_Userpass` = '".dowith_sql(substr(md5(md5($_REQUEST["OP_Userpass"])),0,16))."',
				  `OP_Username` = '".dowith_sql($_POST["OP_Username"])."',
				  `OP_Usertel` = '".dowith_sql($_POST["OP_Usertel"])."',
				  `OP_Userqq` = '".dowith_sql($_POST["OP_Userqq"])."',
				  `OP_Userskype` = '".dowith_sql($_POST["OP_Userskype"])."',
				  `OP_Useraliww` = '".dowith_sql($_POST["OP_Useraliww"])."',
				  `OP_Useradd` = '".dowith_sql($_POST["OP_Useradd"])."',
				  `OP_Userclass` = '".$ourphp_usercontrol['group']."',
				  `OP_Usersource` = '".$introducer."',
				  `OP_Usermoney` = '".$ourphp_usercontrol['money'][0]."',
				  `OP_Userintegral` = '".$ourphp_usercontrol['money'][1]."',
				  `OP_Userip` = '".dowith_sql($_POST["ip"])."',
				  `OP_Userproblem` = '".dowith_sql($_POST["OP_Userproblem"])."',
				  `OP_Useranswer` = '".dowith_sql($_POST["OP_Useranswer"])."',
				  `OP_Userstatus` = 1,
				  `OP_Usertext` = '".dowith_sql($_POST["OP_Usertext"])."',
				  `OP_Usercode` = '".randomkeys(18)."',
				  `time` = '".date("Y-m-d H:i:s")."'
				";
				$query=mysql_query($sql);
				//处理Ucenter
				if($ourphp_usercontrol['ucenter'] == 1){
				
						include_once '../../config.inc.php';
						include_once '../../uc_client/client.php';
						$OP_Useremail = dowith_sql($_POST["OP_Useremail"]);
						$OP_Userpass = dowith_sql($_REQUEST["OP_Userpass"]);
						$OP_Username = dowith_sql($_POST["OP_Username"]);
						
						$uid = uc_user_register("$OP_Username", "$OP_Userpass", "$OP_Useremail");
						if ($uid <= 0) {
							if ($uid == -1) {
								exit("<script language=javascript> alert('姓名不合法');history.go(-1);</script>");
							} elseif ($uid == -2) {
								exit("<script language=javascript> alert('包含要允许注册的词语');history.go(-1);</script>");
							} elseif ($uid == -3) {
								exit("<script language=javascript> alert('姓名已经存在');history.go(-1);</script>");
							} elseif ($uid == -4) {
								exit("<script language=javascript> alert('Email 格式有误');history.go(-1);</script>");
							} elseif ($uid == -5) {
								exit("<script language=javascript> alert('Email 不允许注册');history.go(-1);</script>");
							} elseif ($uid == -6) {
								exit("<script language=javascript> alert('该 Email 已经被注册');history.go(-1);</script>");
							} else {
								echo '未定义';
							}
						} else {
							echo ''; //注册成功
						}
						
				}
				//注册成功，邮件提醒
				$ourphp_mail = 'reguser';
				$OP_Useremail = dowith_sql($_POST["OP_Useremail"]);
				$OP_Userpass = dowith_sql($_POST["OP_Userpass"]);
				$OP_Username = dowith_sql($_POST["OP_Username"]);
				include '../../function/ourphp_mail.class.php';
				echo "<script language=javascript> alert('".$regyes."');location.replace('".$ourphp_webpath."client/user/?".$_POST["lang"]."-login.html');</script>";
				exit;
			}

			
//处理会员登录
}elseif($_GET["ourphp_cms"] == 'login'){

if ($_POST["code"] != $ValidateCode){
	exit("<script language=javascript> alert('".$code."');history.go(-1);</script>");
}

	$loginerror = $ourphp_adminfont['loginerror'];
	$query=mysql_query("SELECT `id`,`OP_Useremail`,`OP_Userpass`,`OP_Userstatus`,`OP_Username` FROM `ourphp_user` WHERE `OP_Useremail` = '".dowith_sql($_POST["OP_Useremail"])."' and `OP_Userpass` = '".dowith_sql(substr(md5(md5($_REQUEST["OP_Userpass"])),0,16))."'");
	$num=mysql_num_rows($query);
	if ($num < 1){
	
		exit("<script language=javascript> alert('".$loginerror."');history.go(-1);</script>");
		
		}else{
		$ourphp_rs = mysql_fetch_array($query);
		if($ourphp_rs[3] == 2){
			exit("<script language=javascript> alert('".$userloginno."');history.go(-1);</script>");
		}
		$_SESSION['username'] = $_POST["OP_Useremail"];
		
		
		//处理Ucenter
				if($ourphp_usercontrol['ucenter'] == 1){
						include_once '../../config.inc.php';
						include_once '../../uc_client/client.php';
						$OP_Userpass = dowith_sql($_REQUEST["OP_Userpass"]);
						$OP_Username = $ourphp_rs[4];
						
						list($uid, $username, $password, $email) = uc_user_login("$OP_Username", "$OP_Userpass");
						if($uid > 0) {
							//echo '登录成功'.$uid;
							echo uc_user_synlogin($uid);
						} elseif($uid == -1) {
							//echo '用户不存在,或者被删除';
						} elseif($uid == -2) {
							//echo '密码错';
						} else {
							//echo '未定义';
						}
				}
				
		echo "<script>location.href='".$ourphp_webpath."client/user/';</script>";
		
		}
		
	mysql_close($conn);
	
//退出
}elseif($_GET["ourphp_cms"] == 'out'){

	unset($_SESSION['username']);
	
		//处理Ucenter
				if($ourphp_usercontrol['ucenter'] == 1){
						include_once '../../config.inc.php';
						include_once '../../uc_client/client.php';
						echo uc_user_synlogout();
				}
				
	echo "<script language=javascript> location.replace('".$ourphp_webpath."client/user/?".$_GET["lang"]."-login.html');</script>";
	
//修改资料
}elseif($_GET["ourphp_cms"] == 'edit'){


if ($_POST["OP_Username"] == '' || $_POST["OP_Usertel"] == '' || $_POST["OP_Useranswer"] == '' || $_POST["code"] == ''){
exit("<script language=javascript> alert('".$inputno."');history.go(-1);</script>");
}elseif ($_POST["OP_Userpass"] != $_POST["OP_Userpass2"]){
exit("<script language=javascript> alert('".$passwordto."');history.go(-1);</script>");
}elseif ($_POST["code"] != $ValidateCode){
exit("<script language=javascript> alert('".$code."');history.go(-1);</script>");
}

				if ($_POST["OP_Userpass"] == '' && $_POST["OP_Userpass2"] == ''){
					$password = $_POST["password"];
				}else{
					if ($_POST["OP_Userpass"] != $_POST["OP_Userpass2"]){
					exit("<script language=javascript> alert('".$passwordto."');history.go(-1);</script>");
					}
					$password = dowith_sql(substr(md5(md5($_REQUEST["OP_Userpass"])),0,16));
				}
				
				$sql="update `ourphp_user` set 
				  `OP_Userpass` = '".$password."',
				  `OP_Username` = '".dowith_sql($_POST["OP_Username"])."',
				  `OP_Usertel` = '".dowith_sql($_POST["OP_Usertel"])."',
				  `OP_Userqq` = '".dowith_sql($_POST["OP_Userqq"])."',
				  `OP_Userskype` = '".dowith_sql($_POST["OP_Userskype"])."',
				  `OP_Useraliww` = '".dowith_sql($_POST["OP_Useraliww"])."',
				  `OP_Useradd` = '".dowith_sql($_POST["OP_Useradd"])."',
				  `OP_Useranswer` = '".dowith_sql($_POST["OP_Useranswer"])."',
				  `OP_Usertext` = '".dowith_sql($_POST["OP_Usertext"])."',
				  `OP_Usercode` = '".randomkeys(18)."'
				 WHERE `OP_Useremail` = '".$_SESSION['username']."' and `OP_Usercode` = '".dowith_sql($_POST["usercode"])."'";
				$query=mysql_query($sql);
				echo "<script language=javascript> alert('".$upok."');location.replace('".$ourphp_webpath."client/user/?".$_POST["lang"]."-useredit.html');</script>";
				exit;

//处理站内邮件
}elseif($_GET["ourphp_cms"] == 'mail'){

	$query=mysql_query("SELECT id FROM `ourphp_user` WHERE `OP_Useremail` = '".dowith_sql($_POST["OP_Usercollect"])."'");
	$num=mysql_num_rows($query);
	if ($num < 1){
				exit("<script language=javascript> alert('".$usernameno."');history.go(-1);</script>");
	}else{
				if (dowith_sql($_POST["OP_Usercollect"]) == $_SESSION['username']){
				exit("<script language=javascript> alert('".$accessno."');history.go(-1);</script>");
				}
				$sql="insert into `ourphp_usermessage` set 
				  `OP_Usersend` = '".$_SESSION['username']."',
				  `OP_Usercollect` = '".dowith_sql($_POST["OP_Usercollect"])."',
				  `OP_Usercontent` = '".dowith_sql($_POST["OP_Usercontent"])."',
				  `time` = '".date("Y-m-d H:i:s")."'";
				$query=mysql_query($sql);
				echo "<script language=javascript> alert('".$mailsend."');location.replace('".$ourphp_webpath."client/user/?".$_POST["lang"]."-usermail.html');</script>";
				exit;
	}
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
				
				echo "<script language=javascript> location.replace('".$ourphp_webpath."client/user/?".$_GET["lang"]."-userintegral.html');</script>";
				exit;	
	}
}
?>