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
			
			if (!empty($_POST["OP_Photoimg2"])){
			$OP_Photoimg2 = implode('|',$_POST["OP_Photoimg2"]);
				if (!empty($OP_Photoimg)){
				$OP_img = $OP_Photoimg2.'|'.$OP_Photoimg;
				}else{
				$OP_img = $OP_Photoimg2;
				}
			}else{
			$OP_Photoimg2 = '';
			$OP_img = $OP_Photoimg;
			}
			
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
			
			//`OP_Photoimg` = CONCAT_WS('|',`OP_Photoimg`,'".$OP_Photoimg.$OP_Photoimg2."'),
			$sql="update `ourphp_photo` set 
			`OP_Phototitle` = '".admin_sql($_POST["OP_Phototitle"])."',
			`time` = '".date("Y-m-d H:i:s")."',
			`OP_Photocminimg` = '".$ourphp_xiegang."',
			`OP_Photoimg` = '".$OP_img."',
			`OP_Photocontent` = '".admin_sql($_POST["OP_Photocontent"])."',
			`OP_Class` = '".$OP_Photoclass[0]."',
			`OP_Lang` = '".$OP_Photoclass[1]."',
			`OP_Tag` = '".$wordtag."',
			`OP_Sorting` = '".admin_sql($_POST["OP_Photosorting"])."',
			`OP_Attribute` = '".$OP_Photoattribute."',
			`OP_Url` = '".admin_sql($_POST["OP_Photourl"])."',
			`OP_Description` = '".$OP_Photocontent."'
			 where id = ".intval($_GET["id"])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_photo.php?id=ourphp&page='.$_GET["page"];
			require 'ourphp_remind.php';

					
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_photo.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
}

$op= new Tree(columnlist(""));
$arr=$op->leaf();
$smarty->assign('photolist',$arr);

$sql="select * from `ourphp_photo` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_photo',$ourphp_rs);
$ourphp_text=explode(",",$ourphp_rs['OP_Attribute']);
for($i=0;$i<sizeof($ourphp_text);$i++){ 
$selected[] = $ourphp_text[$i];
}
$smarty->assign('selected',$selected); 
$ourphph_qx=array('头条','热门','滚动','推荐'); 
$smarty->assign('ourphph_qx',$ourphph_qx); 

if ($ourphp_rs['OP_Photoimg'] != ''){
$OP_Photoimg = explode("|",$ourphp_rs['OP_Photoimg']);
$i = 1;
foreach($OP_Photoimg as $u){
    $OP_Photoimgarr = explode("|",$u);
    foreach($OP_Photoimgarr as $newstr){
        $rows[]=array(
						"i" => $i,
						"img" => $newstr,
					); 
					$i = $i + 1;
    }
}
}else{
$rows = '';
}
$smarty->assign('photoimglist',$rows);
mysql_free_result($query);
$smarty->display('ourphp_photoedit.html');
?>