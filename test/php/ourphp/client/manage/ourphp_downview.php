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
		
			$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Downimg"]));
			$OP_Downdurl = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Downdurl"]));
			
			if (!admin_sql($_POST["OP_Downdescription"])){
				$OP_Downcontent = utf8_strcut(strip_tags(admin_sql($_POST["OP_Downcontent"])), 0, 200);
			}else{
				$OP_Downcontent = admin_sql($_POST["OP_Downdescription"]);
			}
			
			//分词
			$word = $OP_Downcontent;
			$tag = admin_sql($_POST["OP_Downtag"]);
			include '../../function/ourphp_sae.class.php';
			//结束
			
			$OP_Downclass = explode("|",admin_sql($_POST["OP_Downclass"]));
			
			if (!empty($_POST["OP_Downattribute"])){
			$OP_Downattribute = implode(',',$_POST["OP_Downattribute"]);
			}else{
			$OP_Downattribute = '';
			}
			
			if (!empty($_POST["OP_Downsetup"])){
			$OP_Downsetup = implode(',',$_POST["OP_Downsetup"]);
			}else{
			$OP_Downsetup = '';
			}

			if (!empty($_POST["OP_Downrights"])){
			$OP_Downrights = implode(',',$_POST["OP_Downrights"]);
			}else{
			$OP_Downrights = '0';
			}
			
			$sql="update `ourphp_down` set 
			`OP_Downtitle` = '".admin_sql($_POST["OP_Downtitle"])."',
			`time` = '".date("Y-m-d H:i:s")."',
			`OP_Downimg` = '".$ourphp_xiegang."',
			`OP_Downdurl` = '".$OP_Downdurl."',
			`OP_Downcontent` = '".admin_sql($_POST["OP_Downcontent"])."',
			`OP_Downempower` = '".admin_sql($_POST["OP_Downempower"])."',
			`OP_Downtype` = '".admin_sql($_POST["OP_Downtype"])."',
			`OP_Downlang` = '".admin_sql($_POST["OP_Downlang"])."',
			`OP_Class` = '".$OP_Downclass[0]."',
			`OP_Lang` = '".$OP_Downclass[1]."',
			`OP_Downsize` = '".admin_sql($_POST["OP_Downsize"]).$_POST["kb"]."',
			`OP_Downmake` = '".admin_sql($_POST["OP_Downmake"])."',
			`OP_Downsetup` = '".$OP_Downsetup."',
			`OP_Tag` = '".$wordtag."',
			`OP_Downrights` = '".$OP_Downrights."',
			`OP_Sorting` = '".admin_sql($_POST["OP_Downsorting"])."',
			`OP_Attribute` = '".$OP_Downattribute."',
			`OP_Url` = '".admin_sql($_POST["OP_Downurl"])."',
			`OP_Description` = '".$OP_Downcontent."',
			`OP_Random` = '".randomkeys(18)."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_down.php?id=ourphp&page='.$_GET["page"];
			require 'ourphp_remind.php';

		
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_down.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
		
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
$smarty->assign('downlist',$arr);


$sql="select * from `ourphp_down` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_down',$ourphp_rs);

//属性
$ourphp_text=explode(",",$ourphp_rs['OP_Attribute']);
for($i=0;$i<sizeof($ourphp_text);$i++){ 
$selected[] = $ourphp_text[$i]; 
}
$smarty->assign('selected',$selected); 
$ourphph_qx=array('头条','热门','滚动','推荐'); 
$smarty->assign('ourphph_qx',$ourphph_qx); 

//运行环境
$ourphp_text2=explode(",",$ourphp_rs['OP_Downsetup']);
for($o=0;$o<sizeof($ourphp_text2);$o++){ 
$selected2[] = $ourphp_text2[$o]; 
} 
$smarty->assign('selected2',$selected2); 
$ourphph_qx2=array('Win 98','Win XP','Win 7','Win 8','Win 9','Linux','Mac OS'); 
$smarty->assign('ourphph_qx2',$ourphph_qx2);

$ourphp_text3=explode(",",$ourphp_rs['OP_Downrights']);
for($i=0;$i<sizeof($ourphp_text3);$i++){ 
$selected3[] = $ourphp_text3[$i]; 
}
$smarty->assign('selected3',$selected3); 
$ourphph_qx3=Userleveto(); 
$smarty->assign('ourphph_qx3',$ourphph_qx3); 

mysql_free_result($query);
$smarty->display('ourphp_downview.html');
?>