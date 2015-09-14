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

if(isset($_GET["page"]) == ""){
	$smarty->assign("page",1);
	}else{
	$smarty->assign("page",$_GET["page"]);
}

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){
		if (strstr($OP_Adminpower,"34")){
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
			
			if (!empty($_POST["OP_Img2"])){
			$OP_Img2 = implode('|',$_POST["OP_Img2"]);
				if (!empty($OP_Img)){
				$OP_imga = $OP_Img2.'|'.$OP_Img;
				}else{
				$OP_imga = $OP_Img2;
				}
			}else{
			$OP_Img2 = '';
			$OP_imga = $OP_Img;
			}
			
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
			
			$sql="update `ourphp_product` set 
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
			`OP_Img` = '".$OP_imga."',
			`OP_Content` = '".admin_sql($_POST["OP_Content"])."',
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
			 where id = ".intval($_GET["id"])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_productlist.php?id=ourphp&page='.$_GET["page"];
			require 'ourphp_remind.php';
			
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_productlist?id=ourphp';
		require 'ourphp_remind.php';
			
		}
}

function Attribute($optype){
	global $conn;
	if($optype == 'op'){
	$sql="select id,OP_Title from `ourphp_productattribute` where `OP_Class` = 0 order by OP_Sorting asc";
	}else{
	$sql="select id,OP_Title,OP_Text from `ourphp_productattribute` where `OP_Class` != 0 order by OP_Sorting asc";
	}
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	if($optype == 'op'){
	
		while($ourphp_rs=mysql_fetch_array($query)){
			$rows[]=array(
							"i" => $i,
							"id" => $ourphp_rs[0],
							"name" => $ourphp_rs[1]
						);
		$i = $i + 1;
		}
		
	}else{
		
		$x=0;
		while($ourphp_rs=mysql_fetch_array($query)){
			$cfsz = explode("|",$ourphp_rs[2]);
			$op=array();
			foreach($cfsz as $u){
								$op[]=$u;
								}
			$rows[] = array(
							'x'=>$x,
							'id'=>$ourphp_rs[0],
							'name'=>$ourphp_rs[1],
							'three'=>$op
							);
			$x+=1;
		}
	
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
						"img" => $ourphp_rs[2],
					);
	$i = $i + 1;
	}
	return $rows;
	mysql_free_result($query);
}


function Usermoney(){
	global $conn;
	$sql="select `OP_Usermoney` from `ourphp_product` where `id` = ".intval($_GET['id'])."";
	$query=mysql_query($sql);
	$ourphp_rs=mysql_fetch_array($query);
	$ourphp_fg = explode("|",$ourphp_rs[0]);
	$rows = '';
	$i=0;
	foreach($ourphp_fg as $op){
		$ourphp_fgo = explode(":",$op);
		$rows[] = array(
						'i' => $i,
						'id' => $ourphp_fgo[0],
						'money' => $ourphp_fgo[1],
						);
		$i+=1;
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

function Pattribute(){
	global $conn;
	$sql="select `OP_Pattribute` from `ourphp_product` where `id` = ".intval($_GET['id'])."";
	$query=mysql_query($sql);
	$ourphp_rs=mysql_fetch_array($query);
	if (!empty($ourphp_rs[0])){
	$ourphp_afg = explode("|",$ourphp_rs[0]);
	$rows = '';
	$i=0;
	foreach($ourphp_afg as $op){
		$ourphp_afgo = explode(":",$op);
		$rows[] = array(
						'i' => $i,
						'class' => $ourphp_afgo[0],
						'name' => $ourphp_afgo[1]
						);
		$i+=1;
	}
	return $rows;
	}
	mysql_free_result($query);
}

function Specifications(){
	global $conn;
	$sql="select `OP_Specifications` from `ourphp_product` where `id` = ".intval($_GET['id'])."";
	$query=mysql_query($sql);
	$ourphp_rs=mysql_fetch_array($query);
	if (!empty($ourphp_rs[0])){
	$OP_Specifications = explode("|",$ourphp_rs[0]);
	$rows = '';
	foreach($OP_Specifications as $op){
										$opo = explode(",",$op);
										$a = '';
										foreach($opo as $opop){
											$a[] = $opop;
										}
										$rows[] = array(
														'three'=>$a
										);
	}
	return $rows;
	}
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

$smarty->assign('Attribute',Attribute('op'));
$smarty->assign('Attributeto',Attribute('oo'));
$smarty->assign('Brand',Brand());
$smarty->assign('Usermoney',Usermoney());
$smarty->assign('Userleve',Userleve());
$smarty->assign('Set',Productset());
$smarty->assign('Pattribute',Pattribute());
$smarty->assign('Specifications',Specifications());
$smarty->assign('Freight',Freight());

$sql="select * from `ourphp_product` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_product',$ourphp_rs);
$ourphp_text=explode(",",$ourphp_rs['OP_Attribute']);
for($i=0;$i<sizeof($ourphp_text);$i++){ 
$selected[] = $ourphp_text[$i];
}
$smarty->assign('selected',$selected); 
$ourphph_qx=array('头条','热门','滚动','推荐'); 
$smarty->assign('ourphph_qx',$ourphph_qx); 

if ($ourphp_rs['OP_Specificationstitle'] != ''){
$rowsop='';
$OP_Specificationstitle = explode(",",$ourphp_rs['OP_Specificationstitle']);
	foreach($OP_Specificationstitle as $op){
		$rowsop[]=array(
						"name" => $op
					); 
	}
}else{
$rowsop = '';
}
$smarty->assign('Specificationstitle',$rowsop);

if ($ourphp_rs['OP_Img'] != ''){
$OP_Img = explode("|",$ourphp_rs['OP_Img']);
$i = 1;
foreach($OP_Img as $u){
    $OP_Imgarr = explode("|",$u);
    foreach($OP_Imgarr as $newstr){
        $rows[]=array(
						"i" => $i,
						"img" => $newstr,
					); 
					$i = $i + 1;
    }
}
}else{
$rows = '';
}
$smarty->assign('productimglist',$rows);

/* if ($ourphp_rs['OP_Brand'] != ''){
$OP_Brand = explode("|",$ourphp_rs['OP_Brand']);
}else{
$OP_Brand = '|';
}
$smarty->assign('Prbrand',$OP_Brand); */

mysql_free_result($query);
$smarty->display('ourphp_productedit.html');
?>