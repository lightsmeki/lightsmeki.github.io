<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';
include 'ourphp_page.class.php';

if(isset($_GET["page"]) == ""){
	$smarty->assign("page",1);
	}else{
	$smarty->assign("page",$_GET["page"]);
}

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){
			
			$query=mysql_query("select `OP_Photocminimg`,`OP_Photoimg` from `ourphp_photo` where id = ".intval($_GET['id']));
			$ourphp_rs=mysql_fetch_array($query);
			if($ourphp_rs[0] != '' || $ourphp_rs[1] != ''){
				include './ourphp_del.php';
				ourphp_imgdel($ourphp_rs[0],'',$ourphp_rs[1]);
			}
			
			$sql="delete from ourphp_photo where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_photo.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_photo.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}
}elseif ($_GET["ourphp_cms"] == "Batch"){


			if (strstr($OP_Adminpower,"34")){
			
			if (!empty($_POST["op_b"])){
			$op_b = implode(',',$_POST["op_b"]);
			}else{
			$op_b = '';
			}
			
			if ($_POST["h"] == "h") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=h&xx=photo");
			exit;
			}elseif($_POST["h"] == "y") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=y&xx=photo");
			exit;
			}elseif($_POST["h"] == "s") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=s&xx=photo");
			exit;
			}
			
			if (!empty($_POST["OP_Photoattribute"])){
			$OP_Photoattribute = implode(',',$_POST["OP_Photoattribute"]);
			}else{
			$OP_Photoattribute = '';
			}
				
			$sql="update ourphp_photo set 
			`OP_Attribute` = '".$OP_Photoattribute."'
			 where id in ($op_b)";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_photo.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
				
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法编辑内容！';
			$ourphp_class = 'ourphp_photo.php?id=ourphp';
			require 'ourphp_remind.php';
				
			}	
			
}

function columncycle($id=1){
	global $conn;
	$sql="select `OP_Columntitle` from `ourphp_column` where id = $id";
	$ourphp_rs=mysql_fetch_array(mysql_query($sql));
	return $ourphp_rs[0];
}

function Photolist(){
	global $_page,$conn,$smarty;
	$listpage = 20;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_photo` where `OP_Callback` = 0 order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select `id`,`OP_Phototitle`,`time`,`OP_Photocminimg`,`OP_Class`,`OP_Lang` from `ourphp_photo` where `OP_Callback` = 0 order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"title" => $ourphp_rs[1],
						"time" => $ourphp_rs[2],
						"img" => $ourphp_rs[3],
						"class" => columncycle($ourphp_rs[4]),
						"lang" => $ourphp_rs[5]
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

Admin_click('图集管理','ourphp_photo.php?id=ourphp');
$smarty->assign("photo",Photolist());
$smarty->display('ourphp_photo.html');
?>