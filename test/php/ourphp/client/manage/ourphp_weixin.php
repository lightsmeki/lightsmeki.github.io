<?php 
/*******************************************************************************
* Ourphp - CMS建站系统
* Copyright (C) 2014 ourphp.net
* 开发者：哈尔滨伟成科技有限公司
*******************************************************************************/
include 'ourphp_admin.php';
include 'ourphp_checkadmin.php'; 
$weburl = $_SERVER['HTTP_HOST'];
$sql = "select `OP_Key` from `ourphp_api` where `id` = 5"; 
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);
$api = explode('|',$ourphp_rs[0]);


#判断接口是否开启
if ($api[1] == 2){
		exit($api[0].$ourphp_adminfont['plugsno']);
}
#接口查询结束
#调用方式：$api[0] 表示API名称，$api[1] 表示开关，$api[2~N] API值

if($api[2] == '0' || $api[3] == '0'){
		exit($api[0].$ourphp_adminfont['plugsno']);
}

if($weburl == '127.0.0.1' || $weburl == 'localhost' || substr($weburl,0,3) == '192'){
exit("域名无法开通服务，请联系OURPHP客服。");
}


echo '<script src="../../function/plugs/jquery/1.7.2/jquery-1.7.2.min.js"></script>';
echo '<script src="../../function/plugs/layer/layer.min.js"></script>';
echo '<script>';
echo '    parent.$.layer({';
echo '        type: 2,';
echo '        title: \'微信管理平台\',';
echo '        shade: [0],';
echo '		  border: [5, 0.3, \'#000\'],';
echo '        area: [\'1360px\', \'700px\'],';
echo '		  iframe:{src: \'http://weixin.ourphp.net/index.php?g=Home&m=Index&a=login&user='.$api[2].'&pass='.$api[3].'\',scrolling: \'yes\'}';
echo '    });';
echo '</script>';

mysql_free_result($query);
?>