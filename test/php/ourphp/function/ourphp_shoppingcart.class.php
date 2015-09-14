<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

$shoppinglogin = $ourphp_adminfont['shoppinglogin'];
$shoppingnum = $ourphp_adminfont['shoppingnum'];
$shoppingatt = $ourphp_adminfont['shoppingatt'];

if(@$_SESSION['username'] == ''){
	exit("<script language=javascript> alert('".$shoppinglogin."');location.replace('".$ourphp_webpath."client/user/?".$ourphp_Language."-login.html');</script>");
}

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "shopping"){

	if($_POST['ourphp_kc'] == '' || $_POST['ourphp_hh'] == ''){
		exit("<script language=javascript> alert('".$shoppingatt."');history.go(-1);</script>");
	}

	if(intval($_POST['sl']) == 0){
		exit("<script language=javascript> alert('".$shoppingnum."');history.go(-1);</script>");
	}

	@$id=intval($_POST['pid'])?$_POST['pid']:null;
	if (!is_numeric($id) || !isset($id)) {
		exit("no!");
	}

	if(empty($_POST['ourphp_sx'])){
	$att = '';
	}else{
	$att = dowith_sql($_POST['ourphp_sx']);
	}
	$result = $db-> sqllist("select id from `ourphp_shoppingcart` where `OP_Shopproductid` = ".$id." && OP_Shopusername = '".$_SESSION['username']."'");
	if(mysql_num_rows($result) < 1){

		$sql="insert into `ourphp_shoppingcart` set 
		`OP_Shopproductid` = '".dowith_sql($id)."',
		`OP_Shopnum` = '".dowith_sql(intval($_POST['sl']))."',
		`OP_Shopusername` = '".$_SESSION['username']."',
		`OP_Shopatt` = '".$att."',
		`OP_Shopkc` = '".dowith_sql(intval($_POST['ourphp_kc']))."',
		`OP_Shophh` = '".dowith_sql($_POST['ourphp_hh'])."',
		`time` = '".date("Y-m-d H:i:s")."'
		";
		$query=mysql_query($sql);
		
	}else{

		echo '';
		
	}
}

function ourphp_productshop($id){
	global $db,$ourphp_webpath;
	$ourphp_rs = $db-> ourphpsql("select id,OP_Title,OP_Number,OP_Goodsno,OP_Brand,OP_Market,OP_Webmarket,OP_Stock,OP_Minimg,OP_Maximg,time,OP_Class,OP_Usermoney,OP_Weight,OP_Freight from `ourphp_product` where `id` = ".$id); 
	if(substr($ourphp_rs[8],0,7) == 'http://'){$minimg = $ourphp_rs[8];}elseif($ourphp_rs[8] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_webpath.$ourphp_rs[8];}
	if(substr($ourphp_rs[9],0,7) == 'http://'){$maximg = $ourphp_rs[9];}elseif($ourphp_rs[9] == ''){$maximg = $ourphp_webpath.'skin/noimage.png';}else{$maximg=$ourphp_webpath.$ourphp_rs[9];}
	$rows = array(
				'id' => $ourphp_rs[0],
				'title' => $ourphp_rs[1],
				'number' => $ourphp_rs[2],
				'goodsno' => $ourphp_rs[3],
				'brand' => explode("|",$ourphp_rs[4]),
				'market' => $ourphp_rs[5],
				'webmarket' => $ourphp_rs[6],
				'stock' => $ourphp_rs[7],
				'minimg' => $minimg,
				'maximg' => $maximg,
				'time' => $ourphp_rs[10],
				'class' => $ourphp_rs[11],
				'usermoney' => $ourphp_rs[12],
				'weight' => $ourphp_rs[13],
				'freight' => $ourphp_rs[14],
	);
	return $rows;
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

$shopset = shopset();
function ourphp_shoppingcart(){
	global $db,$ourphp_webpath,$ourphp_productshop,$shopset; 
	$query = $db-> sqllist("select * from `ourphp_shoppingcart` where `OP_Shopusername` = '".$_SESSION['username']."' order by id desc"); 
	$rows = array();
	$i = 1;
	$zj = '';	
	while($ourphp_rs = mysql_fetch_array($query)){
	
	$ourphp_productshop = ourphp_productshop($ourphp_rs['OP_Shopproductid']);
	$title = $ourphp_productshop['title'];
	if($shopset['scheme'] == 1){
	$usermarket = $ourphp_productshop['webmarket'];
	}elseif($shopset['scheme'] == 2){
	$usermarket = ourphp_usermoney($ourphp_productshop['usermoney'],$ourphp_productshop['webmarket']);
	}
	if(substr($ourphp_productshop['minimg'],0,7) == 'http://'){$minimg = $ourphp_productshop['minimg'];}elseif($ourphp_productshop['minimg'] == ''){$minimg = $ourphp_webpath.'skin/noimage.png';}else{$minimg=$ourphp_productshop['minimg'];}
	$zj += $usermarket * $ourphp_rs['OP_Shopnum'];
			$rows[] = array(
							'i' => $i,
							'id' => $ourphp_productshop['id'],
							'cartid' => $ourphp_rs['id'],
							'title' => $title,
							'number' => $ourphp_rs['OP_Shopnum'],
							'attribute' => $ourphp_rs['OP_Shopatt'],
							'stock' => $ourphp_rs['OP_Shopkc'],
							'barcode' => $ourphp_rs['OP_Shophh'],
							'time' => $ourphp_rs['time'],
							'webmarket' => $ourphp_productshop['webmarket'],
							'usermarket' => $usermarket,
							'img' => $minimg,
							'weight' => $ourphp_productshop['weight'],
							'freight' => $ourphp_productshop['freight'],
							'totalt' => $usermarket * $ourphp_rs['OP_Shopnum'],
							'total' => $zj,
						);
			$i+=1;
	}
	return $rows;
}

function ourphp_userview(){ 
global $ourphp_webpath,$db;
			$ourphp_rs = $db-> ourphpsql("select `OP_Useremail`,`OP_Username`,`OP_Usertel`,`OP_Useradd`,`OP_Usermoney`,`OP_Userintegral` from `ourphp_user` where `OP_Useremail` = '".$_SESSION['username']."'"); 
			$userrows = array(
							'email' => $ourphp_rs[0],
							'name' => $ourphp_rs[1],
							'tel' => $ourphp_rs[2],
							'add' => $ourphp_rs[3],
							'money' => $ourphp_rs[4],
							'integral' => $ourphp_rs[5],

			);
			return $userrows;
}

$smarty->assign('shoppingcart',ourphp_shoppingcart());
$smarty->assign('userop',ourphp_userview());
?>