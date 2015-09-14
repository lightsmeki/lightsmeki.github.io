<?php
/*
	插件管理引用文件
*/
include '../../../config/ourphp_code.php';
include '../../../config/ourphp_config.php';
include '../../../config/ourphp_version.php';
include '../../../config/ourphp_Language.php';
include '../../../function/ourphp_function.class.php';

session_start();
date_default_timezone_set('Asia/Shanghai');

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
?>