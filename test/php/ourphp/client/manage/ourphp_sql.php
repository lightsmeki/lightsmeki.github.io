<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php'; 

if (isset($_GET["ourphp_cms"]) == "add"){

	if($_POST["kl"] == ''){
	
							$ourphp_font = 4;
							$ourphp_content = '口令码不能为空!';
							$ourphp_class = 'ourphp_sql.php?id=ourphp';
							require 'ourphp_remind.php';
							
	}elseif($_POST["kl"] != $ourphp_validation){
	
							$ourphp_font = 4;
							$ourphp_content = '口令码错误!';
							$ourphp_class = 'ourphp_sql.php?id=ourphp';
							require 'ourphp_remind.php';

	}elseif($_POST["sql"] == ''){
	
							$ourphp_font = 4;
							$ourphp_content = 'SQL语句不能为空!';
							$ourphp_class = 'ourphp_sql.php?id=ourphp';
							require 'ourphp_remind.php';

	
	}
	
$sql = stripslashes($_POST['sql']);
$query = @mysql_query($sql);	

if(mysql_affected_rows() > 0) {

							$ourphp_font = 5;
							$ourphp_img = 'ok.png';
							$ourphp_content = 'SQL执行成功!';
							$ourphp_class = 'ourphp_sql.php?id=ourphp';
							require 'ourphp_remind.php';
							
}else{

							$ourphp_font = 5;
							$ourphp_img = 'no.png';
							$ourphp_content = 'SQL执行失败!';
							$ourphp_class = 'ourphp_sql.php?id=ourphp';
							require 'ourphp_remind.php';
}

}

$smarty->display('ourphp_sql.html');
?>