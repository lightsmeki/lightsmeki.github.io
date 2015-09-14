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

			$query=mysql_query("select `OP_Minimg`,`OP_Maximg`,`OP_Img` from `ourphp_product` where id = ".intval($_GET['id']));
			$ourphp_rs=mysql_fetch_array($query);
			if($ourphp_rs[0] != '' || $ourphp_rs[1] != '' || $ourphp_rs[2] != ''){
				include './ourphp_del.php';
				ourphp_imgdel($ourphp_rs[0],$ourphp_rs[1],$ourphp_rs[2]);
			}
			
			$sql="delete from ourphp_product where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_productlist.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_productlist.php?id=ourphp';
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
			header("location: ./ourphp_cmd.php?id=$op_b&lx=h&xx=product");
			exit;
			}elseif($_POST["h"] == "y") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=y&xx=product");
			exit;
			}elseif($_POST["h"] == "s") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=s&xx=product");
			exit;
			}
			
			if (!empty($_POST["OP_Attribute"])){
			$OP_Attribute = implode(',',$_POST["OP_Attribute"]);
			}else{
			$OP_Attribute = '';
			}
			
			if (!empty($_POST["down"])){
			$down = implode(',',$_POST["down"]);
			}else{
			$down = '2';
			}
			
			$sql="update ourphp_product set 
			`OP_Attribute` = '".$OP_Attribute."',
			`OP_Down` = '".$down."' 
			 where id in ($op_b)";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_productlist.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
				
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法编辑内容！';
			$ourphp_class = 'ourphp_productlist.php?id=ourphp';
			require 'ourphp_remind.php';
				
			}	
			
}

function columncycle($id=1){
	global $conn;
	$sql="select `OP_Columntitle` from `ourphp_column` where id = $id";
	$ourphp_rs=mysql_fetch_array(mysql_query($sql));
	return $ourphp_rs[0];
}

function pingjia($id,$type){
	global $conn;
	if($type == 'h'){
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_comment` where OP_Class = ".$id." && OP_Vote = 1");
	}elseif($type == 'z'){
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_comment` where OP_Class = ".$id." && OP_Vote = 2");
	}elseif($type == 'c'){
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_comment` where OP_Class = ".$id." && OP_Vote = 3");
	}
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	return $ourphptotal['tiaoshu'];
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
	$sql="select `id`,`OP_Class`,`OP_Lang`,`OP_Title`,`OP_Webmarket`,`OP_Stock`,`OP_Minimg`,`OP_Down`,`time` from `ourphp_product` where `OP_Down` = 2 order by id desc LIMIT ".$start.",".$listpage;
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
						"time" => $ourphp_rs[8],
						"h" => pingjia($ourphp_rs[0],'h'),
						"z" => pingjia($ourphp_rs[0],'z'),
						"c" => pingjia($ourphp_rs[0],'c'),
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

Admin_click('商品管理','ourphp_productlist.php?id=ourphp');
$smarty->assign("product",Productlist());
$smarty->display('ourphp_productlist.html');
?>