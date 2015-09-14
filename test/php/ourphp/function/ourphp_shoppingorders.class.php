<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

$bookadd = $ourphp_adminfont['bookadd'];
$accessno = $ourphp_adminfont['accessno'];
$shoppingok = $ourphp_adminfont['shoppingok'];
$usermoneyno = $ourphp_adminfont['usermoneyno'];

if(@$_SESSION['username'] == ''){
	exit("<script language=javascript> alert('".$shoppinglogin."');location.replace('".$ourphp_webpath."client/user/?".$ourphp_Language."-login.html');</script>");
}

	if(isset($_REQUEST["type"])){
		$urltype = array(
						"shop" => $ourphp_webpath."client/wap/?".$ourphp_Language."-shoppingorders.html",
						"shopping" => $ourphp_webpath."client/wap/?".$ourphp_Language."-usershopping.html",
						"car" => $ourphp_webpath."client/wap/?".$ourphp_Language."-shoppingcart.html",
						); //手机
	}else{
		$urltype = array(
						"shop" => $ourphp_webpath."?".$ourphp_Language."-shoppingorders.html",
						"shopping" => $ourphp_webpath."client/user/?".$ourphp_Language."-usershopping.html",
						"car" => $ourphp_webpath."?".$ourphp_Language."-shoppingcart.html",
						); //电脑
	}

//计算运费
function ourphp_freight($add,$weight,$freight,$number){ 
	global $db;
	$ourphp_rs = $db-> ourphpsql("select `OP_Freighttext`,`OP_Freightweight` from `ourphp_freight` where `id` = ".intval($freight));
	$freightop = explode('|',$ourphp_rs[0]); //首重
	$weightop = $ourphp_rs[1]; //续重
	
	$city = explode('|','北京市|天津市|上海市|重庆市|国外|河北省|河南省|云南省|辽宁省|黑龙江省|湖南省|安徽省|山东省|新疆|江苏省|浙江省|江西省|湖北省|广西|甘肃省|山西省|内蒙古|陕西省|吉林省|福建省|贵州省|广东省|青海省|西藏|四川省|宁夏|海南省|台湾省|香港|澳门');

	$i=0;
	foreach($city as $op){
		if(strstr($add,$op)){
			$ok = $i;
			break;
		}else{
			$ok = 4;
		}
		$i += 1;
	}
	
	if($number < 2){
		if($weight < 2){
		$yf = $freightop[$ok];
		}else{
		$yf = ($weight - 1) * $weightop + $freightop[$ok];
		}
	}else{
	
		$yfop = $number * $weight;
		$yf = ($yfop - 1) * $weightop + $freightop[$ok];
		
	}


	return $yf;
}


function ourphp_userview(){ 
global $db;
	$ourphp_rs = $db-> ourphpsql("select `OP_Usermoney`,`OP_Userintegral` from `ourphp_user` where `OP_Useremail` = '".$_SESSION['username']."'"); 
	$userrows = array(
						'money' => $ourphp_rs[0],
						'integral' => $ourphp_rs[1],

	);
	return $userrows;
}

function ourphp_usermoney($usermoney,$webmarket){
	global $db,$ourphp_webpath,$ourphp_productshop;
	$ourphp_rs = $db-> ourphpsql("select `OP_Userclass` from `ourphp_user` where `OP_Useremail` = '".$_SESSION['username']."'");
	$Useremail = explode("|",$usermoney);
	foreach($Useremail as $op){
				$Useremailto = explode(":",$op);
				if($ourphp_rs[0] == $Useremailto[0]){
				$opcms = $Useremailto[1];
				}
	}
	return $webmarket - $opcms;
}

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "buy"){

if($_POST['shoppingname'] == '' || $_POST['shoppingtel'] == '' || $_POST['shoppingadd'] == ''){
	exit("<script language=javascript> alert('".$bookadd."');location.replace('".$urltype['car']."');</script>");
}

	if (!empty($_POST["ourphp_opcms"])){
	$a = implode(',',$_POST["ourphp_opcms"]);
	$b = str_replace(',|,','|',$a);
	$ourphp_opcms = substr($b, 0, -2);
	}else{
	exit("no!");
	}
	
	$fg = explode('|',$ourphp_opcms);
	foreach($fg as $op){
	$opcms = explode(',',$op);
	
	//判断产品价格是否被篡改
	$query = $db-> sqllist("select `OP_Webmarket`,`OP_Usermoney` from `ourphp_product` where `id` = ".intval($opcms[0]));
	$ourphp_rs = mysql_fetch_array($query);
	$usermarket = ourphp_usermoney($ourphp_rs[1],$ourphp_rs[0]);
	if($opcms[6] != $usermarket){
	exit("<script language=javascript> alert('".$usermoneyno."');history.go(-1);</script>");
	}
	
	$sql="insert into `ourphp_orders` set 
	`OP_Ordersname` = '".dowith_sql($opcms[1])."',
	`OP_Ordersid` = '".dowith_sql($opcms[0])."',
	`OP_Ordersnum` = '".dowith_sql($opcms[7])."',
	`OP_Ordersemail` = '".$_SESSION['username']."',
	`OP_Ordersusername` = '".dowith_sql($_POST['shoppingname'])."',
	`OP_Ordersusertel` = '".dowith_sql($_POST['shoppingtel'])."',
	`OP_Ordersuseradd` = '".dowith_sql($_POST['shoppingadd'])."',
	`OP_Ordersusetext` = '".dowith_sql($opcms[8])."',
	`OP_Ordersproductatt` = '".dowith_sql($opcms[2])."',
	`OP_Orderswebmarket` = '".dowith_sql($opcms[5])."',
	`OP_Ordersusermarket` = '".dowith_sql($opcms[6])."',
	`OP_Ordersweight` = '".dowith_sql($opcms[3])."',
	`OP_Ordersfreight` = '".ourphp_freight(dowith_sql($_POST['shoppingadd']),$opcms[3],$opcms[4],dowith_sql($opcms[7]))."',
	`time` = '".date("Y-m-d H:i:s")."',
	`OP_Ordersnumber` = '".'OP'.randomkeys(7)."',
	`OP_Orderssend` = 1,
	`OP_Orderspay` = 1,
	`OP_Integralok` = 0
	";
	$query=mysql_query($sql);
	}
	
	$sql="delete from ourphp_shoppingcart where OP_Shopusername = '".$_SESSION['username']."'";
	$query=mysql_query($sql);
	exit("<script language=javascript>location.replace('".$urltype['shop']."');</script>");
			
}elseif ($_GET["ourphp_cms"] == "buyok"){

	if (!empty($_POST["id"])){
	$id = implode(',',$_POST["id"]);
	}else{
	$id = 0;
	}
	
	if ($id == 0){
	exit("no!");
	}
	
	$id = str_replace("'","ourphp",$id); //过滤' 防止注入
	$query = $db-> sqllist("select `OP_Ordersnum`,`OP_Ordersusermarket`,`OP_Ordersfreight`,`OP_Ordersid`,`OP_Ordersproductatt` from `ourphp_orders` where `id` in (".$id.")");
	$zj = '';
	while($ourphp_rs = mysql_fetch_array($query)){
	$zj += ($ourphp_rs[0] * $ourphp_rs[1]) + $ourphp_rs[2];
	
		//减去库存
		$queryto = $db-> sqllist("select `OP_Specifications`,`id`,`OP_Title`,`OP_Market`,`OP_Webmarket`,`OP_Integral` from `ourphp_product` where id = ".$ourphp_rs[3]); 
		if($ourphp_rsrs = mysql_fetch_array($queryto)){
		$o = '|'.$ourphp_rsrs[0];
		$u = $ourphp_rs[4];
		$r = $ourphp_rs[0];
		$php = preg_replace("/((?:^|\|(?:[\A-Z0-9]+),$u),(?:[\d.]+,){2})(\d+)/e", "'$1'.($2-$r)", $o);
		$querythree = $db-> sqllist("update `ourphp_product` set `OP_Specifications` = '".substr($php,1)."' where id = ".$ourphp_rs[3]);
		}
		
		//加入积分表
		if($ourphp_rsrs[5] > 0){
		$queryfor = $db-> sqllist("insert into `ourphp_integral` set `OP_Iid` = '".$ourphp_rsrs[1]."', `OP_Iname` = '".$ourphp_rsrs[2]."', `OP_Imarket` = '".$ourphp_rsrs[3]."', `OP_Iwebmarket` = '".$ourphp_rsrs[4]."', `OP_Iintegral` = '".$ourphp_rsrs[5]."',`OP_Iconfirm` = 0, `OP_Iuseremail` = '".$_SESSION['username']."', `time` = '".date("Y-m-d H:i:s")."'");
		}
	}
	
	if(isset($_POST['delivery'])){
		if($shopsetgg['delivery'] == 0){
			exit("<script language=javascript> alert('".$accessno."');location.replace('".$urltype['shop']."');</script>");
		}else{
			$query = $db-> sqllist("update `ourphp_orders` set `OP_Orderspay` = 3 where id in (".$id.")"); 
		}
	}else{
		$query = $db-> sqllist("select `OP_Usermoney` from `ourphp_user` where `OP_Useremail` = '".$_SESSION['username']."'");
		$ourphp_rs = mysql_fetch_array($query);	
		if($ourphp_rs[0] < $zj){
			exit("<script language=javascript> alert('".$accessno."');location.replace('".$urltype['shop']."');</script>");
		}
		$query = $db-> sqllist("update `ourphp_orders` set `OP_Orderspay` = 2 where id in (".$id.")"); 
		$query = $db-> sqllist("update `ourphp_user` set `OP_Usermoney` = `OP_Usermoney` - ".$zj." where `OP_Useremail` = '".$_SESSION['username']."'");
	}
	
	//邮件提醒			
	$ourphp_mail = 'userbuy';
	$OP_Useremail = $_SESSION['username'];
	include './function/ourphp_mail.class.php';
	
	exit("<script language=javascript> alert('".$shoppingok."');location.replace('".$urltype['shopping']."');</script>");
}

if (empty($_GET['id'])){
$ordersid = 0;
}else{
$ordersid = intval($_GET['id']);
}

function ourphp_orderslist(){
	global $db,$ordersid; 
	if($ordersid == 0){
	$query = $db-> sqllist("select `id`,`OP_Ordersname`,`OP_Ordersid`,`OP_Ordersnum`,`OP_Ordersusername`,`OP_Ordersusertel`,`OP_Ordersuseradd`,`OP_Ordersusetext`,`OP_Ordersproductatt`,`OP_Orderswebmarket`,`OP_Ordersusermarket`,`OP_Ordersnumber`,`OP_Ordersweight`,`OP_Ordersfreight` from `ourphp_orders` where `OP_Ordersemail` = '".$_SESSION['username']."' && OP_Orderspay = 1 && OP_Orderssend = 1 order by id desc"); 
	}else{
	$query = $db-> sqllist("select `id`,`OP_Ordersname`,`OP_Ordersid`,`OP_Ordersnum`,`OP_Ordersusername`,`OP_Ordersusertel`,`OP_Ordersuseradd`,`OP_Ordersusetext`,`OP_Ordersproductatt`,`OP_Orderswebmarket`,`OP_Ordersusermarket`,`OP_Ordersnumber`,`OP_Ordersweight`,`OP_Ordersfreight` from `ourphp_orders` where `id` = '".$ordersid."'"); 
	}
	$rows = array();
	$i = 1;
	$jg = 0;
	$zj = 0;
	$yf = 0;
	while($ourphp_rs = mysql_fetch_array($query)){
	
	$jg = $ourphp_rs[10] * $ourphp_rs[3];
	$zj += $jg;
	$yf = $yf + $ourphp_rs[13];
	
		$rows[] = array(
						'i' => $i,
						'id' => $ourphp_rs[0],
						'title' => $ourphp_rs[1],
						'prid' => $ourphp_rs[2],
						'num' => $ourphp_rs[3],
						'username' => $ourphp_rs[4],
						'usertel' => $ourphp_rs[5],
						'useradd' => $ourphp_rs[6],
						'text' => $ourphp_rs[7],
						'pratt' => $ourphp_rs[8],
						'webmarket' => $ourphp_rs[9],
						'usermarket' => $ourphp_rs[10],
						'number' => $ourphp_rs[11],
						'totalt' => $jg,
						'total' => $zj,
						'weight' => $ourphp_rs[12],
						'freight' => $ourphp_rs[13],
						'freightt' => $yf,
					);
		$i+=1;
	}
	return $rows;
}

$smarty->assign('orderslist',ourphp_orderslist());
$smarty->assign('userview',ourphp_userview());
?>