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

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "add"){
			
			$sql="insert into `ourphp_booksection` set 
			`OP_Booksectiontitle` = '".dowith_sql($_POST["OP_Booksectiontitle"])."',
			`OP_Booksectioncontent` = '".dowith_sql($_POST["OP_Booksectioncontent"])."',
			`OP_Booksectionlanguage` = '".dowith_sql($_POST["OP_Booksectionlanguage"])."',
			`OP_Booksectionsorting` = '".dowith_sql($_POST["OP_Booksectionsorting"])."',
			`time` = '".date("Y-m-d H:i:s")."'
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_book.php?id=ourphps';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){
			
			$sql="delete from ourphp_booksection where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_book.php?id=ourphps';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_book.php?id=ourphps';
			require 'ourphp_remind.php';
			
			}
			
}elseif ($_GET["ourphp_cms"] == "bookdel"){
		
			if (strstr($OP_Adminpower,"35")){
			
			$sql="delete from ourphp_book where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_book.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_book.php?id=ourphps';
			require 'ourphp_remind.php';
			
			}

}elseif ($_GET["ourphp_cms"] == "reply"){
			
			$sql="update `ourphp_book` set 
			`OP_Bookreply` = '".dowith_sql($_POST["OP_Bookreply"])."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_book.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "edit"){

		if (strstr($OP_Adminpower,"34")){
		
			$sql="update `ourphp_booksection` set 
			`OP_Booksectiontitle` = '".dowith_sql($_POST["OP_Booksectiontitle"])."',
			`OP_Booksectioncontent` = '".dowith_sql($_POST["OP_Booksectioncontent"])."',
			`OP_Booksectionlanguage` = '".dowith_sql($_POST["OP_Booksectionlanguage"])."',
			`OP_Booksectionsorting` = '".dowith_sql($_POST["OP_Booksectionsorting"])."',
			`time` = '".date("Y-m-d H:i:s")."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_book.php?id=ourphps';
			require 'ourphp_remind.php';
			
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_book.php?id=ourphps';
		require 'ourphp_remind.php';
			
		}
			
}

function columncycle($id=1){
	global $conn;
	$sql="select `OP_Booksectiontitle` from `ourphp_booksection` where id = $id";
	$ourphp_rs=mysql_fetch_array(mysql_query($sql));
	return $ourphp_rs[0];
}

function Booklist(){
	global $_page,$conn,$smarty;
	$listpage = 40;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_book` order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select * from `ourphp_book` order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs['id'],
						"content" => $ourphp_rs['OP_Bookcontent'],
						"name" => $ourphp_rs['OP_Bookname'],
						"tel" => $ourphp_rs['OP_Booktel'],
						"ip" => $ourphp_rs['OP_Bookip'],
						"class" => columncycle($ourphp_rs['OP_Bookclass']),
						"lang" => $ourphp_rs['OP_Booklang'],
						"time" => $ourphp_rs['time'],
						"reply" => $ourphp_rs['OP_Bookreply']
					);
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
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

function Booksection(){
	global $conn;
	$sql="select * from `ourphp_booksection` order by OP_Booksectionsorting asc";
	$query=mysql_query($sql);
	$rows=array();
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"id" => $ourphp_rs['id'],
						"lang" => $ourphp_rs['OP_Booksectionlanguage'],
						"title" => $ourphp_rs['OP_Booksectiontitle'],
						"content" => $ourphp_rs['OP_Booksectioncontent'],
						"time" => $ourphp_rs['time']
					);
	}
	return $rows;
	mysql_free_result($query);
}

Admin_click('留言管理','ourphp_book.php?id=ourphp');
$smarty->assign("Booklist",Booklist());
$smarty->assign("langlist",Langlist());
$smarty->assign("Booksection",Booksection());

if (isset($_GET["uid"])){
$sql="select * from `ourphp_booksection` where `id` = ".intval($_GET['uid'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_booksection',$ourphp_rs);
mysql_free_result($query);
}
$smarty->display('ourphp_book.html');
?>