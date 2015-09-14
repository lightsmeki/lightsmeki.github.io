<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';
include '../../function/ourphp_navigation.class.php';
include '../../function/ourphp_Tree.class.php';


if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "add"){

			$OP_Class = explode("|",admin_sql($_POST["OP_Class"]));
			if ($OP_Class[0] == 0){
			$ourphp_font = 4;
			$ourphp_content = $ourphp_adminfont['nocolumn'];
			$ourphp_class = 'ourphp_productlist.php?id=ourphp';
			require 'ourphp_remind.php';
			exit;
			}
			
			$OP_Minimg = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Minimg"]));
			$OP_Maximg = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Maximg"]));
			$OP_Img = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Img"]));
			
			if (!admin_sql($_POST["OP_Description"])){
				$OP_Description = utf8_strcut(strip_tags(admin_sql($_POST["OP_Content"])), 0, 200);
			}else{
				$OP_Description = admin_sql($_POST["OP_Description"]);
			}
			
			//分词
			$word = $OP_Description;
			$tag = admin_sql($_POST["OP_Tag"]);
			include '../../function/ourphp_sae.class.php';
			//结束
			
			if (!empty($_POST["OP_Attribute"])){
			$OP_Attribute = implode(',',$_POST["OP_Attribute"]);
			}else{
			$OP_Attribute = '';
			}
			
			if (!empty($_POST["OP_Pattribute"])){
			$OP_Pattribute = implode('|',$_POST["OP_Pattribute"]);
			}else{
			$OP_Pattribute = '';
			}
			
			if (!empty($_POST["optitle"])){
			$optitle = implode(',',$_POST["optitle"]);
			}else{
			$optitle = '';
			}

			if (!empty($_POST["optitleid"])){
			$optitleid = implode(',',$_POST["optitleid"]);
			}else{
			$optitleid = '';
			}
			
			if (!empty($_POST["op"])){
			$a = implode(',',$_POST["op"]);
			$b = str_replace(',|,','|',$a);
			$OP_Specifications = str_replace(',|','',$b);
			}else{
			$OP_Specifications = '';
			}
			
			if (!empty($_POST["OP_Userj"])){
			$c = implode(':',$_POST["OP_Userj"]);
			$d = str_replace(':|:','|',$c);
			$OP_Usermoney = str_replace(':|','',$d);
			}else{
			$OP_Usermoney = '';
			}
			
			$sql="insert into `ourphp_product` set 
			`OP_Class` = '".$OP_Class[0]."',
			`OP_Lang` = '".$OP_Class[1]."',
			`OP_Title` = '".admin_sql($_POST["OP_Title"])."',
			`OP_Number` = '".admin_sql($_POST["OP_Number"])."',
			`OP_Goodsno` = '".admin_sql($_POST["OP_Goodsno"])."',
			`OP_Brand` = '".admin_sql($_POST["OP_Brand"])."',
			`OP_Market` = '".admin_sql($_POST["OP_Market"])."',
			`OP_Webmarket` = '".admin_sql($_POST["OP_Webmarket"])."',
			`OP_Stock` = '".admin_sql($_POST["OP_Stock"])."',
			`OP_Usermoney` = '".$OP_Usermoney."',
			`OP_Specificationsid` = '".$optitleid."',
			`OP_Specificationstitle` = '".$optitle."',
			`OP_Specifications` = '".$OP_Specifications."',
			`OP_Pattribute` = '".$OP_Pattribute."',
			`OP_Minimg` = '".$OP_Minimg."',
			`OP_Maximg` = '".$OP_Maximg."',
			`OP_Img` = '".$OP_Img."',
			`OP_Content` = '".admin_sql($_POST["OP_Content"])."',
			`OP_Down` = '2',
			`OP_Weight` = '".intval($_POST["OP_Weight"])."',
			`OP_Freight` = '".intval($_POST["OP_Freight"])."',
			`OP_Tag` = '".$wordtag."',
			`OP_Sorting` = '".admin_sql($_POST["OP_Sorting"])."',
			`OP_Attribute` = '".$OP_Attribute."',
			`OP_Url` = '".admin_sql($_POST["OP_Url"])."',
			`OP_Description` = '".$OP_Description."',
			`time` = '".date("Y-m-d H:i:s")."',
			`OP_Integral` = '".admin_sql($_POST["OP_Integral"])."',
			`OP_Integralok` = '".admin_sql($_POST["OP_Integralok"])."',
			`OP_Integralexchange` = '".admin_sql($_POST["OP_Integralexchange"])."'
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_productlist.php?id=ourphp';
			require 'ourphp_remind.php';
}

function Attribute(){
	global $conn;
	$sql="select id,OP_Title from `ourphp_productattribute` where `OP_Class` = 0 order by OP_Sorting asc";
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1]
					);
	$i = $i + 1;
	}
	return $rows;
	mysql_free_result($query);
}

function Brand(){
	global $conn;
	$sql="select id,OP_Brand,OP_Img from `ourphp_productcp` where `OP_Class` = 2 order by id desc";
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1],
						"img" => $ourphp_rs[2]
					);
	$i = $i + 1;
	}
	return $rows;
	mysql_free_result($query);
}

function Userleve(){
	global $conn;
	$sql="select id,OP_Userlevename from `ourphp_userleve` order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs[0],
						"name" => $ourphp_rs[1]
					);
	}
	return $rows;
	mysql_free_result($query);
}

function Productset(){
	global $conn;
	$sql="select OP_Pattern,OP_Scheme from `ourphp_productset` where id=1";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"set" => $ourphp_rs[0],
						"scheme" => $ourphp_rs[1]
					);
	}
	return $rows;
	mysql_free_result($query);
}

function Freight(){
	global $conn;
	$sql="select id,OP_Freightname from `ourphp_freight` order by OP_Freightdefault desc,id desc";
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"title" => $ourphp_rs[1],
					);
	$i = $i + 1;
	}
	return $rows;
	mysql_free_result($query);
}


$op= new Tree(columnlist(""));
$arr=$op->leaf();
$smarty->assign('product',$arr);


$smarty->assign('Attribute',Attribute());
$smarty->assign('Brand',Brand());
$smarty->assign('Userleve',Userleve());
$smarty->assign('Set',Productset());
$smarty->assign('Freight',Freight());
$smarty->display('ourphp_product.html');
?>