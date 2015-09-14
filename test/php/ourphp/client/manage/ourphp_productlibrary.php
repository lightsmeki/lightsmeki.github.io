<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';
include 'ourphp_page.class.php';

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){
		
			$sql="delete from ourphp_product where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_productlibrary.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_productlibrary.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}
}elseif ($_GET["ourphp_cms"] == "xj"){

			if (strstr($OP_Adminpower,"34")){
			
			if (!empty($_POST["op_xj"])){
			$op_xj = implode(',',$_POST["op_xj"]);
			}else{
			$op_xj = '';
			}
			
			$sql="update ourphp_product set `OP_Down` = 2 where id in ($op_xj)";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_productlibrary.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
				
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法编辑内容！';
			$ourphp_class = 'ourphp_productlibrary.php?id=ourphp';
			require 'ourphp_remind.php';
				
			}	
			
}

function columncycle($id=1){
	global $conn;
	$sql="select `OP_Columntitle` from `ourphp_column` where id = $id";
	$ourphp_rs=mysql_fetch_array(mysql_query($sql));
	return $ourphp_rs[0];
}

function Productlist(){
	global $_page,$conn,$smarty;
	$listpage = 15;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_product` order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select `id`,`OP_Class`,`OP_Lang`,`OP_Title`,`OP_Webmarket`,`OP_Stock`,`OP_Minimg`,`OP_Down`,`time` from `ourphp_product` where `OP_Down` = 1 order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"class" => columncycle($ourphp_rs[1]),
						"lang" => $ourphp_rs[2],
						"title" => $ourphp_rs[3],
						"webmarket" => $ourphp_rs[4],
						"stock" => $ourphp_rs[5],
						"minimg" => $ourphp_rs[6],
						"down" => $ourphp_rs[7],
						"time" => $ourphp_rs[8]
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

$smarty->assign("product",Productlist());
$smarty->display('ourphp_productlibrary.html');
?>