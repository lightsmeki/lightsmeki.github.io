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
}elseif ($_GET["ourphp_cms"] == "reply"){

			if (strstr($OP_Adminpower,"34")){
			
			$sql="update `ourphp_comment` set 
			`OP_Gocontent` = '".admin_sql($_POST["OP_Gocontent"])."',
			`OP_Gotime` = '".date("Y-m-d H:i:s")."'
			 where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_comment.php?opcms=articleview';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法编辑内容！';
			$ourphp_class = 'ourphp_comment.php?opcms=articleview';
			require 'ourphp_remind.php';
			
			}
			
}elseif ($_GET["ourphp_cms"] == "Batch"){


			if (strstr($OP_Adminpower,"35")){
			
			if (!empty($_POST["op_b"])){
			$op_b = implode(',',$_POST["op_b"]);
			}else{
			$op_b = '';
			}
				
			$sql="delete from ourphp_comment where id in ($op_b)";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_comment.php?opcms=articleview';
			require 'ourphp_remind.php';
			
			}else{
				
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_comment.php?opcms=articleview';
			require 'ourphp_remind.php';
				
			}	
			
}

function ourphp_comment($id,$type){
global $ourphp_webpath;

switch($type){
case "articleview":
	$sql="select id,OP_Class,OP_Articletitle,OP_Lang from `ourphp_article` where id = ".$id;
	$query=mysql_query($sql);
	$ourphp_rs=mysql_fetch_array($query);
	return '<a href="'.$ourphp_webpath.'?'.$ourphp_rs[3].'-'.$type.'-'.$ourphp_rs[1].'-'.$ourphp_rs[0].'.html" target="_blank">'.$ourphp_rs[2].'</a>';
break;

case "photoview":
	$sql="select id,OP_Class,OP_Phototitle,OP_Lang from `ourphp_photo` where id = ".$id;
	$query=mysql_query($sql);
	$ourphp_rs=mysql_fetch_array($query);
	return '<a href="'.$ourphp_webpath.'?'.$ourphp_rs[3].'-'.$type.'-'.$ourphp_rs[1].'-'.$ourphp_rs[0].'.html" target="_blank">'.$ourphp_rs[2].'</a>';
break;

case "downview":
	$sql="select id,OP_Class,OP_Downtitle,OP_Lang from `ourphp_down` where id = ".$id;
	$query=mysql_query($sql);
	$ourphp_rs=mysql_fetch_array($query);
	return '<a href="'.$ourphp_webpath.'?'.$ourphp_rs[3].'-'.$type.'-'.$ourphp_rs[1].'-'.$ourphp_rs[0].'.html" target="_blank">'.$ourphp_rs[2].'</a>';
break;

case "jobview":
	$sql="select id,OP_Class,OP_Jobtitle,OP_Lang from `ourphp_job` where id = ".$id;
	$query=mysql_query($sql);
	$ourphp_rs=mysql_fetch_array($query);
	return '<a href="'.$ourphp_webpath.'?'.$ourphp_rs[3].'-'.$type.'-'.$ourphp_rs[1].'-'.$ourphp_rs[0].'.html" target="_blank">'.$ourphp_rs[2].'</a>';
break;

case "videoview":
	$sql="select id,OP_Class,OP_Videotitle,OP_Lang from `ourphp_video` where id = ".$id;
	$query=mysql_query($sql);
	$ourphp_rs=mysql_fetch_array($query);
	return '<a href="'.$ourphp_webpath.'?'.$ourphp_rs[3].'-'.$type.'-'.$ourphp_rs[1].'-'.$ourphp_rs[0].'.html" target="_blank">'.$ourphp_rs[2].'</a>';
break;

case "productview":
	$sql="select id,OP_Class,OP_Title,OP_Lang from `ourphp_product` where id = ".$id;
	$query=mysql_query($sql);
	$ourphp_rs=mysql_fetch_array($query);
	return '<a href="'.$ourphp_webpath.'?'.$ourphp_rs[3].'-'.$type.'-'.$ourphp_rs[1].'-'.$ourphp_rs[0].'.html" target="_blank">'.$ourphp_rs[2].'</a>';
break;
}

}
$gett = $_GET['opcms'];
function Commentlist(){
	global $_page,$conn,$smarty,$gett;
	$listpage = 50;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_comment` order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select * from `ourphp_comment` where OP_Type = '".$gett."' order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs['id'],
						"content" => $ourphp_rs['OP_Content'],
						"class" => $ourphp_rs['OP_Class'],
						"type" => $ourphp_rs['OP_Type'],
						"name" => $ourphp_rs['OP_Name'],
						"ip" =>$ourphp_rs['OP_Ip'],
						"vote" => $ourphp_rs['OP_Vote'],
						"scoring" => explode('|',$ourphp_rs['OP_Scoring']),
						"gocontent" => $ourphp_rs['OP_Gocontent'],
						"gotime" => $ourphp_rs['OP_Gotime'],
						"time" => $ourphp_rs['time'],
						"sj" => ourphp_comment($ourphp_rs['OP_Class'],$ourphp_rs['OP_Type']),
					);
	$i = $i + 1;
	}
	$_page = new Page($ourphptotal['tiaoshu'],$listpage);
	$smarty->assign('ourphppage',$_page->showpage());
	return $rows;
	mysql_free_result($query);
}

$smarty->assign("comment",Commentlist());
$smarty->display('ourphp_comment.html');
?>