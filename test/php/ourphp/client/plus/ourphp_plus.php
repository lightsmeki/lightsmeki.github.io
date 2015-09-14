<?php
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

include '../../../config/ourphp_config.php';
include '../../../config/ourphp_version.php';
include '../../../config/ourphp_Language.php';
include '../../../function/ourphp_function.class.php';

if($plugmysql != ""){
	$field = '';
	foreach ($plugfield as $opcms){
		$field .=str_replace("|"," ",$opcms).",";
	}
	$field = substr($field ,0 ,-1);
	$sqladd="create table ourphp_p_".$plugmysql."(id int unsigned not null auto_increment primary key, ".$field.")default charset=utf8";   
	if(mysql_query($sqladd)){
		echo "恭喜你，插件安装成功了!";
			}else{
		echo "插件数据表创建出错，错误原因：".mysql_error();
		exit;
	}
}else{
	echo "恭喜你，插件安装成功了!";
}

$sql="insert into `ourphp_plus` set 
`OP_Name` = '".$plugname."',
`OP_Version` = '".$plugversion."',
`OP_Versiondate` = '".$plugversiondate."',
`OP_Author` = '".$plugauthor."',
`OP_Fraction` = '0',
`OP_About` = '".$plugabout."',
`OP_Pluspath` = '".$plugid.'/'.$plugadminurl."',
`OP_Time` = '".date("Y-m-d H:i:s")."',
`OP_Off` = 1,
`OP_Plugid` = '".$plugid."',
`OP_Plugclass` = '".$plugclass."',
`OP_Plugmysql` = '".$plugmysql."'
";
$query=mysql_query($sql);

if($plugclass != ""){
$file_q = "op_".$plugid.".php";
$file_h = WEB_ROOT."/function/data/op_".$plugid.".php";
$file_c = WEB_ROOT."/function/data/".$plugclass.".".$plugid.".php";
copy($file_q,$file_h);
rename($file_h, $file_c);
}

echo '<meta http-equiv="Refresh" content="1;URL=../../../'.$ourphp_adminpath.'/ourphp_plug.php?id=ourphp" />';
exit(0);
?>