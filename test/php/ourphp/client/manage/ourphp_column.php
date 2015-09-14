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
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){
			
			$sql="select OP_Uid from `ourphp_column` where OP_Uid = ".intval($_GET['id'])."";
			$query=mysql_num_rows(mysql_query($sql));
			if ($query >= 1){
							$ourphp_font = 4;
							$ourphp_content = '请先删除它下面的子栏目!';
							$ourphp_class = 'ourphp_column.php';
							require 'ourphp_remind.php';
			}else{
			
				$query=mysql_query("select `OP_Img` from `ourphp_column` where id = ".intval($_GET['id']));
				$ourphp_rs=mysql_fetch_array($query);
				if($ourphp_rs[0] != ''){
					include './ourphp_del.php';
					ourphp_imgdel($ourphp_rs[0]);
				}
				
				$queryto=mysql_query("delete from `ourphp_column` where id = ".intval($_GET['id']));
				$ourphp_font = 2;
				$ourphp_class = 'ourphp_column.php';
				require 'ourphp_remind.php';
			}
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_column.php';
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

Admin_click('网站栏目列表','ourphp_column.php');
$smarty->assign("langlist",Langlist());
$smarty->display('ourphp_column.html');
?>