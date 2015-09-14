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

if(isset($_GET["page"]) == ""){
	$smarty->assign("page",1);
	}else{
	$smarty->assign("page",$_GET["page"]);
}

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "add"){

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
			
			$sql="insert into `ourphp_article` set 
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
			`OP_Minimg` = '".$OP_Minimg."',
			`OP_Callback` = 0
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_article.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){
			
			$sql="delete from ourphp_article where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_article.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_article.php?id=ourphp';
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
			header("location: ./ourphp_cmd.php?id=$op_b&lx=h&xx=article");
			exit;
			}elseif($_POST["h"] == "y") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=y&xx=article");
			exit;
			}elseif($_POST["h"] == "s") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=s&xx=article");
			exit;
			}
			
			if (!empty($_POST["OP_Articleattribute"])){
			$OP_Articleattribute = implode(',',$_POST["OP_Articleattribute"]);
			}else{
			$OP_Articleattribute = '';
			}
				
			$sql="update ourphp_article set 
			`OP_Attribute` = '".$OP_Articleattribute."'
			 where id in ($op_b)";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_article.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
				
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法编辑内容！';
			$ourphp_class = 'ourphp_article.php?id=ourphp';
			require 'ourphp_remind.php';
				
			}	
			
}

function columncycle($id=1){
	global $conn;
	$sql="select `OP_Columntitle` from `ourphp_column` where id = $id";
	$ourphp_rs=mysql_fetch_array(mysql_query($sql));
	return $ourphp_rs[0];
}

function Articlelist(){
	global $_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_article` where `OP_Callback` = 0 order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select id,OP_Articletitle,OP_Articleauthor,OP_Articlesource,time,OP_Articlecontent,OP_Class,OP_Lang,OP_Sorting from `ourphp_article` where `OP_Callback` = 0 order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"title" => $ourphp_rs[1],
						"author" => $ourphp_rs[2],
						"source" => $ourphp_rs[3],
						"time" => $ourphp_rs[4],
						"content" => $ourphp_rs[5],
						"class" => columncycle($ourphp_rs[6]),
						"lang" => $ourphp_rs[7],
						"sorting" => $ourphp_rs[8]
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

$op= new Tree(columnlist(""));
$arr=$op->leaf();
$smarty->assign('articlelist',$arr);

Admin_click('文章管理','ourphp_article.php?id=ourphp');
$smarty->assign("article",Articlelist());
$smarty->display('ourphp_article.html');
?>