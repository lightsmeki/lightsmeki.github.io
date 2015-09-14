<?php
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include './config/ourphp_code.php';
include './config/ourphp_config.php';
include './config/ourphp_version.php';
include './config/ourphp_Language.php';
include './function/ourphp_function.class.php';
include './function/ourphp/Smarty.class.php';

if (isset($_GET['ourphp_admin']) == "login") {

	if ($_REQUEST["ourphp_kouling"] != $ourphp_validation) {
		exit("<script language=javascript> alert('".$ourphp_adminfont['klerror']."');history.back(-1);</script>");
	}
	$loginname = dowith_sql($_REQUEST["loginname"]);
	$loginpass = dowith_sql(substr(md5(md5($_REQUEST["loginpass"])),0,16));
	
    $sql = "select id,OP_Admin from ourphp_admin where OP_Adminname = '".$loginname."' and OP_Adminpass = '".$loginpass."'";
    $result = mysql_query($sql);
    $ourphp_rs=mysql_fetch_array($result);
	
    if(mysql_num_rows($result) == 0){
		exit("<script language=javascript> alert('".$ourphp_adminfont['loginerror']."');history.back(-1);</script>");
    }else{
		session_start();
		$_SESSION['ourphp_adminname'] = $loginname;
		$_SESSION['ourphp_outtime'] = time() + 3600;
		
		if ($ourphp_rs[1] == 1){
			echo "<script>location.href='".$_SERVER['PHP_SELF']."?ourphp=admin';</script>";
			exit();
				}elseif ($ourphp_rs[1] == 2){
			echo "<script>location.href='".$_SERVER['PHP_SELF']."?ourphp=admin';</script>";
			exit();
		}
    }
    mysql_close($conn);
}

$ourphp_templates = $ourphp_adminpath."/templates/";
$ourphp_templates_c = "function/_compile/";
$ourphp_cache = "function/_cache/";

$smarty = new Smarty;
$smarty->caching = false; 
$smarty->setTemplateDir($ourphp_templates);
$smarty->setCompileDir($ourphp_templates_c);
$smarty->setCacheDir($ourphp_cache);

$smarty->assign('ourphp','<h1>hello,ourphp!</h1>');
$smarty->assign('ourphp_access',$ourphp_access);
$smarty->assign('version',$ourphp_version);
$smarty->assign('webpath',$ourphp_webpath);
$smarty->assign('adminpath',$ourphp_adminpath);
$smarty->assign('templatepath',$ourphp_templates);
$smarty->assign('ourphp_empower',$ourphp_empower);
$smarty->assign('ourphp_adminfont',$ourphp_adminfont);
@include './'.$ourphp_adminpath.'/ourphp_userwebzz.php';
$smarty->assign('empower',ourphpempower()); 

if (isset($_GET['ourphp']) == "") {

	$smarty->display('ourphp_login.html');
	
		}elseif ($_GET['ourphp'] == "admin") {
		
		include './'.$ourphp_adminpath.'/ourphp_checkadmin.php';
		$smarty->assign('id',$id);
		$smarty->assign('OP_Adminname',$OP_Adminname);
		$smarty->assign('OP_Adminpass',$OP_Adminpass);
		$smarty->assign('OP_Adminpower',$OP_Adminpower);
		$smarty->assign('ourphp_out',$_SERVER['PHP_SELF']);
		$smarty->assign('ourphp_switch',array('weixin'=>$ourphp_weixin,'yixin'=>$ourphp_yixin));
		
		function Ourphp_Admin_click(){
			global $conn;
			$sql="select `id`,`OP_Title`,`OP_Url`,`OP_Click` from `ourphp_adminclick` order by OP_Click desc LIMIT 0,15";
			$query=mysql_query($sql);
			$rows=array();
			while($ourphp_rs=mysql_fetch_array($query)){
				$rows[]=array(
								"id" => $ourphp_rs[0],
								"Click_title" => $ourphp_rs[1],
								"Click_url" => $ourphp_rs[2]
							);
			}
			return $rows;
			mysql_free_result($query);
		}
		
		function Pluslist(){
			global $conn,$smarty,$ourphp_webpath,$ourphp_adminpath;
			$sql="select OP_Name,OP_Pluspath from `ourphp_plus` order by id desc";
			$query=mysql_query($sql);
			$rows=array();
			$i = 1;
			while($ourphp_rs=mysql_fetch_array($query)){
				$rows[]=array(
								"i" => $i,
								"name" => $ourphp_rs[0],
								"pluspath" => $ourphp_webpath.'client/plus/'.$ourphp_rs[1],
								"pluspath2" => $ourphp_rs[1],
							);
			$i = $i + 1;
			}
			return $rows;
			mysql_free_result($query);
		}

		$smarty->assign('ourphp_click',Ourphp_Admin_click());
		$smarty->assign('Pluslist',Pluslist());
		
		if ($OP_Admin == 1){
			$smarty->display('ourphp_index.html');
				}elseif ($OP_Admin == 2){
			$smarty->display('ourphp_assist.html');
		}else{
			echo $ourphp_adminfont['accessno'];
			exit(0);
		}
}
?>