<?php
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
session_start();

if(isset($_SESSION['ourphp_outtime'])) {

    if($_SESSION['ourphp_outtime'] < time()) {
        unset($_SESSION['ourphp_outtime']);
        echo '登录超时或未登录，请重新登录！';
        exit(0);
    } else {
        $_SESSION['ourphp_outtime'] = time() + 3600;
    }
	
}else{
		echo '登录超时或未登录，请重新登录！';
		exit(0);
}

$sql="select id,OP_Adminname,OP_Adminpass,OP_Adminpower,OP_Admin from `ourphp_admin` where `OP_Adminname` = '".$_SESSION['ourphp_adminname']."'";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$id = $ourphp_rs[0];
$OP_Adminname = $ourphp_rs[1];
$OP_Adminpass = $ourphp_rs[2];
$OP_Adminpower = $ourphp_rs[3];
$OP_Admin = $ourphp_rs[4];
mysql_free_result($query);

?>