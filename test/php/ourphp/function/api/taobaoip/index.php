<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
 *-------------------------------
 * 淘宝IP接口
 *-------------------------------
*/

if(getenv('HTTP_CLIENT_IP')) { 
$onlineip = getenv('HTTP_CLIENT_IP');
} elseif(getenv('HTTP_X_FORWARDED_FOR')) { 
$onlineip = getenv('HTTP_X_FORWARDED_FOR');
} elseif(getenv('REMOTE_ADDR')) { 
$onlineip = getenv('REMOTE_ADDR');
} else { 
$onlineip = $HTTP_SERVER_VARS['REMOTE_ADDR'];
}

$url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$onlineip;
$info = file_get_contents($url);
$info = json_decode($info,true);
//echo print_r($info);

$taobaoip = $info['data']['region'];

?>