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
			
			if (!empty($_POST["OP_Jobattribute"])){
			$OP_Jobattribute = implode(',',$_POST["OP_Jobattribute"]);
			}else{
			$OP_Jobattribute = '';
			}
				
			$sql="insert into `ourphp_job` set 
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
			`OP_Description` = '".$OP_Jobcontent."',
			`OP_Callback` = 0
			";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_job.php?id=ourphp';
			require 'ourphp_remind.php';
			
}elseif ($_GET["ourphp_cms"] == "del"){

			if (strstr($OP_Adminpower,"35")){
			
			$sql="delete from ourphp_job where id = ".intval($_GET['id']);
			$query=mysql_query($sql);
			$ourphp_font = 2;
			$ourphp_class = 'ourphp_job.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
			
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法删除！';
			$ourphp_class = 'ourphp_job.php?id=ourphp';
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
			header("location: ./ourphp_cmd.php?id=$op_b&lx=h&xx=job");
			exit;
			}elseif($_POST["h"] == "y") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=y&xx=job");
			exit;
			}elseif($_POST["h"] == "s") {
			header("location: ./ourphp_cmd.php?id=$op_b&lx=s&xx=job");
			exit;
			}
			
			if (!empty($_POST["OP_Jobattribute"])){
			$OP_Jobattribute = implode(',',$_POST["OP_Jobattribute"]);
			}else{
			$OP_Jobattribute = '';
			}
				
			$sql="update ourphp_job set 
			`OP_Attribute` = '".$OP_Jobattribute."'
			 where id in ($op_b)";
			$query=mysql_query($sql);
			$ourphp_font = 1;
			$ourphp_class = 'ourphp_job.php?id=ourphp';
			require 'ourphp_remind.php';
			
			}else{
				
			$ourphp_font = 4;
			$ourphp_content = '权限不够，无法编辑内容！';
			$ourphp_class = 'ourphp_job.php?id=ourphp';
			require 'ourphp_remind.php';
				
			}	
			
}

function columncycle($id=1){
	global $conn;
	$sql="select `OP_Columntitle` from `ourphp_column` where id = $id";
	$ourphp_rs=mysql_fetch_array(mysql_query($sql));
	return $ourphp_rs[0];
}

function Joblist(){
	global $_page,$conn,$smarty;
	$listpage = 25;
	if (intval(isset($_GET['page'])) == 0){
		$listpagesum = 1;
			}else{
		$listpagesum = intval($_GET['page']);
	}
	$start=($listpagesum-1)*$listpage;
	$ourphptotal=mysql_query("select count(id) as tiaoshu from `ourphp_job` where `OP_Callback` = 0 order by id desc");
	$ourphptotal=mysql_fetch_assoc($ourphptotal);
	$sql="select id,OP_Jobtitle,time,OP_Jobwork,OP_Class,OP_Lang from `ourphp_job` where `OP_Callback` = 0 order by id desc LIMIT ".$start.",".$listpage;
	$query=mysql_query($sql);
	$rows=array();
	$i = 1;
	while($ourphp_rs=mysql_fetch_array($query)){
		$rows[]=array(
						"i" => $i,
						"id" => $ourphp_rs[0],
						"title" => $ourphp_rs[1],
						"time" => $ourphp_rs[2],
						"work" => $ourphp_rs[3],
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
$smarty->assign('joblist',$arr);

Admin_click('招聘管理','ourphp_job.php?id=ourphp');
$smarty->assign("job",Joblist());
$smarty->display('ourphp_job.html');
?>