<?php 
/* 
* 积分处理
*/ 
include '../config/ourphp_code.php';
include '../config/ourphp_config.php';
include '../config/ourphp_Language.php';
include './ourphp_function.class.php';
session_start();
date_default_timezone_set('Asia/Shanghai'); //设置时区
$outlogin = $ourphp_adminfont['outlogin'];
$lackintegral = $ourphp_adminfont['lackintegral'];
$integraltook = $ourphp_adminfont['integraltook'];
$urltype = $_REQUEST["type"];

if(!isset($_SESSION['username'])){
	if($urltype == "wap"){
	exit("<script language=javascript> alert('".$outlogin."');window.parent.location.href='".$ourphp_webpath."client/wap/?cn-usercenter.html';</script>");
	}elseif($urltype == "pc"){
	exit("<script language=javascript> alert('".$outlogin."');window.parent.location.href='".$ourphp_webpath."client/user/';</script>");
	}
}

$id = intval($_GET["id"]);
$ourphp_rs = $db-> ourphpsql("select `id`,`OP_Title`,`OP_Integralexchange` from `ourphp_product` where `id` = ".$id);

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "add"){

	$useremail = $db-> ourphpsql("select `OP_Userintegral` from `ourphp_user` where `OP_Useremail` = '".$_SESSION['username']."'");
	if($useremail[0] < $ourphp_rs[2]){
		echo "<script language=javascript> alert('".$lackintegral."');history.go(-1);</script>";
		exit;
	}else{
				$sql="insert into `ourphp_orders` set 
				`OP_Ordersname` = '".$ourphp_rs[1]."',
				`OP_Ordersid` = '".$ourphp_rs[0]."',
				`OP_Ordersnum` = 1,
				`OP_Ordersemail` = '".$_SESSION['username']."',
				`OP_Ordersusername` = '".dowith_sql($_POST['name'])."',
				`OP_Ordersusertel` = '".dowith_sql($_POST['tel'])."',
				`OP_Ordersuseradd` = '".dowith_sql($_POST['add'])."',
				`time` = '".date("Y-m-d H:i:s")."',
				`OP_Ordersnumber` = 'OP".randomkeys(7)."',
				`OP_Orderspay` = 2,
				`OP_Orderssend` = 1,
				`OP_Integralok` = 1
				";
				$query=mysql_query($sql);
				
				$userint = $db-> sqllist("update `ourphp_user` set `OP_Userintegral` = `OP_Userintegral` - ".$ourphp_rs[2]." where `OP_Useremail` = '".$_SESSION['username']."'");
				
				if($urltype == "wap"){
				exit("<script language=javascript> alert('".$integraltook."');window.parent.location.href='".$ourphp_webpath."client/wap/?cn-usercenter.html';</script>");
				}elseif($urltype == "pc"){
				exit("<script language=javascript> alert('".$integraltook."');window.parent.location.href='".$ourphp_webpath."client/user/';</script>");
				}
	}
}


?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
*{ font-size:14px; font-family:Arial, Helvetica, sans-serif;}
body{ background:url(../skin/ingb.jpg)}
.input { width:90%; height:25px; line-height:25px; border:1px #cccccc solid;}
.input2 { width:90%; height:25px; line-height:25px; border:1px #cccccc solid;}
</style>
<link rel="stylesheet" href="plugs/Validform/style.css" type="text/css" />
<script type="text/javascript" src="plugs/jquery/1.7.2/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="plugs/Validform/Validform_v5.3.2.js"></script>
</head>

<body>
<form id="form1" name="form1" method="post" action="?ourphp_cms=add&id=<?php echo $id; ?>&type=<?php echo $urltype; ?>" class="registerform">
<table width="100%" border="0" cellpadding="10">
  <tr>
    <td width="85"><div align="right">商品名称:</div></td>
    <td>&nbsp;<?php echo $ourphp_rs[1];?></td>
  </tr>
  <tr>
    <td><div align="right">所需积分:</div></td>
    <td>&nbsp;<?php echo $ourphp_rs[2];?></td>
  </tr>
  <tr>
    <td><div align="right">收货人姓名:</div></td>
    <td><input type="text" name="name" class="input" datatype="*" nullmsg="收货人姓名是必填项!" /> *</td>
  </tr>
  <tr>
    <td><div align="right">收货人电话:</div></td>
    <td><input type="text" name="tel" class="input" datatype="*" nullmsg="收货人电话是必填项!" /> *</td>
  </tr>
  <tr>
    <td><div align="right">收货人地址:</div></td>
    <td><input type="text" name="add" class="input2" datatype="*" nullmsg="收货人地址是必填项!" /> *</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="确认兑换" style="width:100px; height:25px; border:0px; background:#CC0000; color:#FFFFFF;border-radius:10px" /></td>
  </tr>
</table>
</form>

<script type="text/javascript">
$(function(){
	$(".registerform").Validform();
})
</script>
</body>
</html>