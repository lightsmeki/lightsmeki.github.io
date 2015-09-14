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
include '../../function/ourphp_Tree.class.php';

if(isset($_GET["page"]) == ""){
	$smarty->assign("page",1);
	}else{
	$smarty->assign("page",$_GET["page"]);
}

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){
			
			$sql="update `ourphp_integral` set 
			`OP_Iname` = '".admin_sql($_POST["title"])."',
			`OP_Iintegral` = '".admin_sql($_POST["integral"])."',
			`OP_Iconfirm` = '".admin_sql($_POST["confirm"])."'
			 where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_integral.php?opcms=ourphp&page='.intval($_GET['page']);
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){
			
			$sql="delete from ourphp_integral where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_integral.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_integral.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}
}


function integrallist(){
	global $_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_integral` order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select `id`,`OP_Iname`,`OP_Iintegral`,`OP_Iconfirm`,`OP_Iuseremail`,`OP_ITime`,`time` from `ourphp_integral` order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"title" => $ourphp_rs[1],
						"integral" => $ourphp_rs[2],
						"confirm" => $ourphp_rs[3],
						"useremail" => $ourphp_rs[4],
						"lqtime" => $ourphp_rs[5],
						"time" => $ourphp_rs[6],
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

Admin_click('积分领取管理','ourphp_integral.php?id=ourphp');
$smarty->assign("integral",integrallist());

if($_GET['opcms'] != 'ourphp'){
$sql="select * from `ourphp_integral` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_integral',$ourphp_rs);
mysql_free_result($query);
}

$smarty->display('ourphp_integral.html');
?>