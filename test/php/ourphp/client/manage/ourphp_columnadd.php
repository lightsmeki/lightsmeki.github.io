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

	if($_POST["OP_Columntitle"] == '' && $_POST["OP_Columntitle_pl"] == ''){
	echo '标题或批量标题不能全部为空。请重新操作 <a href="javascript:history.go(-1)">返回</a>';
	exit;
	}
	
	$templist = str_replace("{L}",admin_sql($_POST["OP_Lang"]),admin_sql($_POST["OP_Templist"]));
	$tempview = str_replace("{L}",admin_sql($_POST["OP_Lang"]),admin_sql($_POST["OP_Tempview"]));
	$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Img"]));
			
			if (!empty($_POST["OP_Userright"])){
			$OP_Userright = implode(',',$_POST["OP_Userright"]);
			}else{
			$OP_Userright = '0';
			}
	
	if(empty($_POST["pl"])){
			//未批量
			$sql="insert into `ourphp_column` set 
			`OP_Uid` = '".admin_sql(intval($_POST["OP_Uid"]))."',
			`OP_Lang` = '".admin_sql($_POST["OP_Lang"])."',
			`OP_Columntitle` = '".admin_sql($_POST["OP_Columntitle"])."',
			`OP_Columntitleto` = '".admin_sql($_POST["OP_Columntitleto"])."',
			`OP_Model` = '".admin_sql($_POST["OP_Model"])."',
			`OP_Templist` = '".$templist."',
			`OP_Tempview` = '".$tempview."',
			`OP_Url` = '".admin_sql($_POST["OP_Url"])."',
			`OP_About` = '".admin_sql($_POST["OP_About"])."',
			`OP_Hide` = '".admin_sql($_POST["OP_Hide"])."',
			`OP_Sorting` = '".admin_sql(intval($_POST["OP_Sorting"]))."',
			`OP_Briefing` = '".admin_sql($_POST["OP_Briefing"])."',
			`OP_Img` = '".$ourphp_xiegang."',
			`OP_Userright` = '".$OP_Userright."',
			`OP_Weight` = '".admin_sql($_POST["OP_Weight"])."'
			";
			$query=mysql_query($sql);
			
			}else{
			
			$ourphp_fgbt = explode("|",admin_sql($_POST["OP_Columntitle_pl"]));
			foreach ($ourphp_fgbt as $op){
			
			$sql="insert into `ourphp_column` set 
			`OP_Uid` = '".admin_sql(intval($_POST["OP_Uid"]))."',
			`OP_Lang` = '".admin_sql($_POST["OP_Lang"])."',
			`OP_Columntitle` = '".$op."',
			`OP_Columntitleto` = '".admin_sql($_POST["OP_Columntitleto"])."',
			`OP_Model` = '".admin_sql($_POST["OP_Model"])."',
			`OP_Templist` = '".$templist."',
			`OP_Tempview` = '".$tempview."',
			`OP_Url` = '".admin_sql($_POST["OP_Url"])."',
			`OP_About` = '".admin_sql($_POST["OP_About"])."',
			`OP_Hide` = '".admin_sql($_POST["OP_Hide"])."',
			`OP_Sorting` = '".admin_sql(intval($_POST["OP_Sorting"]))."',
			`OP_Briefing` = '".admin_sql($_POST["OP_Briefing"])."',
			`OP_Img` = '".$ourphp_xiegang."',
			`OP_Userright` = '".$OP_Userright."',
			`OP_Weight` = '".admin_sql($_POST["OP_Weight"])."'
			";
			$query=mysql_query($sql);
			
			}

	}

			$ourphp_font = 1;
			$ourphp_class = 'ourphp_column.php';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "edit"){

	if (strstr($OP_Adminpower,"34")){
		
	$templist = str_replace("{L}",admin_sql($_POST["OP_Lang"]),admin_sql($_POST["OP_Templist"]));
	$tempview = str_replace("{L}",admin_sql($_POST["OP_Lang"]),admin_sql($_POST["OP_Tempview"]));
	$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Img"]));
	
			if (!empty($_POST["OP_Userright"])){
			$OP_Userright = implode(',',$_POST["OP_Userright"]);
			}else{
			$OP_Userright = '0';
			}
	
			$sql="update `ourphp_column` set 
			`OP_Uid` = '".admin_sql(intval($_POST["OP_Uid"]))."',
			`OP_Lang` = '".admin_sql($_POST["OP_Lang"])."',
			`OP_Columntitle` = '".admin_sql($_POST["OP_Columntitle"])."',
			`OP_Columntitleto` = '".admin_sql($_POST["OP_Columntitleto"])."',
			`OP_Model` = '".admin_sql($_POST["OP_Model"])."',
			`OP_Templist` = '".$templist."',
			`OP_Tempview` = '".$tempview."',
			`OP_Url` = '".admin_sql($_POST["OP_Url"])."',
			`OP_About` = '".admin_sql($_POST["OP_About"])."',
			`OP_Hide` = '".admin_sql($_POST["OP_Hide"])."',
			`OP_Sorting` = '".admin_sql(intval($_POST["OP_Sorting"]))."',
			`OP_Briefing` = '".admin_sql($_POST["OP_Briefing"])."',
			`OP_Img` = '".$ourphp_xiegang."',
			`OP_Userright` = '".$OP_Userright."',
			`OP_Weight` = '".admin_sql($_POST["OP_Weight"])."'
			 where id = ".intval($_GET["id"])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_column.php';
			require 'ourphp_remind.php';
			
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_column.php';
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

function Userleveto(){
	global $conn;
	$sql="select OP_Userlevename from `ourphp_userleve` order by id asc";
	$query=mysql_query($sql);
	$rows[]='任何人';
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=$ourphp_rs[0];
	}
	return $rows;
	mysql_free_result($query);
}

$op= new Tree(columnlist(""));
$arr=$op->leaf();
$smarty->assign('arr',$arr);

Admin_click('创建网站栏目','ourphp_columnadd.php');

if (isset($_GET["ourphp_cms"])){
$sql="select * from `ourphp_column` where `id` = ".intval($_GET["id"])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign("columnedit",$ourphp_rs);

$ourphp_text=explode(",",$ourphp_rs['OP_Userright']);
for($i=0;$i<sizeof($ourphp_text);$i++){ 
$selected[] = $ourphp_text[$i]; 
}
$smarty->assign('selected',$selected); 
$ourphph_qx=Userleveto(); 
$smarty->assign('ourphph_qx',$ourphph_qx); 
mysql_free_result($query);
}
$smarty->assign("langlist",Langlist());
$smarty->assign("userleve",Userleve());
$smarty->display('ourphp_columnadd.html');
?>