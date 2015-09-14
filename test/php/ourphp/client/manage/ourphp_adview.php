<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php';
include '../../function/ourphp_navigation.class.php';

if(isset($_GET["ourphp_cms"]) == ""){
	echo '';
}elseif ($_GET["ourphp_cms"] == "edit"){

			if (!empty($_POST["OP_Adclass"])){
			$OP_Adclass = implode(',',$_POST["OP_Adclass"]);
			}else{
			$OP_Adclass = '';
			}
			
			$sql="update `ourphp_ad` set 
			`OP_Adcontent` = '".admin_sql($_POST["OP_Adcontent"])."',
			`OP_Adclass` = '".$OP_Adclass."',
			`time` = '".date("Y-m-d H:i:s")."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_ad.php?id=ourphp';
			require 'ourphp_remind.php';
			
}

$sql="select * from `ourphp_ad` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_ad',$ourphp_rs);

//运行环境
$ourphp_text2=explode(",",$ourphp_rs['OP_Adclass']);
for($o=0;$o<sizeof($ourphp_text2);$o++){ 
$selected2[] = $ourphp_text2[$o]; 
} 
$smarty->assign('selected2',$selected2); 
$ourphph_qx2=array('首页','文章','商品','图集','视频','下载','招聘','单页面'); 
$smarty->assign('ourphph_qx2',$ourphph_qx2);

mysql_free_result($query);
$smarty->display('ourphp_adview.html');
?>