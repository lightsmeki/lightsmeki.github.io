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
			
			$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Downimg"]));
			$OP_Downdurl = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Downdurl"]));
			
			$OP_Downclass = explode("|",admin_sql($_POST["OP_Downclass"]));
			if ($OP_Downclass[0] == 0){
			$ourphp_font = 4;
			$ourphp_content = $ourphp_adminfont['nocolumn'];
			$ourphp_class = 'ourphp_down.php?id=ourphp';
			require 'ourphp_remind.php';
			exit;
			}
			
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
			
			$sql="insert into `ourphp_down` set 
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
			`OP_Random` = '".randomkeys(18)."',
			`OP_Callback` = 0
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_down.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){

			$query=mysql_query("select `OP_Downimg`,`OP_Downdurl` from `ourphp_down` where id = ".intval($_GET['id']));
			$ourphp_rs=mysql_fetch_array($query);
			if($ourphp_rs[0] != '' || $ourphp_rs[1] != ''){
				include './ourphp_del.php';
				ourphp_imgdel($ourphp_rs[0],$ourphp_rs[1],'');
			}
			
			$sql="delete from ourphp_down where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_down.php?id=ourphp';
			require 'ourphp_remind.php';

						
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_down.php?id=ourphp';
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
			header("location: ./ourphp_cmd.php?id=$op_b&lx=h&xx=down");
			exit;
			}elseif($_POST["h"] == "y") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=y&xx=down");
			exit;
			}elseif($_POST["h"] == "s") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=s&xx=down");
			exit;
			}
			
			if (!empty($_POST["OP_Downattribute"])){
			$OP_Downattribute = implode(',',$_POST["OP_Downattribute"]);
			}else{
			$OP_Downattribute = '';
			}
				
			$sql="update ourphp_down set 
			`OP_Attribute` = '".$OP_Downattribute."'
			 where id in ($op_b)";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_down.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
				
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法编辑内容！';
			$ourphp_class = 'ourphp_down.php?id=ourphp';
			require 'ourphp_remind.php';
				
			}	
			
}

function columncycle($id=1){
	global $conn;
	$sql="select `OP_Columntitle` from `ourphp_column` where id = $id";
	$ourphp_rs=mysql_fetch_array(mysql_query($sql));
	return $ourphp_rs[0];
}

function Downlist(){
	global $_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_down` where `OP_Callback` = 0 order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select id,OP_Downtitle,time,OP_Class,OP_Lang from `ourphp_down` where `OP_Callback` = 0 order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"title" => $ourphp_rs[1],
						"time" => $ourphp_rs[2],
						"class" => columncycle($ourphp_rs[3]),
						"lang" => $ourphp_rs[4]
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
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

$op= new Tree(columnlist(""));
$arr=$op->leaf();
$smarty->assign('downlist',$arr);

Admin_click('下载管理','ourphp_down.php?id=ourphp');
$smarty->assign("down",Downlist());
$smarty->assign("userleve",Userleve());
$smarty->display('ourphp_down.html');
?>