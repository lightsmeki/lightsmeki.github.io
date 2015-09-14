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

if(isset($_GET["opcms"]) == ""){
	$mx = 'article';
}else{
	$mx = $_GET["opcms"];
}
if(isset($_GET["page"]) == ""){
	$smarty->assign("page",1);
	}else{
	$smarty->assign("page",$_GET["page"]);
}

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){
			$sql="update `ourphp_".$_GET["mx"]."` set `OP_Callback` = 0 where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_callback.php?ourphp='.$_GET["mx"];
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){
			
			$sql="delete from ourphp_".$_GET["mx"]." where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_callback.php?ourphp='.$_GET["mx"];
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_callback.php?ourphp='.$_GET["mx"];
			require 'ourphp_remind.php';
			
			}
}

function columncycle($id=1){
	global $conn;
	$sql="select `OP_Columntitle` from `ourphp_column` where id = $id";
	$ourphp_rs=mysql_fetch_array(mysql_query($sql));
	return $ourphp_rs[0];
}

function Callbacklist(){
	global $mx,$_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_".$mx."` where `OP_Callback` = 1 order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	if($mx=='article'){
	$sql="select id,OP_Articletitle,OP_Class,OP_Lang,time from `ourphp_".$mx."` where `OP_Callback` = 1 order by id desc LIMIT ".$start.",".$listpage;
	}elseif($mx=='photo'){
	$sql="select id,OP_Phototitle,OP_Class,OP_Lang,time from `ourphp_".$mx."` where `OP_Callback` = 1 order by id desc LIMIT ".$start.",".$listpage;
	}elseif($mx=='video'){
	$sql="select id,OP_Videotitle,OP_Class,OP_Lang,time from `ourphp_".$mx."` where `OP_Callback` = 1 order by id desc LIMIT ".$start.",".$listpage;
	}elseif($mx=='down'){
	$sql="select id,OP_Downtitle,OP_Class,OP_Lang,time from `ourphp_".$mx."` where `OP_Callback` = 1 order by id desc LIMIT ".$start.",".$listpage;
	}elseif($mx=='job'){
	$sql="select id,OP_Jobtitle,OP_Class,OP_Lang,time from `ourphp_".$mx."` where `OP_Callback` = 1 order by id desc LIMIT ".$start.",".$listpage;
	}
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"title" => $ourphp_rs[1],
						"time" => $ourphp_rs[4],
						"class" => columncycle($ourphp_rs[2]),
						"lang" => $ourphp_rs[3]
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

$smarty->assign("Callbacklist",Callbacklist());
$smarty->display('ourphp_callback.html');
?>