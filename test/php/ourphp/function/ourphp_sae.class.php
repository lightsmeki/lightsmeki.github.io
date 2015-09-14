<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

$sql="select OP_Webfenci from `ourphp_webdeploy` where id = 1";
$query=mysql_query($sql);
$ourphp_rs=mysql_fetch_array($query);

if ($ourphp_rs[0] == 1){

$word = compress_html($word);
$url = 'http://ourphp.sinaapp.com/?key='.$word;
$info = file_get_contents($url);
$info = json_decode($info,true);
//echo print_r($info);

$k = '';
$i = 0;
foreach($info as $op){
	if($i > 9){break;}
	$k .= $op['word'].',';
	$i+=1;
}

$wordtag = substr($k, 0, -1); 

}else{

$wordtag = $tag;

}
mysql_free_result($query);
?>

