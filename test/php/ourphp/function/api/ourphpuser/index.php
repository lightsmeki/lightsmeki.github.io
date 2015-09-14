<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
 *-------------------------------
 * OURPHP系统 会员处理接口
 *-------------------------------
*/
$apikey = "ourphp";

include '../../../config/ourphp_code.php';
include '../../../config/ourphp_config.php';
include '../../../config/ourphp_version.php';
include '../../../config/ourphp_Language.php';
include '../../ourphp_function.class.php';
include 'ourphp_system.php';

if($key != $apikey || $apikey == "ourphp"){
	echo "Parameter error!";
	exit;
}
if($type == "reg"){
	echo user_reg($useremail,$username,$password,$passwordto);
}elseif($type == "login"){
	echo user_login($useremail,$password);
}elseif($type == "out"){
	echo user_out($useremail);
}else{
	echo "Parameter error!";
}
?>