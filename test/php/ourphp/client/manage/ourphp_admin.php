<?php
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/

include '../../config/ourphp_code.php';
include '../../config/ourphp_config.php';
include '../../config/ourphp_version.php';
include '../../config/ourphp_Language.php';
include '../../function/ourphp_function.class.php';
include '../../function/ourphp/Smarty.class.php';

$ourphp_templates = "templates/";
$ourphp_templates_c = "../../function/_compile/";
$ourphp_cache = "../../function/_cache/";
$ourphp_bgcolor = "onmouseover=this.style.backgroundColor='#FFFFCC' onmouseout=this.style.backgroundColor='#ffffff'";

date_default_timezone_set('Asia/Shanghai');
$smarty = new Smarty;
$smarty->caching = false; 
$smarty->setTemplateDir($ourphp_templates);
$smarty->setCompileDir($ourphp_templates_c);
$smarty->setCacheDir($ourphp_cache);

$smarty->assign('ourphp','<h1>hello,ourphp!</h1>');
$smarty->assign('ourphp_access',$ourphp_access);
$smarty->assign('version',$ourphp_version);
$smarty->assign('versiondate',$ourphp_versiondate);
$smarty->assign('webpath',$ourphp_webpath);
$smarty->assign('adminpath',$ourphp_adminpath);
$smarty->assign('templatepath',$ourphp_templates);
$smarty->assign('ourphp_empower',$ourphp_empower);
$smarty->assign('ourphp_adminfont',$ourphp_adminfont);
$smarty->assign('ourphp_bgcolor',$ourphp_bgcolor);

function Admin_click($webname='模板标签调用',$weburl='outphp_tag.php'){

	$sql="select `id`,`OP_Title`,`OP_Url`,`OP_Click` from `ourphp_adminclick` where OP_Title = '".$webname."'";
	$query=mysql_query($sql);
	
	if(!mysql_num_rows($query)){
		$sql="insert into `ourphp_adminclick` set `OP_Title` = '".$webname."',`OP_Url` = '".$weburl."',`OP_Click` = 0";
		$query=mysql_query($sql);
	}else{
		$sql="update `ourphp_adminclick` set `OP_Click` = `OP_Click` + 1 where OP_Title = '".$webname."'";
		$query=mysql_query($sql);
	}
	
}
?>