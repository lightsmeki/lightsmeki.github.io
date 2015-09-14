<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "del"){

	$query = $db-> sqllist("select `id`,`OP_Orderspay`,`OP_Orderssend` from `ourphp_orders` where `id` = ".intval($_GET['id'])." && `OP_Ordersnumber` = '".dowith_sql($_GET['dh'])."'");
	$ourphp_rs = mysql_fetch_array($query);
	if(!mysql_num_rows($query)){
		exit("no!");
	}
	if($ourphp_rs[1] == 2){
		exit("no!");
	}
	if($ourphp_rs[2] == 2){
		exit("no!");
	}
	
	$query = $db-> sqllist("delete from `ourphp_orders` where `id` = '".intval($_GET['id'])."'"); 
	exit("<script language=javascript>location.replace('".$ourphp_webpath."client/user/?".$ourphp_Language."-usershopping.html');</script>");
}

function ourphp_orderslist(){
	global $db,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_orders` where `OP_Ordersemail` = '".$_SESSION['username']."'");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	
	$query = $db-> sqllist("select `id`,`OP_Ordersname`,`OP_Ordersid`,`OP_Ordersnum`,`OP_Ordersusetext`,`OP_Ordersproductatt`,`OP_Orderswebmarket`,`OP_Ordersusermarket`,`OP_Ordersnumber`,`OP_Orderspay`,`OP_Orderssend`,`OP_Ordersexpress`,`OP_Ordersexpressnum`,`OP_Ordersfreight` from `ourphp_orders` where `OP_Ordersemail` = '".$_SESSION['username']."' order by id desc LIMIT ".$start.",".$listpage); 
	$rows = array();
	$i = 1;
	while($ourphp_rs = mysql_fetch_array($query)){
			$rows[] = array(
							'i' => $i,
							'id' => $ourphp_rs[0],
							'title' => $ourphp_rs[1],
							'prid' => $ourphp_rs[2],
							'num' => $ourphp_rs[3],
							'text' => $ourphp_rs[4],
							'pratt' => $ourphp_rs[5],
							'webmarket' => $ourphp_rs[6],
							'usermarket' => $ourphp_rs[7],
							'number' => $ourphp_rs[8],
							'pay' => $ourphp_rs[9],
							'send' => $ourphp_rs[10],
							'express' => $ourphp_rs[11],
							'expressnum' => $ourphp_rs[12],
							'freight' => $ourphp_rs[13],
						);
			$i+=1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
}

$smarty->assign('orderslist',ourphp_orderslist());
?>