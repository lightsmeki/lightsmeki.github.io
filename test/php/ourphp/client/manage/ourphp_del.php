<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/

function ourphp_imgdel($minimg='',$maximg='',$imgimg=''){
	global $conn;
	$sql=mysql_query("select `OP_Webfile` from `ourphp_webdeploy` where id = 1");
	$ourphp_rs=mysql_fetch_array($sql);
	if($ourphp_rs[0] == 2){
		if($minimg != ''){
			if (file_exists('../../'.$minimg)){
			unlink('../../'.$minimg);
			}
		}
		if($maximg != ''){
			if (file_exists('../../'.$maximg)){
			unlink('../../'.$maximg);
			}
		}
		if($imgimg != ''){
			$img = explode('|',$imgimg);
			foreach($img as $op){
			$delimg .= unlink('../../'.$op);
			}
		}
	}else{
		echo '';
	}
}
?>