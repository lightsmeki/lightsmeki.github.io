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
}elseif ($_GET["ourphp_cms"] == "batch"){

			if (strstr($OP_Adminpower,"34")){
			
			for($i = 0; $i < count($_POST["op_b"]); $i ++){
			$sql="update ourphp_column set 
			`OP_Columntitle` = '".$_POST["title"][$i]."',
			`OP_Columntitleto` = '".$_POST["titleto"][$i]."',
			`OP_Weight` = '".$_POST["weight"][$i]."',
			`OP_Hide` = '".$_POST["hide"][$i]."',
			`OP_Sorting` = '".$_POST["sorting"][$i]."'
			 where `id` = ".intval($_POST["op_b"][$i]);
			$query=mysql_query($sql);
			}

			$ourphp_font = 1;
			$ourphp_class = 'ourphp_column.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法编辑内容！';
			$ourphp_class = 'ourphp_column.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}
}

function Langlist(){
	global $conn;
	$sql="select * from `ourphp_lang` order by id asc";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs['id'],
						"lang" => $ourphp_rs['OP_Lang'],
						"font" => $ourphp_rs['OP_Font'],
						"default" => $ourphp_rs['OP_Default'],
						"note" => $ourphp_rs['OP_Note'],
						"langtitle" => $ourphp_rs['OP_Langtitle'],
						"keywords" => $ourphp_rs['OP_Langkeywords'],
						"description" => $ourphp_rs['OP_Langdescription']
					);
	}
	return $rows;
	mysql_free_result($query);
}

$op= new Tree(columnlist(""));
$arr=$op->leaf();
$smarty->assign('arr',$arr);
$smarty->assign("langlist",Langlist());
$smarty->display('ourphp_column_batch.html');
?>