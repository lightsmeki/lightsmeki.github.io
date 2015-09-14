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
			$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Bannerimg"]));
			$sql="insert into `ourphp_banner` set 
			`OP_Bannerimg` = '".$ourphp_xiegang."',
			`OP_Bannertitle` = '".admin_sql($_POST["OP_Bannertitle"])."',
			`OP_Bannerurl` = '".admin_sql($_POST["OP_Bannerurl"])."',
			`OP_Bannerlang` = '".admin_sql($_POST["OP_Bannerlang"])."',
			`time` = '".date("Y-m-d H:i:s")."',
			`OP_Bannerclass` = '".admin_sql($_POST["OP_Bannerclass"])."'
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_banner.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "del"){


			if (strstr($OP_Adminpower,"35")){
			
			$query=mysql_query("select `OP_Bannerimg` from `ourphp_banner` where id = ".intval($_GET['id']));
			$ourphp_rs=mysql_fetch_array($query);
			if($ourphp_rs[0] != ''){
				include './ourphp_del.php';
				ourphp_imgdel($ourphp_rs[0]);
			}
				
			$sql="delete from ourphp_banner where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_banner.php?id=ourphp';
			require 'ourphp_remind.php';

			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_banner.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}
}

function Langlist(){
	global $conn;
	$sql="select id,OP_Lang,OP_Font,OP_Default from `ourphp_lang` order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs[0],
						"lang" => $ourphp_rs[1],
						"font" => $ourphp_rs[2],
						"default" => $ourphp_rs[3]
					);
	}
	return $rows;
	mysql_free_result($query);
}

function Bannerlist(){
	global $_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_banner` order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select id,OP_Bannerimg,OP_Bannertitle,OP_Bannerurl,OP_Bannerlang,time,OP_Bannerclass from `ourphp_banner` order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"img" => $ourphp_rs[1],
						"title" => $ourphp_rs[2],
						"url" => $ourphp_rs[3],
						"lang" => $ourphp_rs[4],
						"time" => $ourphp_rs[5],
						"class" => $ourphp_rs[6],
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

Admin_click('Banner管理','ourphp_banner.php?id=ourphp');
$smarty->assign("langlist",Langlist());
$smarty->assign("banner",Bannerlist());
$smarty->display('ourphp_banner.html');
?>