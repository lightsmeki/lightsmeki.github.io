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

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
	}elseif ($_GET["ourphp_cms"] == "cmd"){
	
	if($_POST["lx"]=="y"){
	
			if($_POST["lm"] == 0){
				exit($ourphp_adminfont['accessno']);
			}
			$sql="update ourphp_".$_POST["xx"]." set `OP_Class` = ".$_POST["lm"]." where id in (".$_POST["id"].")";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_'.$_POST["xx"].'.php?id=ourphp';
			require 'ourphp_remind.php';
			
	}elseif($_POST["lx"]=="s"){
	
			$op_b = explode(',',$_POST["id"]);
			include './ourphp_del.php';
			if($_POST["xx"]=="article"){
				for($i = 0; $i < count($op_b); $i ++){
				$sql="delete from ourphp_article where id = ".intval($op_b[$i]);
				$query=mysql_query($sql);
				}
			}elseif($_POST["xx"]=="product"){
				for($i = 0; $i < count($op_b); $i ++){
				$query=mysql_query("select `OP_Minimg`,`OP_Maximg`,`OP_Img` from `ourphp_product` where id = ".intval($op_b[$i]));
				$ourphp_rs=mysql_fetch_array($query);
				if($ourphp_rs[0] != '' || $ourphp_rs[1] != '' || $ourphp_rs[2] != ''){
					ourphp_imgdel($ourphp_rs[0],$ourphp_rs[1],$ourphp_rs[2]);
				}
				$sql="delete from ourphp_product where id = ".intval($op_b[$i]);
				$query=mysql_query($sql);
				}
			}elseif($_POST["xx"]=="photo"){
				for($i = 0; $i < count($op_b); $i ++){
				$query=mysql_query("select `OP_Photocminimg`,`OP_Photoimg` from `ourphp_photo` where id = ".intval($op_b[$i]));
				$ourphp_rs=mysql_fetch_array($query);
				if($ourphp_rs[0] != '' || $ourphp_rs[1] != ''){
					ourphp_imgdel($ourphp_rs[0],'',$ourphp_rs[1]);
				}
				$sql="delete from ourphp_photo where id = ".intval($op_b[$i]);
				$query=mysql_query($sql);
				}
			}elseif($_POST["xx"]=="video"){
				for($i = 0; $i < count($op_b); $i ++){
				$query=mysql_query("select `OP_Videoimg` from `ourphp_video` where id = ".intval($op_b[$i]));
				$ourphp_rs=mysql_fetch_array($query);
				if($ourphp_rs[0] != ''){
					ourphp_imgdel($ourphp_rs[0]);
				}
				$sql="delete from ourphp_video where id = ".intval($op_b[$i]);
				$query=mysql_query($sql);
				}
			}elseif($_POST["xx"]=="down"){
				for($i = 0; $i < count($op_b); $i ++){
				$query=mysql_query("select `OP_Downimg`,`OP_Downdurl` from `ourphp_down` where id = ".intval($op_b[$i]));
				$ourphp_rs=mysql_fetch_array($query);
				if($ourphp_rs[0] != '' || $ourphp_rs[1] != ''){
					ourphp_imgdel($ourphp_rs[0],$ourphp_rs[1],'');
				}
				$sql="delete from ourphp_down where id = ".intval($op_b[$i]);
				$query=mysql_query($sql);
				}
			}elseif($_POST["xx"]=="job"){
				for($i = 0; $i < count($op_b); $i ++){
				$sql="delete from ourphp_job where id = ".intval($op_b[$i]);
				$query=mysql_query($sql);
				}
			}
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_'.$_POST["xx"].'.php?id=ourphp';
			require 'ourphp_remind.php';

	}elseif($_POST["lx"]=="h"){
			$sql="update ourphp_".$_POST["xx"]." set `OP_Callback` = 1 where id in (".$_POST["id"].")";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_'.$_POST["xx"].'.php?id=ourphp';
			require 'ourphp_remind.php';
	}
}

$op= new Tree(columnlist(""));
$arr=$op->leaf();
$smarty->assign('articlelist',$arr);

$smarty->assign('id',$_GET["id"]);
$smarty->assign('xx',$_GET["xx"]);
$smarty->assign('lx',$_GET["lx"]);
$smarty->display('ourphp_cmd.html');
?>