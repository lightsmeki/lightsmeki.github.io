<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';
include 'ourphp_page.class.php';
include '../../function/ourphp_navigation.class.php';

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "Batch"){


			if (strstr($OP_Adminpower,"35")){
			
			if (!empty($_POST["op_b"])){
			$op_b = implode(',',$_POST["op_b"]);
			}else{
			$op_b = '';
			}
				
			$sql="delete from ourphp_orders where id in ($op_b)";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_orders.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
				
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_orders.php?id=ourphp';
			require 'ourphp_remind.php';
				
			}	
			
}


function Orderslist(){
	global $_page,$conn,$smarty;
	$listpage = 40;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_orders` order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select `id`,`OP_Ordersname`,`time`,`OP_Ordersnumber`,`OP_Orderspay`,`OP_Orderssend`,`OP_Ordersgotime`,`OP_Integralok` from `ourphp_orders` order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"title" => $ourphp_rs[1],
						"time" => $ourphp_rs[2],
						"number" => $ourphp_rs[3],
						"pay" => $ourphp_rs[4],
						"send" => $ourphp_rs[5],
						"gotime" => $ourphp_rs[6],
						"integralok" => $ourphp_rs[7],
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

Admin_click('订单管理','ourphp_orders.php?id=ourphp');
$smarty->assign("orders",Orderslist());
$smarty->display('ourphp_orders.html');
?>