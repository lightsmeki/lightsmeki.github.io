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
}elseif ($_GET["ourphp_cms"] == "add"){

			if ($_POST["OP_Key"] == ''){
			exit("<script language=javascript> alert('值不能为空');history.go(-1);</script>");
			}

			$sql="insert into `ourphp_api` set `OP_Key` = '".admin_sql($_POST["OP_Key"])."'";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_api.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "edit"){

		if (strstr($OP_Adminpower,"34")){	
		
			if ($_POST["OP_Key"] == ''){
			exit("<script language=javascript> alert('值不能为空');history.go(-1);</script>");
			}
			
			$sql="update `ourphp_api` set `OP_Key` = '".admin_sql($_POST["OP_Key"])."' where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_api.php?id=ourphp';
			require 'ourphp_remind.php';
			
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_api.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}			
}


function Apilist(){
	global $_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_api` order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select `id`,`OP_Key` from `ourphp_api` order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"key" => explode('|',$ourphp_rs[1]),
						"keyto" => $ourphp_rs[1],
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

$smarty->assign("api",Apilist());
$smarty->display('ourphp_api.html');
?>