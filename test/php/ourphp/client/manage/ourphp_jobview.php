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
		
			$OP_Jobclass = explode("|",admin_sql($_POST["OP_Jobclass"]));
			if ($OP_Jobclass[0] == 0){
			$ourphp_font = 4;
			$ourphp_content = $ourphp_adminfont['nocolumn'];
			$ourphp_class = 'ourphp_job.php?id=ourphp';
			require 'ourphp_remind.php';
			exit;
			}
		
			if (!admin_sql($_POST["OP_Jobdescription"])){
				$OP_Jobcontent = utf8_strcut(strip_tags(admin_sql($_POST["OP_Jobcontent"])), 0, 200);
			}else{
				$OP_Jobcontent = admin_sql($_POST["OP_Jobdescription"]);
			}
			
			//分词
			$word = $OP_Jobcontent;
			$tag = admin_sql($_POST["OP_Jobtag"]);
			include '../../function/ourphp_sae.class.php';
			//结束
			
			$OP_Jobclass = explode("|",admin_sql($_POST["OP_Jobclass"]));
			
			if (!empty($_POST["OP_Jobattribute"])){
			$OP_Jobattribute = implode(',',$_POST["OP_Jobattribute"]);
			}else{
			$OP_Jobattribute = '';
			}
			
			$sql="update `ourphp_job` set 
			`OP_Jobtitle` = '".admin_sql($_POST["OP_Jobtitle"])."',
			`time` = '".date("Y-m-d H:i:s")."',
			`OP_Jobwork` = '".admin_sql($_POST["OP_Jobwork"])."',
			`OP_Jobadd` = '".admin_sql($_POST["OP_Jobadd"])."',
			`OP_Jobnature` = '".admin_sql($_POST["OP_Jobnature"])."',
			`OP_Jobexperience` = '".admin_sql($_POST["OP_Jobexperience"])."',
			`OP_Jobeducation` = '".admin_sql($_POST["OP_Jobeducation"])."',
			`OP_Jobnumber` = '".admin_sql($_POST["OP_Jobnumber"])."',
			`OP_Jobage` = '".admin_sql($_POST["OP_Jobage"])."',
			`OP_Jobwelfare` = '".admin_sql($_POST["OP_Jobwelfare"])."',
			`OP_Jobwage` = '".admin_sql($_POST["OP_Jobwage"])."',
			`OP_Jobcontact` = '".admin_sql($_POST["OP_Jobcontact"])."',
			`OP_Jobtel` = '".admin_sql($_POST["OP_Jobtel"])."',
			`OP_Jobcontent` = '".admin_sql($_POST["OP_Jobcontent"])."',
			`OP_Class` = '".$OP_Jobclass[0]."',
			`OP_Lang` = '".$OP_Jobclass[1]."',
			`OP_Tag` = '".$wordtag."',
			`OP_Sorting` = '".admin_sql($_POST["OP_Jobsorting"])."',
			`OP_Attribute` = '".$OP_Jobattribute."',
			`OP_Url` = '".admin_sql($_POST["OP_Joburl"])."',
			`OP_Description` = '".$OP_Jobcontent."'
			 where id = ".intval($_GET['id'])."";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_job.php?id=ourphp&page='.$_GET["page"];
			require 'ourphp_remind.php';

		
		}else{
			
		$ourphp_font = 4;
		$ourphp_content = '权限不够，无法编辑内容！';
		$ourphp_class = 'ourphp_job.php?id=ourphp';
		require 'ourphp_remind.php';
			
		}
		
}

$op= new Tree(columnlist(""));
$arr=$op->leaf();
$smarty->assign('joblist',$arr);

$sql="select * from `ourphp_job` where `id` = ".intval($_GET['id'])."";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$smarty->assign('ourphp_job',$ourphp_rs);

//属性
$ourphp_text=explode(",",$ourphp_rs['OP_Attribute']);
for($i=0;$i<sizeof($ourphp_text);$i++){ 
$selected[] = $ourphp_text[$i]; 
}
$smarty->assign('selected',$selected); 
$ourphph_qx=array('头条','热门','滚动','推荐'); 
$smarty->assign('ourphph_qx',$ourphph_qx); 

mysql_free_result($query);
$smarty->display('ourphp_jobview.html');
?>