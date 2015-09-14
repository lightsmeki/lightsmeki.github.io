<?php
if(version_compare(PHP_VERSION,'5.0.0','<'))  die('错误！您的PHP版本不能低于 5.0.0 !');
if (!file_exists("../../function/install/ourphp.lock")) {
	header("location: ../../function/install/index.php");
	exit;
}
include '../../config/ourphp_code.php';
include '../../config/ourphp_config.php';
include '../../config/ourphp_version.php';
include '../../config/ourphp_Language.php';
include '../../function/ourphp_function.class.php';
include '../../function/ourphp/Smarty.class.php';
include './ourphp_system.class.php';
include './ourphp_template.class.php';
?>