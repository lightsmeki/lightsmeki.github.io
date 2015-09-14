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
			
			$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Videoimg"]));
			$OP_Videoclass = explode("|",admin_sql($_POST["OP_Videoclass"]));
			if ($OP_Videoclass[0] == 0){
			$ourphp_font = 4;
			$ourphp_content = $ourphp_adminfont['nocolumn'];
			$ourphp_class = 'ourphp_video.php?id=ourphp';
			require 'ourphp_remind.php';
			exit;
			}
			
			if (!admin_sql($_POST["OP_Videodescription"])){
				$OP_Videocontent = utf8_strcut(strip_tags(admin_sql($_POST["OP_Videocontent"])), 0, 200);
			}else{
				$OP_Videocontent = admin_sql($_POST["OP_Videodescription"]);
			}
			
			//分词
			$word = $OP_Videocontent;
			$tag = admin_sql($_POST["OP_Videotag"]);
			include '../../function/ourphp_sae.class.php';
			//结束
			
			if (!empty($_POST["OP_Videoattribute"])){
			$OP_Videoattribute = implode(',',$_POST["OP_Videoattribute"]);
			}else{
			$OP_Videoattribute = '';
			}
			
			$sql="insert into `ourphp_video` set 
			`OP_Videotitle` = '".admin_sql($_POST["OP_Videotitle"])."',
			`time` = '".date("Y-m-d H:i:s")."',
			`OP_Videoimg` = '".$ourphp_xiegang."',
			`OP_Videovurl` = '".admin_sql($_POST["OP_Videovurl"])."',
			`OP_Videoformat` = '".admin_sql($_POST["OP_Videoformat"])."',
			`OP_Videowidth` = '".admin_sql($_POST["OP_Videowidth"])."',
			`OP_Videoheight` = '".admin_sql($_POST["OP_Videoheight"])."',
			`OP_Videocontent` = '".admin_sql($_POST["OP_Videocontent"])."',
			`OP_Class` = '".$OP_Videoclass[0]."',
			`OP_Lang` = '".$OP_Videoclass[1]."',
			`OP_Tag` = '".$wordtag."',
			`OP_Sorting` = '".admin_sql($_POST["OP_Videosorting"])."',
			`OP_Attribute` = '".$OP_Videoattribute."',
			`OP_Url` = '".admin_sql($_POST["OP_Videourl"])."',
			`OP_Description` = '".$OP_Videocontent."',
			`OP_Callback` = 0
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_video.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){

			$query=mysql_query("select `OP_Videoimg` from `ourphp_video` where id = ".intval($_GET['id']));
			$ourphp_rs=mysql_fetch_array($query);
			if($ourphp_rs[0] != ''){
				include './ourphp_del.php';
				ourphp_imgdel($ourphp_rs[0]);
			}
			
			$sql="delete from ourphp_video where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_video.php?id=ourphp';
			require 'ourphp_remind.php';

						
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_video.php?id=ourphp';
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
			header("location: ./ourphp_cmd.php?id=$op_b&lx=h&xx=video");
			exit;
			}elseif($_POST["h"] == "y") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=y&xx=video");
			exit;
			}elseif($_POST["h"] == "s") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=s&xx=video");
			exit;
			}
			
			if (!empty($_POST["OP_Videoattribute"])){
			$OP_Videoattribute = implode(',',$_POST["OP_Videoattribute"]);
			}else{
			$OP_Videoattribute = '';
			}
				
			$sql="update ourphp_video set 
			`OP_Attribute` = '".$OP_Videoattribute."'
			 where id in ($op_b)";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_video.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
				
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法编辑内容！';
			$ourphp_class = 'ourphp_video.php?id=ourphp';
			require 'ourphp_remind.php';
				
			}	
			
}

function columncycle($id=1){
	global $conn;
	$sql="select `OP_Columntitle` from `ourphp_column` where id = $id";
	$ourphp_rs=mysql_fetch_array(mysql_query($sql));
	return $ourphp_rs[0];
}

function Videolist(){
	global $_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_video` where `OP_Callback` = 0 order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select id,OP_Videotitle,OP_Videoimg,time,OP_Class,OP_Lang from `ourphp_video` where `OP_Callback` = 0 order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"title" => $ourphp_rs[1],
						"img" => $ourphp_rs[2],
						"time" => $ourphp_rs[3],
						"class" => columncycle($ourphp_rs[4]),
						"lang" => $ourphp_rs[5]
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
$smarty->assign('videolist',$arr);

Admin_click('视频管理','ourphp_video.php?id=ourphp');
$smarty->assign("video",Videolist());
$smarty->display('ourphp_video.html');
?>