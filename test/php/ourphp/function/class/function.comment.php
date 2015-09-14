<?php
/*
 * Ourphp - CMS建站系统
 * Copyright (C) 2014 ourphp.net
 * 开发者：哈尔滨伟成科技有限公司
*/
if(!defined('OURPHPNO')){exit('no!');}

function smarty_function_comment($params, &$smarty){

		global $db,$ourphp_access,$ourphp_webpath;
		extract($params);
		$type = isset($params['type'])?$params['type']:0;
		
		$ourphp_rs = $db-> ourphpsql("select `OP_Webocomment`,`OP_Webpcomment` from `ourphp_webdeploy` where id = 1"); 
		$OP_Webocomment = $ourphp_rs[0];
		$OP_Webpcomment = $ourphp_rs[1];
		
		$OP_Class = isset($params['id'])?$params['id']:"0";
		$OP_Type = isset($params['type'])?$params['type']:"articleview";
		$OP_Row = isset($params['row'])?$params['row']:"10";
		$userlogin = '游客';
		
		
		$query = $db-> sqllist("select * from `ourphp_comment` where OP_Class = '".$OP_Class."' && OP_Type = '".$OP_Type."' order by time desc LIMIT 0,".$OP_Row);
		$rs=array();
		$i = 1;
		while($ourphp_rsrs=mysql_fetch_array($query)){
		
		$userip = preg_replace('/((?:\d{1,3}\.){3})\d{1,3}/','$1*',$ourphp_rsrs['OP_Ip']);
		if($ourphp_rsrs['OP_Name'] == $userlogin){
		$username = $ourphp_rsrs['OP_Name'];
		}else{
		$username = half_replace($ourphp_rsrs['OP_Name']);
		}
		
				$rs[]=array (
								"i" => $i,
								"id" => $ourphp_rsrs['id'],
								"content" => $ourphp_rsrs['OP_Content'],
								"class" => $ourphp_rsrs['OP_Class'],
								"type" => $ourphp_rsrs['OP_Type'],
								"name" => $username,
								"ip" => $userip,
								"vote" => $ourphp_rsrs['OP_Vote'],
								"scoring" => explode('|',$ourphp_rsrs['OP_Scoring']),
								"gocontent" => $ourphp_rsrs['OP_Gocontent'],
								"gotime" => $ourphp_rsrs['OP_Gotime'],
								"time" => $ourphp_rsrs['time'],
							);
			$i+=1;
		}

if($OP_Webpcomment == 4){
		if(isset($_SESSION['username'])){
		$username = $_SESSION['username'];
		}else{
		$username = '0';
		}
		$query = $db-> sqllist("select `id` from `ourphp_orders` where OP_Ordersid = ".$OP_Class." && OP_Ordersemail = '".$username."'");
		$num=mysql_num_rows($query);
		if ($num == 0){
		$smarty->assign('userbuy','2');
		}else{
		$smarty->assign('userbuy','1');
		}
}else{
		$smarty->assign('userbuy','2');
}

$smarty->assign('webocomment',$OP_Webocomment);
$smarty->assign('webpcomment',$OP_Webpcomment);
$smarty->assign('comment',$rs);
$smarty->assign('plugsurl',$ourphp_webpath.'function/plugs/Comment/');

if ($OP_Type == 'productview'){
$smarty->display(WEB_ROOT.'/function/plugs/Comment/product-index.html');
}else{
$smarty->display(WEB_ROOT.'/function/plugs/Comment/article-index.html');
}

return ;
mysql_free_result($query);

}
?>