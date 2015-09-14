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

			$OP_Photoclass = explode("|",admin_sql($_POST["OP_Photoclass"]));
			if ($OP_Photoclass[0] == 0){
			$ourphp_font = 4;
			$ourphp_content = $ourphp_adminfont['nocolumn'];
			$ourphp_class = 'ourphp_photo.php?id=ourphp';
			require 'ourphp_remind.php';
			exit;
			}
			$ourphp_xiegang = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Photocminimg"]));
			$OP_Photoimg = str_replace($ourphp_webpath."function","function",admin_sql($_POST["OP_Photoimg"]));
			
			if (!admin_sql($_POST["OP_Photodescription"])){
				$OP_Photocontent = utf8_strcut(strip_tags(admin_sql($_POST["OP_Photocontent"])), 0, 200);
			}else{
				$OP_Photocontent = admin_sql($_POST["OP_Photodescription"]);
			}

			//分词
			$word = $OP_Photocontent;
			$tag = admin_sql($_POST["OP_Phototag"]);
			include '../../function/ourphp_sae.class.php';
			//结束
			
			if (!empty($_POST["OP_Photoattribute"])){
			$OP_Photoattribute = implode(',',$_POST["OP_Photoattribute"]);
			}else{
			$OP_Photoattribute = '';
			}
			
			$sql="insert into `ourphp_photo` set 
			`OP_Phototitle` = '".admin_sql($_POST["OP_Phototitle"])."',
			`time` = '".date("Y-m-d H:i:s")."',
			`OP_Photocminimg` = '".$ourphp_xiegang."',
			`OP_Photoimg` = '".$OP_Photoimg."',
			`OP_Photocontent` = '".admin_sql($_POST["OP_Photocontent"])."',
			`OP_Class` = '".$OP_Photoclass[0]."',
			`OP_Lang` = '".$OP_Photoclass[1]."',
			`OP_Tag` = '".$wordtag."',
			`OP_Sorting` = '".admin_sql($_POST["OP_Photosorting"])."',
			`OP_Attribute` = '".$OP_Photoattribute."',
			`OP_Url` = '".admin_sql($_POST["OP_Photourl"])."',
			`OP_Description` = '".$OP_Photocontent."',
			`OP_Callback` = 0
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_photo.php?id=ourphp';
			require 'ourphp_remind.php';
}

$op= new Tree(columnlist(""));
$arr=$op->leaf();
$smarty->assign('photolist',$arr);
$smarty->display('ourphp_photoadd.html');
?>