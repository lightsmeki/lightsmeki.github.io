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
	$smarty->assign("page",0);
	}else{
	$smarty->assign("page",$_GET["page"]);
}

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){

		if (strstr($OP_Adminpower,"34")){

			$OP_Articleclass = explode("|",admin_sql($_POST["OP_Articleclass"]));
			if ($OP_Articleclass[0] == 0){
			$ourphp_font = 4;
			$ourphp_content = $ourphp_adminfont['nocolumn'];
			$ourphp_class = 'ourphp_article.php?id=ourphp';
			require 'ourphp_remind.php';
			exit;
			}
			
			if (!admin_sql($_POST["OP_Articledescription"])){
				$OP_Articlecontent = utf8_strcut(strip_tags(admin_sql($_POST["OP_Articlecontent"])), 0, 200);
			}else{
				$OP_Articlecontent = admin_sql($_POST["OP_Articledescription"]);
			}

			//分词
			$word = $OP_Articlecontent;
			$tag = admin_sql($_POST["OP_Articletag"]);
			include '../../function/ourphp_sae.class.php';
			//结束
			
			$OP_Articleclass = explode("|",admin_sql($_POST["OP_Articleclass"]));
			
			if (!empty($_POST["OP_Articleattribute"])){
			$OP_Articleattribute = implode(',',$_POST["OP_Articleattribute"]);
			}else{
			$OP_Articleattribute = '';
			}

			if(empty($_POST["tu"])){
			$OP_Minimg = 'skin/noimage.png';
			}else{
					$con = stripslashes($_POST["OP_Articlecontent"]);
					preg_match_all("/<img.*\>/isU",$con,$ereg);
					@$img=$ereg[0][0];
					$p="#src=('|\")(.*)('|\")#isU";
					preg_match_all ($p, $img, $img1);
					@$OP_Minimg =$img1[2][0];
					if(!$OP_Minimg){
						$OP_Minimg='skin/noimage.png';
					}
			}
			
			$sql="update `ourphp_article` set 
			`OP_Articletitle` = '".admin_sql($_POST["OP_Articletitle"])."',
			`OP_Articleauthor` = '".admin_sql($_POST["OP_Articleauthor"])."',
			`OP_Articlesource` = '".admin_sql($_POST["OP_Articlesource"])."',
			`time` = '".date("Y-m-d H:i:s")."',
			`OP_Articlecontent` = '".admin_sql($_POST["OP_Articlecontent"])."',
			`OP_Tag` = '".$wordtag."',
			`OP_Class` = '".$OP_Articleclass[0]."',
			`OP_Lang` = '".$OP_Articleclass[1]."',
			`OP_Sorting` = '".admin_sql($_POST["OP_Articlesorting"])."',
			`OP_Attribute` = '".$OP_Articleattribute."',
			`OP_Url` = '".admin_sql($_POST["OP_Articleurl"])."',
			`OP_Description` = '".$OP_Articlecontent."',
			`OP_Minimg` = '".$OP_Minimg."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_article.php?id=ourphp&page='.$_GET["page"];
			require 'ourphp_remind.php';
			
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_article.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
			
}

$op= new Tree(columnlist(""));
$arr=$op->leaf();
$smarty->assign('articlelist',$arr);

$sql="select * from `ourphp_article` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_article',$ourphp_rs);
$ourphp_text=explode(",",$ourphp_rs['OP_Attribute']);
for($i=0;$i<sizeof($ourphp_text);$i++){ 
$selected[] = $ourphp_text[$i]; 
}
$smarty->assign('selected',$selected); 
$ourphph_qx=array('头条','热门','滚动','推荐'); 
$smarty->assign('ourphph_qx',$ourphph_qx); 
mysql_free_result($query);
$smarty->display('ourphp_articleview.html');
?>